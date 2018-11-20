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

	if(isset($_POST['addtruck']))
	{
		$checker = mysqli_query($mycon,"SELECT * FROM tbltruck WHERE platenumber='".$_POST['truckplate']."'");
		$counter = mysqli_num_rows($checker);
		if($counter>0)
		{
			echo '<script>alert("Plate number or Truck  already exists"); location.replace("addtruck.php");</script>';
		}
		else
		{
			$insert = mysqli_query($mycon,"INSERT INTO tbltruck (platenumber, status, brand) VALUES('".$_POST['truckplate']."','available', '".$_POST['truckbrand']."')");

			if($insert)
			{
				echo '<script>alert("Truck Added"); location.replace("addtruck.php");</script>';
			}
		}
		
	}

	if(isset($_POST['updatetruck']))
	{
		$getplate = mysqli_query($mycon,"SELECT * FROM tbltruck WHERE TruckID='".$_POST['truckid']."'");
		$rows = mysqli_fetch_array($getplate);
		
		if($rows['platenumber']!=$_POST['truckplate'])
		{
			$checker = mysqli_query($mycon,"SELECT * FROM tbltruck WHERE platenumber='".$_POST['truckplate']."'");
			$counter = mysqli_num_rows($checker);
			if($counter>0)
			{
				echo '<script>alert("Plate number already exists"); location.replace("addtruck.php");</script>';
			}
			else
			{
				$update = mysqli_query($mycon, "UPDATE tbltruck SET platenumber='".$_POST['truckplate']."', brand='".$_POST['truckbrand']."' WHERE TruckID='".$_POST['truckid']."'");
				if($update)
				{
					echo '<script>alert("Truck details updated"); location.replace("addtruck.php");</script>';
				}
			}
		}
		

		

	}

?>

<span id='alert_action'></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Truck List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
					
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="product_data" class="table  table-striped">
                                <thead><tr>
                                    <th>Truck No.</th>
                                    <th>Brand</th>
                                    <th>Plate number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th></th>
                                </tr></thead>
                                <tbody>
                                	<?php
                                		$retrieve = mysqli_query($mycon,"SELECT * FROM tbltruck order by brand ASC");
                                		while ($row =mysqli_fetch_array($retrieve)) {
                                			$status = '';
                                			$btnstatus = '';
											if($row['status'] == 'available')
											{
												$status = '<span class="label label-success">'.$row['status'].'</span>';
												$btnstatus = "to maintenance";
											}
											else
											{
												$status = '<span class="label label-danger">'.$row['status'].'</span>';
												$btnstatus = "to available";
											}
                                			echo '<tr>
                                						<td>'.$row['TruckID'].'</td>
                                						<td>'.$row['brand'].'</td>
                                						<td>'.$row['platenumber'].'</td>
                                						<td>'.$status.'</td>
                                						<td><button type="button" name="update" id="'.$row["TruckID"].'" class="btn btn-default btn-xs update" data-plate="'.$row["platenumber"].'" data-brand="'.$row["brand"].'">update</button></td>
                                						<td><a class="btn btn-success btn-xs" href="truckmainte.php?id='.$row['TruckID'].'">'.$btnstatus.'</a></td>
                                				 </tr>';
                                		}	
                                	?>
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div>
			</div>
		</div>

<div id="addtrucksModal" class="modal fade">
            <div class="modal-dialog">
            
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Truck Details</h4>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="frmaddtruck">
                                	<input type="hidden" name="truckid" id="truckid" value="">
									Truck Brand:
                                    <input type="text" value="" name="truckbrand" id="truckbrand" class="form-control" required>
                                    <br />
                                    Plate number:
                                    <input type="text" value="" name="truckplate" id="truckplate" class="form-control" required>
                                    <br />
                                    <input type="submit" class="btn btn-primary" name="addtruck" style="width: 100%;" id="add_truck" value="Set Truck Details">
                                    
                                </form>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                
            </div>
        </div>


<script type="text/javascript">
	$(document).ready(function(){

		 var productdataTable = $('#product_data').DataTable();

		$('#add_button').click(function(){
			$('#addtrucksModal').modal('show');
			 $("#truckid").val("");
	        $("#truckplate").val("");
	        $("#truckbrand").val("");
	        document.getElementById("add_truck").name = "addtruck";
   		});

   		$('.update').click(function(){
	        $('#addtrucksModal').modal('show');
	        var truckid = $(this).attr("id");
	        var plantenum = $(this).attr("data-plate");
	        var truckbrand = $(this).attr("data-brand");
	        $("#truckid").val(truckid);
	        $("#truckplate").val(plantenum);
	        $("#truckbrand").val(truckbrand);
	        document.getElementById("add_truck").name = "updatetruck";
   		});
	});

	 
</script>