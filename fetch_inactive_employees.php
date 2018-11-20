<?php
include('bdd.php');
include('emp_function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM tblemployee ";
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE emp_status="inactive" AND (emp_first_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR emp_last_name LIKE "%'.$_POST["search"]["value"].'%" )';
	
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY emp_id DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $bdd->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	$image = '';
	if($row["emp_image"] != '')
	{
		$image = '<img src="upload/'.$row["emp_image"].'" class="img-thumbnail" width="50" height="35" />';
	}
	else
	{
		$image = '';
	}
	$sub_array = array();
	$sub_array[] = $image;
	$sub_array[] = $row["emp_first_name"];
	$sub_array[] = $row["emp_last_name"];
	$sub_array[] = $row["emp_position"];
	$sub_array[] = $row["emp_contact"];
	$sub_array[] = $row["emp_gender"];
	$sub_array[] = $row["emp_address"];
	$sub_array[] = $row["emp_mstatus"];
	$sub_array[] = '<button type="button" name="update" emp_id="'.$row["emp_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="status" data-empstatus="'.$row['emp_status'].'" data-empremarks="'.$row['emp_remarks'].'" data-empid="'.$row["emp_id"].'" class="btn btn-danger btn-xs status">Status</button>';
	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
?>