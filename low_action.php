<?php

//product_action.php

include('database_connection.php');

include('low_function.php');


if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_brand')
	{
		echo fill_brand_list($connect, $_POST['category_id']);
	}

	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO subtblproduct (category_id, brand_id, product_name, product_description, product_quantity, product_unit, product_base_price, product_tax, product_enter_by, product_status, product_date, product_low_stock) 
		VALUES (:category_id, :brand_id, :product_name, :product_description, :product_quantity, :product_unit, :product_base_price, :product_tax, :product_enter_by, :product_status, :product_date, :low_stocksStart)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_id'			=>	$_POST['category_id'],
				':brand_id'				=>	$_POST['brand_id'],
				':product_name'			=>	$_POST['product_name'],
				':product_description'	=>	$_POST['product_description'],
				':product_quantity'		=>	$_POST['product_quantity'],
				':product_unit'			=>	$_POST['product_unit'],
				':product_base_price'	=>	$_POST['product_base_price'],
				':product_tax'			=>	$_POST['product_tax'],
				':product_enter_by'		=>	$_SESSION["user_id"],
				':product_status'		=>	'active',
				':product_date'			=>	date("Y-m-d"),
				':low_stocksStart'		=>	$_POST['low_stocksStart']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Added';
		}
	}
	if($_POST['btn_action'] == 'product_details')
	{
		$query = "
		SELECT * FROM subtblproduct 
		INNER JOIN subtblcategory ON subtblcategory.category_id = subtblproduct.category_id 
		INNER JOIN subtblsupplier ON subtblsupplier.brand_id = subtblproduct.brand_id 
		INNER JOIN tblaccountinfo ON tblaccountinfo.user_id = subtblproduct.product_enter_by 
		WHERE subtblproduct.product_id = '".$_POST["product_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		foreach($result as $row)
		{
			$status = '';
			if($row['product_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$output .= '
			<tr>
				<td>Parts Name</td>
				<td>'.$row["product_name"].'</td>
			</tr>
			<tr>
				<td>Parts Description</td>
				<td>'.$row["product_description"].'</td>
			</tr>
			<tr>
				<td>Kind of Parts</td>
				<td>'.$row["category_name"].'</td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td>'.$row["brand_name"].'</td>
			</tr>
			<tr>
				<td>Parts Quantity</td>
				<td>'.$row["product_quantity"].' '.$row["product_unit"].'</td>
			</tr>
			<tr>
				<td>Parts Base Price</td>
				<td>'.$row["product_base_price"].'</td>
			</tr>
			<tr>
				<td>Parts Tax (%)</td>
				<td>'.$row["product_tax"].'</td>
			</tr>
			<tr>
				<td>Enter By</td>
				<td>'.$row["user_name"].'</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>'.$status.'</td>
			</tr>
			<tr>
				<td>Low Stock Start</td>
				<td>'.$row["product_low_stock"].'</td>
			</tr>
			';
		}
		$output .= '
			</table>
		</div>
		';
		echo $output;
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM subtblproduct WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_id'	=>	$_POST["product_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['category_id'] = $row['category_id'];
			$output['brand_id'] = $row['brand_id'];
			$output["brand_select_box"] = fill_brand_list($connect, $row["category_id"]);
			$output['product_name'] = $row['product_name'];
			$output['product_description'] = $row['product_description'];
			$output['product_quantity'] = $row['product_quantity'];
			$output['product_unit'] = $row['product_unit'];

			$output['product_base_price'] = $row['product_base_price'];
			$output['product_tax'] = $row['product_tax'];
			$output['low_stocksStart'] = $row['product_low_stock'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE subtblproduct 
		set category_id = :category_id, 
		brand_id = :brand_id,
		product_name = :product_name,
		product_description = :product_description, 
		product_quantity = :product_quantity, 
		product_unit = :product_unit, 
		product_base_price = :product_base_price, 
		product_tax = :product_tax ,
		product_low_stock =:product_low_stock
		WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_id'			=>	$_POST['category_id'],
				':brand_id'				=>	$_POST['brand_id'],
				':product_name'			=>	$_POST['product_name'],
				':product_description'	=>	$_POST['product_description'],
				':product_quantity'		=>	$_POST['product_quantity'],
				':product_unit'			=>	$_POST['product_unit'],
				':product_base_price'	=>	$_POST['product_base_price'],
				':product_tax'			=>	$_POST['product_tax'],
				':product_low_stock'	=>	$_POST['low_stocksStart'],
				':product_id'			=>	$_POST['product_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Details Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE subtblproduct 
		SET product_status = :product_status 
		WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_status'	=>	$status,
				':product_id'		=>	$_POST["product_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product status change to ' . $status;
		}
	}
	
	if($_POST['btn_action']=='add_stocks')
	{
		$query = "
		UPDATE subtblproduct 
		SET product_quantity = :product_quantity 
		WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_quantity'	=>	$_POST["sumstocks"],
				':product_id'		=>	$_POST["prodid"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Stocks Added Successfully';
		}
		
	}
}



?>