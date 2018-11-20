<?php

require_once('bd.php');
if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];

	
	// $sql = "DELETE FROM scheduling WHERE id = $id";
	// $query = $bdd->prepare( $sql );
	// if ($query == false) {
	//  print_r($bdd->errorInfo());
	//  die ('Erreur prepare');
	// }
	// $res = $query->execute();
	// if ($res == false) {
	//  print_r($query->errorInfo());
	//  die ('Erreur execute');
	// }
	$deletesql = mysqli_query($mycon,"DELETE FROM tblscheduling WHERE SchedulingID='$id'");

	
}else if(isset($_POST['title2']) && isset($_POST['color']) && isset($_POST['id'])){
	
	$id = $_POST['id'];
	$title = $_POST['title2'];
	$color = $_POST['color'];
	$truckid = $_POST['truckid'];
	$gettime = $_POST['time'];
	$isAvailable =1;

	$sql = "UPDATE scheduling SET  title = '$title', color = '$color', truckid='$truckid' WHERE id = $id ";

	$getthissched = mysqli_query($mycon,"SELECT * FROM tblscheduling WHERE SchedulingID=$id");
	$rowget = mysqli_fetch_array($getthissched);

	$checkalldates =  mysqli_query($mycon, "SELECT * FROM tblscheduling");
	while ($rows = mysqli_fetch_array($checkalldates)) {
		$totimestart = date('Y-m-d',strtotime($rowget['DateStart']));
		$totimeend = date('Y-m-d',strtotime('-1 day',strtotime($rowget['DateEnd'])));
		$totimestartrow = date('Y-m-d',strtotime($rows['DateStart']));
		$totimeendrow = date('Y-m-d',strtotime($rows['DateEnd']));
		if((($totimestart>=$totimestartrow)&&($totimestart<$totimeendrow))||(($totimeend>$totimestartrow)&&($totimeend<$totimeendrow)))
		{
			if($rows['EmployeeID']==$title||$rows["TruckID"]==$truckid)
			{
				if($rows["SchedulingID"]!=$rowget["SchedulingID"])
				{
					$isAvailable=0;
				}
			}
			
		}

		if((($totimestartrow>=$totimestart)&&($totimestartrow<$totimeend))||(($totimestartrow>$totimestart)&&($totimestartrow<$totimeend)))
		{
			if($rows['EmployeeID']==$title||$rows["TruckID"]==$truckid)
			{
				if($rows["SchedulingID"]!=$rowget["SchedulingID"])
				{
					$isAvailable=0;
				}
				
			}
			
		}
		
	}

	if($isAvailable==0)
	{
		echo '<script>alert("Truck or Driver not available at that time"); location.replace("scheduling.php");</script>';
	}
	else{
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

		$savesql = mysqli_query($mycon,"UPDATE tblscheduling SET EmployeeID='$title', TruckID='$truckid', color='$color', thetime='$gettime' WHERE SchedulingID='$id'");
	}
	
	

}

header('Location: scheduling.php');
	
?>
