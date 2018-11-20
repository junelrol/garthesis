<?php

//order_fetch.php

include('database_connection.php');

include('function.php');

$query = '';

$output = array();

$query .= "
	SELECT * FROM tblclient WHERE 
";

if($_SESSION['type'] == 'user')
{
	$query .= 'user_id = "'.$_SESSION["user_id"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
	$query .= '(client_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR client_name LIKE "%'.$_POST["search"]["value"].'%"';
	$query .= 'OR client_email LIKE "%'.$_POST["search"]["value"].'%") ';
	//$query .= 'OR client_startcontract LIKE "%'.$_POST["search"]["value"].'%") ';
	
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY client_id DESC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	$payment_status = '';

	// if($row['payment_status'] == 'shortterm')
	// {
	// 	$payment_status = '<span class="label label-primary">Short Term</span>';
	// }
	// else
	// {
	// 	$payment_status = '<span class="label label-warning">Long Term</span>';
	// }

	// $status = '';
	// if($row['client_status'] == 'active')
	// {
	// 	$status = '<span class="label label-success">Active</span>';
	// }
	// else
	// {
	// 	$status = '<span class="label label-danger">Inactive</span>';
	// }
	$sub_array = array();
	$sub_array[] = $row['client_id'];
	$sub_array[] = $row['client_name'];
	$sub_array[] = $row['client_email'];
	//$sub_array[] = $payment_status;
	//$sub_array[] = $status;
	//$sub_array[] = $row['client_startcontract'];
	//$sub_array[] = $row['client_endcontract'];
	if($_SESSION['type'] == 'master')
	{
		$sub_array[] = get_user_name($connect, $row['user_id']);
	}
	$sub_array[] = '<a href="add_Contract.php?id='.$row["client_id"].'" class="btn btn-info btn-xs">ADD CONTRACT</a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["client_id"].'" class="btn btn-warning btn-xs update">UPDATE</button>';
	// $sub_array[] = '<button type="button" name="delete" id="'.$row["client_id"].'" class="btn btn-danger btn-xs delete">STATUS</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM tblclient");
	$statement->execute();
	return $statement->rowCount();
}

$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);	

echo json_encode($output);

?>