<?php

// Connection
require_once('bd.php');
//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])){
	
	//check if there is a duplication	

	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];
	$truckid = $_POST['truckid'];
	$isAvailable = 1;
	$gettime = $_POST['time'];

	$checkalldates =  mysqli_query($mycon, "SELECT * FROM tblscheduling");
	while ($rows = mysqli_fetch_array($checkalldates)) {
		$totimestart = date('Y-m-d',strtotime($start));
		$totimeend = date('Y-m-d',strtotime('-1 day',strtotime($end)));
		$totimestartrow = date('Y-m-d',strtotime($rows['DateStart']));
		$totimeendrow = date('Y-m-d',strtotime($rows['DateEnd']));
		if((($totimestart>=$totimestartrow)&&($totimestart<$totimeendrow))||(($totimeend>$totimestartrow)&&($totimeend<$totimeendrow)))
		{
			if($rows['EmployeeID']==$title||$rows["TruckID"]==$truckid)
			{
				$isAvailable=0;
				
			}
			
		}

		if((($totimestartrow>=$totimestart)&&($totimestartrow<$totimeend))||(($totimestartrow>$totimestart)&&($totimestartrow<$totimeend)))
		{
			if($rows['EmployeeID']==$title||$rows["TruckID"]==$truckid)
			{
				$isAvailable=0;
				
			}
			
		}
		
	}

	$checkquery = mysqli_query($mycon,"SELECT * FROM tblscheduling WHERE (EmployeeID='$title' OR TruckID='$truckid') AND DateStart='$start'");
	$numcheck = mysqli_num_rows($checkquery);
	if($isAvailable==0)
	{
		echo '<script>alert("Truck or Driver not available at that time"); location.replace("scheduling.php");</script>';
	}
	else
	{
		$sql = "INSERT INTO scheduling(title, start, end, color, truckid) values ('$title', '$start', '$end', '$color', $truckid)";
		//$req = $bdd->prepare($sql);
		//$req->execute();
		
		//echo $sql;
		
		// $query = $bdd->prepare( $sql );
		// if ($query == false) {
		//  print_r($bdd->errorInfo());
		//  die ('Erreur prepare');
		// }
		// $sth = $query->execute();
		// if ($sth == false) {
		//  print_r($query->errorInfo());
		//  die ('Erreur execute');
		// }


		//save to real database
		$savesql = mysqli_query($mycon,"INSERT INTO tblscheduling (EmployeeID, DateStart, DateEnd, TruckID, color, thetime) VALUES ('$title', '$start', '$end', $truckid, '$color', '$gettime')");
		echo '<script>alert("Saved"); location.replace("scheduling.php");</script>';
	}	

	


}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
