<?php

include('bdd.php');
include("emp_function.php");

if(isset($_POST["user_id"]))
{
	$image = get_image_name($_POST["user_id"]);
	if($image != '')
	{
		unlink("upload/" . $image);
	}
	$statement = $bdd->prepare(
		"DELETE FROM tblemployee WHERE emp_id = :emp_id"
	);
	$result = $statement->execute(
		array(
			':emp_id'	=>	$_POST["user_id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Data Deleted';
	}
}



?>

