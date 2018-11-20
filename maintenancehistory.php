<?php
	include('database_connection.php');
	include('function.php');

	if(!isset($_SESSION["type"]))
	{
	    header('location:login.php');
	}

	if($_SESSION['type'] != 'master')
	{
	    header('location:index.php');
	}

	include('header.php');
?>
<style type="text/css">
    .feedback {
  background-color : #31B0D5;
  color: white;
  padding: 10px 20px;
  border-radius: 4px;
  border-color: #46b8da;
}

#mybutton {
  position: fixed;
  bottom: -4px;
  right: 10px;
}
@media print {
  #mybutton {
    display: none;
  }
}
</style>
<div id="mybutton">
<button class="feedback" onclick="window.print()">Print</button>
</div>
<span id='alert_action'></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Maintenance History</h3>
                            </div>
                        
                            <!-- <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
					
                            </div> -->
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="product_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>Truck Name</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Mechanic</th>
                                    <th>Date</th>
                                </tr></thead>
                                <tbody>
                                	<?php
                                		$query = mysqli_query($mycon,"SELECT DISTINCT *  FROM subtblinventory_parts_product
                                            INNER JOIN subtblinventory_parts ON subtblinventory_parts_product.inventory_order_id=subtblinventory_parts.inventory_order_id
                                            INNER JOIN tbltruck ON subtblinventory_parts.inventory_order_name = tbltruck.TruckID
                                            INNER JOIN subtblproduct on subtblinventory_parts_product.product_id = subtblproduct.product_id
                                            INNER JOIN tblemployee ON subtblinventory_parts.inventory_order_address= tblemployee.emp_id");
                                		while ($row = mysqli_fetch_array($query)) {
                                			echo '
                                				<tr>
                                					<td>'.$row['brand'].'-'.$row['platenumber'].'</td>
                                                    <td>'.$row['product_name'].'</td>
                                                    <td>'.$row['quantity'].'</td>
                                                    <td>'.$row['emp_first_name'].' '.$row['emp_last_name'].'</td>
                                                    <td>'.date("M jS, Y", strtotime($row['inventory_order_created_date'])).'</td>
                                				</tr>
                                			';
                                		}
                                	?>
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div>
			</div>
		</div>