<?php

//order_action.php

include('database_connection.php');

include('function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO tblclient (user_id, client_name, client_address, client_email, client_number, contract_created_date) 
		VALUES (:user_id, :client_name, :client_address, :client_email, :client_number, :contract_created_date)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'						=>	$_SESSION["user_id"],
				':client_name'					=>	$_POST['client_name'],
				':client_address'				=>	$_POST['client_address'],
				':client_email'					=>	$_POST['client_email'],
				':client_number'				=>	$_POST['client_number'],
				':contract_created_date'	=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		$statement = $connect->query("SELECT LAST_INSERT_ID()");
		$client_id = $statement->fetchColumn();

		
			if(isset($result))
			{
				echo 'Company Details Inserted';	
			}
		
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM tblclient WHERE client_id = :client_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':client_id'	=>	$_POST["client_id"]
			)
		);
		$result = $statement->fetchAll();
		$output = array();
		foreach($result as $row)
		{
			$output['client_name'] = $row['client_name'];
			//$output['client_endcontract'] = $row['client_endcontract'];
			//$output['client_startcontract'] = $row['client_startcontract'];
			$output['client_address'] = $row['client_address'];
			$output['client_email'] = $row['client_email'];
			$output['client_number'] = $row['client_number'];
			//$output['client_total_pay'] = $row['client_total_pay'];
			//$output['payment_status'] = $row['payment_status'];
		}
		$sub_query = "
		SELECT * FROM tblcontract 
		WHERE client_id = '".$_POST["client_id"]."'
		";
		$statement = $connect->prepare($sub_query);
		$statement->execute();
		$sub_result = $statement->fetchAll();
		$product_details = '';
		$count = '';
		foreach($sub_result as $sub_row)
		{
			$product_details .= '
			<script>
			$(document).ready(function(){
				$("#product_id'.$count.'").selectpicker("val", '.$sub_row["product_id"].');
				$(".selectpicker").selectpicker();
			});
			</script>
			<span id="row'.$count.'">
				<div class="row">
					<div class="col-md-8">
						<select name="product_id[]" id="product_id'.$count.'" class="form-control selectpicker" data-live-search="true" required>
							'.fill_product_list($connect).'
						</select>
						<input type="hidden" name="hidden_product_id[]" id="hidden_product_id'.$count.'" value="'.$sub_row["product_id"].'" />
					</div>
					<div class="col-md-3">
						<input type="text" name="quantity[]" class="form-control" value="'.$sub_row["quantity"].'" required />
					</div>
					<div class="col-md-1">
			';

			if($count == '')
			{
				$product_details .= '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			}
			else
			{
				$product_details .= '<button type="button" name="remove" id="'.$count.'" class="btn btn-danger btn-xs remove">-</button>';
			}
			$product_details .= '
						</div>
					</div>
				</div><br />
			</span>
			';
			$count = $count + 1;
		}
		$output['product_details'] = $product_details;
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$delete_query = "
		DELETE FROM tblcontract 
		WHERE client_id = '".$_POST["client_id"]."'
		";
		$statement = $connect->prepare($delete_query);
		$statement->execute();
		$delete_result = $statement->fetchAll();
		if(isset($delete_result))
		{
			
			$update_query = "
			UPDATE tblclient 
			SET client_name = :client_name,  
			client_address = :client_address, 
			client_email = :client_email, 
			client_number = :client_number 
			WHERE client_id = :client_id
			";
			$statement = $connect->prepare($update_query);
			$statement->execute(
				array(
					':client_name'					=>	$_POST["client_name"],
					':client_address'				=>	$_POST["client_address"],
					':client_email'					=>	$_POST["client_email"],
					':client_number'				=>	$_POST["client_number"],
					':client_id'					=>	$_POST["client_id"]
				)
			);
			$result = $statement->fetchAll();
			if(isset($result))
			{
				echo 'CLIENT DETAILES UPDATED';
			}
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
		UPDATE tblclient 
		SET client_status = :client_status 
		WHERE client_id = :client_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':client_status'	=>	$status,
				':client_id'		=>	$_POST["client_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Your status is : ' . $status;
		}
	}
}

?>