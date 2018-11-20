<?php
include('bdd.php');
include('emp_function.php');
if(isset($_POST["user_id"]))
{
	$output = array();
	$statement = $bdd->prepare(
		"SELECT * FROM tblemployee 
		WHERE emp_id = '".$_POST["user_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["emp_first_name"] = $row["emp_first_name"];
		$output["emp_last_name"] = $row["emp_last_name"];
		$output["emp_position"] = $row["emp_position"];
		$output["emp_contact"] = $row["emp_contact"];
		$output["emp_gender"] = $row["emp_gender"];
		$output["emp_address"] = $row["emp_address"];
		$output["emp_mstatus"] = $row["emp_mstatus"];
		if($row["emp_image"] != '')
		{
			$output['user_image'] = '<img src="upload/'.$row["emp_image"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_user_image" value="'.$row["emp_image"].'" />';
		}
		else
		{
			$output['user_image'] = '<input type="hidden" name="hidden_user_image" value="" />';
		}
	}
	echo json_encode($output);
}
?>