<?php

// Connexion à la base de données
require_once('bd.php');

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
	
	
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];
	$theid = $_POST['Event'][3];
	$truckid = $_POST['Event'][4];

	$isAvailable= 1;

	//check if there is a duplicate
	// $checkquery = mysqli_query($mycon,"SELECT * FROM tblscheduling WHERE (DateStart>='$start' AND DateStart<='$end') AND (EmployeeID='$theid' OR TruckID='$truckid')");
	// $checkquerycount = mysqli_num_rows($checkquery);

	// $checkquery2 = mysqli_query($mycon,"SELECT * FROM tblscheduling WHERE (DateEnd>='$start' AND DateEnd<='$end') AND (EmployeeID='$theid' OR TruckID='$truckid')");
	// $checkquerycount2 = mysqli_num_rows($checkquery2);


	$checkalldates =  mysqli_query($mycon, "SELECT * FROM tblscheduling");
	while ($rows = mysqli_fetch_array($checkalldates)) {
		$totimestart = date('Y-m-d',strtotime($start));
		$totimeend = date('Y-m-d',strtotime('-1 day',strtotime($end)));
		$totimestartrow = date('Y-m-d',strtotime($rows['DateStart']));
		$totimeendrow = date('Y-m-d',strtotime($rows['DateEnd']));
		if((($totimestart>=$totimestartrow)&&($totimestart<$totimeendrow))||(($totimeend>$totimestartrow)&&($totimeend<$totimeendrow)))
		{
			if($rows['EmployeeID']==$theid||$rows["TruckID"]==$truckid)
			{
				if($rows["SchedulingID"]!=$id)
				{
					$isAvailable=0;
				}
				
			}
			
		}

		if((($totimestartrow>=$totimestart)&&($totimestartrow<$totimeend))||(($totimestartrow>$totimestart)&&($totimestartrow<$totimeend)))
		{
			if($rows['EmployeeID']==$theid||$rows["TruckID"]==$truckid)
			{
				if($rows["SchedulingID"]!=$id)
				{
					$isAvailable=0;
				}
				
			}
			
		}
		
	}


	if($isAvailable==0)
	{
		//echo '<script>alert("Truck or Driver not available at that time"); location.replace("scheduling.php");</script>';
		die('no');
	}	
	else
	{
		$sql = "UPDATE scheduling SET  start = '$start', end = '$end' WHERE id = $id ";
		$save = mysqli_query($mycon,"UPDATE tblscheduling SET DateStart='$start', DateEnd='$end' WHERE SchedulingID='$id'");
		//echo '<script>alert("Saved"); location.replace("scheduling.php");</script>';
		// $query = $bdd->prepare( $sql );
		// if ($query == false) {
		//  print_r($bdd->errorInfo());
		//  die ('Erreur prepare');
		// }
		// $sth = $query->execute();
		// if ($sth == false) {
		//  print_r($query->errorInfo());
		//  die ('Erreur execute');
		// }else{
			
		// }
		die ('OK');
	}

		



}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
