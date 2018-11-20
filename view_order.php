<?php

//view_order.php

if(isset($_GET["pdf"]) && isset($_GET['order_id']))
{
	require_once 'pdf.php';
	include('database_connection.php');
	include('function.php');
	if(!isset($_SESSION['type']))
	{
		header('location:login.php');
	}
	$output = '';
	$statement = $connect->prepare("
		SELECT * FROM subtblinventory_parts 
		INNER JOIN tblemployee ON tblemployee.emp_id = subtblinventory_parts.inventory_order_address
		INNER JOIN tbltruck ON subtblinventory_parts.inventory_order_name = tbltruck.TruckID
		WHERE inventory_order_id = :inventory_order_id
		LIMIT 1
	");
	$statement->execute(
		array(
			':inventory_order_id'       =>  $_GET["order_id"]
		)
	);
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output .= '
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
				<td colspan="2" align="center" style="font-size:18px"><b>Maintenance Record</b></td>
			</tr>
			<tr>
				<td colspan="2">
				<table width="100%" cellpadding="5">
					<tr>
						<td width="65%">
							<b>Truck Brand/Plate Number : '.$row["brand"].'-'.$row['platenumber'].'</b><br />	
							<b>Person In-Charge : '.$row["emp_first_name"].' '.$row["emp_last_name"].'</b><br />
						</td>
						<td width="35%">
							Maintenance No. : '.$row["inventory_order_id"].'<br />
							Maintenance Date : '.$row["inventory_order_date"].'<br />
						</td>
					</tr>
				</table>
				<br />
				<table width="100%" border="1" cellpadding="5" cellspacing="0">
					<tr>
						<th rowspan="2">Parts No.</th>
						<th rowspan="2">Product</th>
						<th rowspan="2">Quantity</th>
						<th rowspan="2">Price</th>
			
						<th rowspan="2">Total</th>
					</tr>
					<tr>
						
					</tr>
		';
		$statement = $connect->prepare("
			SELECT * FROM subtblinventory_parts_product 
			WHERE inventory_order_id = :inventory_order_id
		");
		$statement->execute(
			array(
				':inventory_order_id'       =>  $_GET["order_id"]
			)
		);
		$product_result = $statement->fetchAll();
		$count = 0;
		$total = 0;
		$total_actual_amount = 0;
		$total_tax_amount = 0;
		foreach($product_result as $sub_row)
		{
			$count = $count + 1;
			$product_data = fetch_product_details($sub_row['product_id'], $connect);
			$actual_amount = $sub_row["quantity"] * $sub_row["price"];
			$tax_amount = ($actual_amount * $sub_row["tax"])/100;
			$total_product_amount = $actual_amount + $tax_amount;
			$total = $total + $total_product_amount;
			$output .= '
				<tr>
					<td>'.$count.'</td>
					<td>'.$product_data['product_name'].'</td>
					<td>'.$sub_row["quantity"].'</td>
					<td aling="right">'.$sub_row["price"].'</td>
		
					<td align="right">'.number_format($total_product_amount, 2).'</td>
				</tr>
			';
		}
		$output .= '
		<tr>
			<td align="right" colspan="4"><b>Total</b></td>
			<td align="right"><b>'.number_format($total, 2).'</b></td>
		</tr>
		';
		$output .= '
						</table>
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<p align="right">__________________________________<br />Operation Manager signature</p>
						<br />
						<br />
						<br />
					</td>
				</tr>
			</table>
		';
	}
	$pdf = new Pdf();
	$file_name = 'Order-'.$row["inventory_order_id"].'.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
}

?>