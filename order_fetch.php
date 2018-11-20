<?php

//order_fetch.php

include('database_connection.php');

include('function.php');

$query = '';

$output = array();

$query .= "
	SELECT * FROM subtblinventory_parts
	INNER JOIN tbltruck on subtblinventory_parts.inventory_order_name = tbltruck.TruckID WHERE 
";

if($_SESSION['type'] == 'user')
{
	$query .= 'user_id = "'.$_SESSION["user_id"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
	
	$query .= '( brand LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR inventory_order_total LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR inventory_order_status LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR inventory_order_date LIKE "%'.$_POST["search"]["value"].'%") ';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY inventory_order_id DESC ';
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

	if($row['payment_status'] == 'preventive')
	{
		$payment_status = '<span class="label label-primary">Preventive</span>';
	}
	else
	{
		$payment_status = '<span class="label label-warning">Over-all</span>';
	}

	$status = '';
	if($row['inventory_order_status'] == 'active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else if($row['inventory_order_status'] == 'Delivered')
	{
		$status = '<span class="label label-danger">Delivered</span>';
	}
	else{
		$status = '<span class="label label-warning">Finished</span>';
	}
	$sub_array = array();
	
	$sub_array[] = $row['brand'];
	$sub_array[] = $row['inventory_order_total'];
	$sub_array[] = $payment_status;
	$sub_array[] = $status;
	$sub_array[] = $row['inventory_order_date'];
	if($_SESSION['type'] == 'master')
	{
		$sub_array[] = get_user_name($connect, $row['user_id']);
	}
	$sub_array[] = '<a href="view_order.php?pdf=1&order_id='.$row["inventory_order_id"].'" class="btn btn-info btn-xs">View PDF</a>';
	if($row['inventory_order_status'] == 'active')
	{
		$sub_array[] = '<button type="button" name="update" id="'.$row["inventory_order_id"].'" class="btn btn-warning btn-xs update">Update</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["inventory_order_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["inventory_order_address"].'">Delivered</button>';
	}
	else
	{
		$sub_array[] = 'Delivered';
		if($row['inventory_order_status']=="Delivered")
		{
			$sub_array[] = '<button type="button" name="finish" id="'.$row["inventory_order_id"].'" class="btn btn-success btn-xs finish" data-status="'.$row["inventory_order_name"].'">Finish</button>';
		}{
			$sub_array[] = 'Finished';
		}
		
		
	}
	// $sub_array[] = '<button type="button" name="update" id="'.$row["inventory_order_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	// $sub_array[] = '<button type="button" name="delete" id="'.$row["inventory_order_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["inventory_order_status"].'">Delivered</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM subtblinventory_parts");
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