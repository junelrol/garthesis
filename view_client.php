<?php

//view_order.php

if(isset($_GET["pdf"]) && isset($_GET['order_id']))
{
	require_once 'pdf.php';
	include('database_connection.php');
	include('clientg_function.php');
	if(!isset($_SESSION['type']))
	{
		header('location:login.php');
	}
	$output = '';
	$statement = $connect->prepare("
		SELECT * FROM tblclient 
		WHERE client_id = :client_id
		LIMIT 1
	");
	$statement->execute(
		array(
			':client_id'       =>  $_GET["order_id"]
		)
	);
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output .= '
		<table>
			<tr>
				<td colspan="2" align="center" style="font-size:30px"><b>G.A RUEDA TRUCKING COMPANY</b></td>
			</tr>
			<tr>
				<td colspan="2">
				<table width="100%" cellpadding="5">
					<tr>
						<td width="65%">
							Dear, '.$row["client_name"].'<br />	
								  '.$row["client_email"].'<br />
							      '.$row["client_number"].'<br />
							      '.$row["client_total_pay"].'<br />
							      '.$row["client_address"].'<br /></br></br>
							
						</td>
						<td width="35%">
							Contract No.  '.$row["client_id"].'<br />
							Contract Start Date : '.$row["client_startcontract"].'<br />
							Contract End Date : '.$row["client_endcontract"].'<br />
							
							
						</td>
					</tr>
				</table>
				<table>
					
		';
		$output .='
		</table>
							
						<b><p align="center" style="font-size:30px">TERMS AND CONDITION</p><b>
							<b><p align="right">____________________________________________________________________________________________</p></b>
						<p align="left" style="font-size:15px"><b>1. We are Freight Enablers </b><br/> FreightExchange acts as a marketplace that allows shippers and carriers to enter into direct agreements for transport services.<br/ ></p>
						<p align="left" style="font-size:15px">All transport services facilitated through this website will be supplied in accordance with the carriers terms of carriage. Other than may be required by law, we do not have any control over the delivery, quality or safety of the transport services, and we are not responsible for the agreements or any other legal aspects relevant to the transport services that are facilitated through our website.<br/ ></p>
						<p align="left" style="font-size:15px"><b>2. Changes are okay </b><br/> We understand things can change quickly in freight so we provide you with a 72-hour window of opportunity prior to the scheduled pick up time to change or cancel your booking. Please note changes and cancellations must be accepted by the other party for the booking to be changed or retracted and cancellation fees may apply.<br/ ></p>
						<p align="left" style="font-size:15px"><b>3. Dangerous Goods</b><br/> It is a serious offence to ship Dangerous Goods without declaring them. It is your responsibility to check whether your goods are dangerous and to complete any relevant declarations. We accept no liability or responsibility for Dangerous Goods that are shipped without the relevant declarations.<br/ ></p>
						
						
						
						<p align="left" style="font-size:15px">We do take customer service very seriously. We monitor shipments and carriers daily to help you ship your goods reliably. We always verify carrier contact details and insurance information. We are free to add or remove carriers at our discretion.<br/ ></p>
						</br><p align="left">__________________________________<br />Client Signature</p><p align="left">__________________________________<br />Operation Manager Signature</p>
					
			</table>
		
		';
		
	}
	$pdf = new Pdf();
	$file_name = 'Order-'.$row["client_id"].'.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
}

?>