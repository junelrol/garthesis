<?php

include('database_connection.php');

include('function.php');
if(!isset($_SESSION['type']))
{
	header('location:login.php');
}
include('header.php');

if(isset($_POST['btn_save']))
{
	$datenow = date("Y-m-d");
	$extension = explode('.', $_FILES['file']['name']);

	//check if name exist
	$querycheck = mysqli_query($mycon,"SELECT * FROM tblcontract WHERE contract_name='".$_POST['filename']."'");
	$num = mysqli_num_rows($querycheck);

	if($extension[1]!="pdf")
	{
		echo '<script>alert("file contract format must be a pdf"); location.replace("ManageContracts.php");</script>';
	}
	else if($num>0)
	{
		echo '<script>alert("Contract Type name Already Exists"); location.replace("ManageContracts.php");</script>';
	}
	else{

		$new_name = date("ymdms").rand() . '.' . $extension[1];
		upload_PDF_to_system($new_name);
		$query = mysqli_query($mycon, "INSERT INTO tblcontract(contract_name, filename ,date_created) VALUES('".$_POST['filename']."', '".$new_name."', '".date("Y-m-d")."')");
		if($query)
		{
			echo '<script>alert("Contract Added"); location.replace("ManageContracts.php");</script>';
		}
	}
	
}

if(isset($_POST['btn_edit_name']))
{
	$querycheck = mysqli_query($mycon,"SELECT * FROM tblcontract WHERE contract_name='".$_POST['contractname2']."'");
	$num = mysqli_num_rows($querycheck);
	if($num>1)
	{
		echo '<script>alert("Contract Type name Already Exists"); location.replace("ManageContracts.php");</script>';
	}
	else{

		$updatequery = mysqli_query($mycon,"UPDATE tblcontract SET contract_name='".$_POST['contractname2']."' WHERE id_contract='".$_POST['conID']."'");
		if($updatequery)
		{
			echo '<script>alert("Contract Updated"); location.replace("ManageContracts.php");</script>';
		}
	}
}

if(isset($_POST['btn_edit_file']))
{
	$extension = explode('.', $_FILES['file']['name']);
	if($extension[1]!="pdf")
	{
		echo '<script>alert("file contract format must be a pdf"); location.replace("ManageContracts.php");</script>';
	}
	else{

		upload_PDF_to_system($_POST['conID2']);
		echo '<script>alert("Contract File Edited"); location.replace("ManageContracts.php");</script>';
		
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
                            <h3 class="panel-title">SAMPLE CONTRACT</h3>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">UPLOAD CONTRACT</button>    	
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                	<table id="table_contract" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>ID</th>
								<th>CONTRACT NAME</th>
								<th>DATE CREATED</th>
								<th>ACTION</th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>
						<tbody>
							<?php
								$query = mysqli_query($mycon,"SELECT * FROM tblcontract");
								while ($row = mysqli_fetch_array($query)) {
									echo '<tr>
											<td>'.$row['id_contract'].'</td>
											<td>'.$row['contract_name'].'</td>
											<td>'.$row['date_created'].'</td>
											<td><a href="contracts/'.$row['filename'].'" class="btn btn-primary">View</a></td>
											<td><button class="btn btn-danger name" data-id="'.$row['id_contract'].'" data-names="'.$row['contract_name'].'" >Edit Name</button></td>
											<td><button class="btn btn-warning contract" data-id="'.$row['filename'].'" >Edit Contract</button></td>
										</tr>';
								}
							?>
						</tbody>
                	</table>
                </div>
            </div>
        </div>
    </div>

       <div id="ContractModal" class="modal fade">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Add Contract</h4>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="frmaddcontract" enctype="multipart/form-data">
                                   <label for="filename">Contract Name</label><input type="text" name="filename" id="filename" class="form-control" required>
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

        <div id="ContractNameModal" class="modal fade">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Edit Contract File</h4>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="frmcontractname" enctype="multipart/form-data">
                                	<input type="hidden" name="conID" id="conID" value="">
                                   <label for="contractname2">Contract Name</label><input type="text" name="contractname2" id="contractname2" class="form-control" required>

                                   <br />
                                   <button class="btn btn-primary" style="width: 100%;" name="btn_edit_name">Edit</button>
                                </form>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
            </div>
        </div>

        <div id="ContractFileModal" class="modal fade">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Edit Contract Name</h4>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="frmcontractfile" enctype="multipart/form-data">
                                	<input type="hidden" name="conID2" id="conID2" value="">
                                   <label for="file2">Contract Name</label><input type="file" name="file" id="file2" class="form-control" required>
                                   <br />
                                   <button class="btn btn-primary" style="width: 100%;" name="btn_edit_file">Edit</button>
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
			$('#ContractModal').modal('show');
        	$('#frmaddcontract')[0].reset();
		});

	  $(document).on('click', '.name', function(){
	  		var id = $(this).data("id");
	  		var name = $(this).data("names"); 

			$('#ContractNameModal').modal('show');
        	$('#frmcontractname')[0].reset();

        	$('#conID').val(id);
	  		$('#contractname2').val(name);
		});

	    $(document).on('click', '.contract', function(){
	  		var id = $(this).data("id");

			$('#ContractFileModal').modal('show');
        	$('#frmcontractfile')[0].reset();

        	$('#conID2').val(id);
		});
</script>