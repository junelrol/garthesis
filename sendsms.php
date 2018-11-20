<?php
	require_once('bd.php');
	include('smsGateway.php');
	include('autoload.php');
	session_start();
	$id = $_GET['id'];
	$userid = $_GET['userid'];

	$getnum = mysqli_query($mycon,"SELECT * FROM tblemployee 
		INNER JOIN tblscheduling on tblscheduling.EmployeeID = tblemployee.emp_id
		INNER JOIN tbltruck on tbltruck.TruckID = tblscheduling.truckid
		WHERE tblscheduling.SchedulingID=$id");

	$row = mysqli_fetch_array($getnum);
	$number = $row['emp_contact'];
	$start = date("M jS, Y", strtotime($row['DateStart']));
	$end = date("M jS, Y", strtotime($row['DateEnd']));
	$truckbrand = $row['brand'];
	$platenum = $row['platenumber'];
	$thedate =date('h:i a', strtotime($row['thetime']));
	$exdate = explode(":", $thedate);
	$message = "You currently have a schedule at ".$thedate." from ".$start." to ".$end." using the truck with brand name ".$truckbrand." and plate number ".$platenum;

	$getQuery = mysqli_query($mycon,"SELECT * FROM tblsmsinfo WHERE smsid=1");
	$getRow = mysqli_fetch_array($getQuery);
	$getcallback = $getRow['call_back'];
	$getDevice = $getRow['iddevice'];

	$clients = new SMSGatewayMe\Client\ClientProvider($getcallback);

    $sendMessageRequest = new SMSGatewayMe\Client\Model\SendMessageRequest([
        'phoneNumber' => $number, 'message' => $message, 'deviceId' => $getDevice
    ]);

    $sentMessages = $clients->getMessageClient()->sendMessages([$sendMessageRequest]);

	// $smsGateway = new SmsGateway($getUser, $getPass);
	// $result = $smsGateway->sendMessageToNumber($number, $message, $getDevice);

	// if($result)

	$getuserid = $_SESSION['user_id'];
	$datenow = date("Y-m-d");
	$savehistory = mysqli_query($mycon,"INSERT INTO tblsmshistory (smsDetails, datesend, userid, sendedid, deviceid) VALUES('$message','$datenow', '$getuserid', '$userid', '$getDevice')");		
	echo '<script>alert("SMS sent!"); location.replace("scheduling.php");</script>';
?>