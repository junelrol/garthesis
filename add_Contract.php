<?php

$id = $_GET['id'];
include('database_connection.php');

include('function.php');
if(!isset($_SESSION['type']))
{
	header('location:login.php');
}
include('header.php');

if(isset($_POST['btn_save']))
{
	
	$extension = explode('.', $_FILES['file']['name']);
	if(strtotime($_POST['start'])>strtotime($_POST['end']))
	{
		echo '<script>alert("start time is greater than end time"); location.replace("add_Contract.php?id='.$id.'");</script>';
	}elseif($extension[1]!="pdf"){
		echo '<script>alert("file contract format must be a pdf"); location.replace("add_Contract.php?id='.$id.'");</script>';
	}
	else{
		$newfilename =upload_image_to_client();
		$query = mysqli_query($mycon, "INSERT INTO tblclientcontracts (client_id, contract_des, startdate, enddate, contract_file, contract_price, contract_type) VALUES('".$id."', '".$_POST['descri']."','".$_POST['start']."', '".$_POST['end']."', '".$newfilename."', '".$_POST['price']."', '".$_POST['type']."' )") or die(mysqli_error($mycon));
		if($query)
		{
			echo '<script>alert("Contract Added"); location.replace("add_Contract.php?id='.$id.'");</script>';
		}
	}
	
}
?>

<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-20">
			
			<div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                    	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            <h3 class="panel-title">CONTRACT LIST</h3>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">ADD CONTRACT</button>    	
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                	<table id="table_contract" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>ID</th>
								<th>DESCRIPTION</th>
								<th>START DATE</th>
								<th>END EDATE</th>
								<th>Price</th>
								<th>Type</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$query = mysqli_query($mycon,"SELECT * FROM tblclientcontracts 
									INNER JOIN tblcontract on tblcontract.id_contract=tblclientcontracts.contract_type 
									ORDER BY contract_des ASC");
								while ($row = mysqli_fetch_array($query)) {
									echo '<tr>
											<td>'.$row['contract_id'].'</td>
											<td>'.$row['contract_des'].'</td>
											<td>'.$row['startdate'].'</td>
											<td>'.$row['enddate'].'</td>
											<td>'.$row['contract_price'].'</td>
											<td>'.$row['contract_name'].'</td>
											<td><a href="client contracts/'.$row['contract_file'].'" class="btn btn-primary">View</a></td>
										</tr>';
								}
							?>
						</tbody>
                	</table>
                </div>
            </div>
        </div>
    </div>


    <div id="clientContractModal" class="modal fade">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Add Contract</h4>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="frmaddcontract" enctype="multipart/form-data">
                                   <label for="start">Start Date</label><input type="date" name="start" id="start" class="form-control" required>
                                   <label for="end">End Date</label><input type="date" name="end" id="end" class="form-control" required>
                                   <label for="descri">Contract Description</label><input type="text" name="descri" id="descri" class="form-control" required>
                                   <label for="price">Contract Price</label><input type="number" name="price" id="price" class="form-control" required>
                                   <label for="type">Type</label><select name="type" id="type" class="form-control">
                                   		<?php
                                   			echo fill_contract_list($connect);
                                   		?>
                                   </select>
                                    <label for="file">Contract File</label><input type="file" name="file" id="file" class="form-control" required>

                                   <br />
                                   <button class="btn btn-primary" style="width: 100%;" name="btn_save">Add</button>
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

	 	 var productdataTable = $('#table_contract').DataTable();
	 });

	 $(document).on('click', '#add_button', function(){
			$('#clientContractModal').modal('show');
        	$('#frmaddcontract')[0].reset();
		});
</script>