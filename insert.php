<?php
include('bdd.php');
include('emp_function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{

		//check if there is duplicate of user
		$willsave = 1;
		$checkquery = mysqli_query($mycon,"SELECT * FROM tblemployee WHERE emp_first_name='".$_POST["emp_first_name"]."' && emp_last_name='".$_POST["emp_last_name"]."' && emp_address='".$_POST["emp_address"]."'");
		$checknum = mysqli_num_rows($checkquery);
		if($checknum>0)
		{
			echo 'User Already Saved';
			$willsave=0;
		}
		if($willsave==1)
		{
			$image = '';
			if($_FILES["user_image"]["name"] != '')
			{
				$image = upload_image();
			}
			$statement = $bdd->prepare("
				INSERT INTO tblemployee (emp_first_name, emp_last_name, emp_position, emp_image, emp_contact, emp_gender, emp_address, emp_mstatus, emp_status, emp_remarks) 
				VALUES (:emp_first_name, :emp_last_name, :emp_position, :emp_image, :emp_contact, :emp_gender, :emp_address, :emp_mstatus, :emp_status, :emp_remarks)
			");
			$result = $statement->execute(
				array(
					':emp_first_name'	=>	$_POST["emp_first_name"],
					':emp_last_name'	=>	$_POST["emp_last_name"],
					':emp_position'		=>	$_POST["emp_position"],
					':emp_contact'		=>	$_POST["emp_contact"],
					':emp_gender'		=>	$_POST["emp_gender"],
					':emp_address'		=>	$_POST["emp_address"],
					':emp_mstatus'		=>	$_POST["emp_mstatus"],
					':emp_image'		=>	$image,
					':emp_status'		=>	"active",
					':emp_remarks'		=>	"none",					
				)
			);
			if(!empty($result))
			{
				echo 'Data Inserted';
			}
		}
		
	}
	if($_POST["operation"] == "Edit")
	{
		//check if there is duplicate of user
		$willsave = 1;
		$checkquery = mysqli_query($mycon,"SELECT * FROM tblemployee WHERE emp_first_name='".$_POST["emp_first_name"]."' && emp_last_name='".$_POST["emp_last_name"]."' && emp_address='".$_POST["emp_address"]."'");
		$checknum = mysqli_num_rows($checkquery);
		if($checknum>1)
		{
			echo 'User Already Saved';
			$willsave=0;
		}
		if($willsave==1)
		{
			$image = '';
			if($_FILES["user_image"]["name"] != '')
			{
				$image = upload_image();
			}
			else
			{
				$image = $_POST["hidden_user_image"];
			}
			$statement = $bdd->prepare(
				"UPDATE tblemployee 
				SET emp_first_name = :emp_first_name, emp_last_name = :emp_last_name, emp_position = :emp_position, emp_image = :emp_image, emp_contact = :emp_contact, emp_gender = :emp_gender, emp_address = :emp_address, emp_mstatus = :emp_mstatus
				WHERE emp_id = :emp_id
				"
			);
			$result = $statement->execute(
				array(
					':emp_first_name'	=>	$_POST["emp_first_name"],
					':emp_last_name'	=>	$_POST["emp_last_name"],
					':emp_position'		=>	$_POST["emp_position"],
					':emp_contact'		=>	$_POST["emp_contact"],
					':emp_gender'		=>	$_POST["emp_gender"],
					':emp_address'		=>	$_POST["emp_address"],
					':emp_mstatus'		=>	$_POST["emp_mstatus"],
					':emp_image'		=>	$image,
					':emp_id'			=>	$_POST["user_id"]
				)
			);
			if(!empty($result))
			{
				echo 'Data Updated';
			}
		}
		
	}
}
if(isset($_POST['emp_status']))
{
	$query= mysqli_query($mycon,"UPDATE tblemployee SET emp_status='".$_POST['emp_status']."', emp_remarks='".$_POST['emp_remarks']."' WHERE emp_id='".$_POST['user_id']."'");
}

?>

