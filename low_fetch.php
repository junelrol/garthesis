<?php

//product_fetch.php

include('database_connection.php');
include('low_function.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM subtblproduct 
INNER JOIN subtblsupplier ON subtblsupplier.brand_id = subtblproduct.brand_id
INNER JOIN subtblcategory ON subtblcategory.category_id = subtblproduct.category_id 
INNER JOIN tblaccountinfo ON tblaccountinfo.user_id = subtblproduct.product_enter_by 
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE subtblsupplier.brand_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR subtblcategory.category_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR subtblproduct.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR subtblproduct.product_quantity LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR tblaccountinfo.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR subtblproduct.product_id LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY product_id DESC ';
}

if($_POST['length'] != -1)
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
	$status = '';
	if($row['product_quantity'] <= '10')
	{
		$status = '<span class="label label-danger">Low Stock</span>';
		$sub_array = array();
	$sub_array[] = $row['product_id'];
	$sub_array[] = $row['category_name'];
	$sub_array[] = $row['brand_name'];
	$sub_array[] = $row['product_name'];
	$sub_array[] = available_product_quantity($connect, $row["product_id"]) . ' ' . $row["product_unit"];
	$sub_array[] = $row['user_name'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["product_id"].'" class="btn btn-info btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["product_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["product_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["product_status"].'">Delete</button>';
	$data[] = $sub_array;
		
	}
	else if ($row['product_quantity'] == '0')
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM subtblproduct');
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