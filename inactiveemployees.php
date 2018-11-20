<?php
session_start();
include('header.php');
?>		
			
		<div class="container box">
			<h1 align="center">GART EMPLOYEE PROFILING</h1>
			<br />
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">ADD EMPLOYEE</button>
				</div>
				<br /><br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">Image</th>
							<th width="10%">First Name</th>
							<th width="10%">Last Name</th>
							<th width="10%">Position</th>
							<th width="10%">Contact</th>
							<th width="10%">Gender</th>
							<th width="10%">address</th>
							<th width="10%">Marital Status</th>
							<th width="10%">Edit</th>
							<th width="10%">Update</th>
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body>
</html>

<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Employee</h4>
				</div>
				<div class="modal-body">
					<label>Enter First Name</label>
					<input type="text" name="emp_first_name" id="emp_first_name" class="form-control" />
					<br />
					<label>Enter Last Name</label>
					<input type="text" name="emp_last_name" id="emp_last_name" class="form-control" />
					<br />
					<label>Enter Position</label>
					<select name="emp_position" class="form-control" id="emp_position">
						  <option type="text" name="emp_position" id="emp_position" class="form-control">DRIVER</option>
						  <option type="text" name="emp_position" id="emp_position" class="form-control">MECHANIC</option>
						   <option type="text" name="emp_position" id="emp_position" class="form-control">SECURITY GUARD</option>
						    <option type="text" name="emp_position" id="emp_position" class="form-control">HUMAN RESOURCE</option>
							 <option type="text" name="emp_position" id="emp_position" class="form-control">ACCOUNTING STAFF</option>
					</select>
					<br />
					<label>Enter Contact</label>
					<input type="text" name="emp_contact" id="emp_contact" class="form-control" />
					<br />
					<label>Enter Gender</label>
					<select name="emp_gender" class="form-control" id="emp_gender">
						  <option type="text" name="emp_gender" id="emp_gender" class="form-control">MALE</option>
						<option type="text" name="emp_gender" id="emp_gender" class="form-control">FEMALE</option>
					</select>
					<br />
					<label>Enter address</label>
					<input type="text" name="emp_address" id="emp_address" class="form-control" />
					<br />
					<label>Marital Status</label>
					<select name="emp_mstatus" class="form-control" id="emp_mstatus">
						  <option type="text" name="emp_mstatus" id="emp_mstatus" class="form-control">SINGLE</option>
						<option type="text" name="emp_mstatus" id="emp_mstatus" class="form-control">MARIED</option>
					</select>
					<br />
					<label>Select Employee Image</label>
					<input type="file" name="user_image" id="user_image" />
					<span id="user_uploaded_image"></span>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="user_id" id="user_id" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>


 <div id="ModalUserChangeStatus" class="modal fade">
            <div class="modal-dialog">
            
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-edit"></i>Change Status</h4>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="frmchangestatus">
                                    <input type="hidden" name="id_emp" id="id_emp" value="">
                                    Remarks<input type="text" name="remarks_emp" id="remarks_emp" value=""  class="form-control" required>
                                    <br />
                                    Status<select class="form-control" name="status_emp" id="status_emp">
                                    	<option value="active">active</option>
                                    	<option value="inactive">inactive</option>
                                    </select>
                                    <br />
                                    <input type="submit" name="" class="btn btn-primary" value="Update" style="width: 100%;">
                                </form>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                
            </div>
        </div>


<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("GART Employee Personal Information");
		$('#action').val("Add");
		$('#operation').val("Add");
		$('#user_uploaded_image').html('');
	});
	
	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"fetch_inactive_employees.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0, 3, 4],
				"orderable":false,
			},
		],

	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var firstName = $('#emp_first_name').val();
		var lastName = $('#emp_last_name').val();
		var position = $('#emp_position').val();
		var contact = $('#emp_contact').val();
		var gender = $('#emp_gender').val();
		var address = $('#emp_address').val();
		var mstatus = $('#emp_mstatus').val();
		var extension = $('#user_image').val().split('.').pop().toLowerCase();
		if(extension != '')
		{
			if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
			{
				alert("Invalid Image File");
				$('#user_image').val('');
				return false;
			}
		}	
		if(firstName != '' && lastName != '' && position != '' && contact != '' && gender != '' && address != '' && mstatus != '')
		{
			$.ajax({
				url:"insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#user_form')[0].reset();
					$('#userModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Both Fields are Required");
		}
	});
	
	$(document).on('click', '.update', function(){
		var user_id = $(this).attr("emp_id");
		$.ajax({
			url:"fetch_single.php",
			method:"POST",
			data:{user_id:user_id},
			dataType:"json",
			success:function(data)
			{
				$('#userModal').modal('show');
				$('#emp_first_name').val(data.emp_first_name);
				$('#emp_last_name').val(data.emp_last_name);
				$('#emp_position').val(data.emp_position);
				$('#emp_contact').val(data.emp_contact);
				$('#emp_gender').val(data.emp_gender);
				$('#emp_address').val(data.emp_address);
				$('#emp_mstatus').val(data.emp_mstatus);
				$('.modal-title').text("Edit User");
				$('#user_id').val(user_id);
				$('#user_uploaded_image').html(data.user_image);
				$('#action').val("Edit");
				$('#operation').val("Edit");
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		var user_id = $(this).attr("emp_id");
		if(confirm("Are you sure you want to delete this?"))
		{
			$.ajax({
				url:"delete.php",
				method:"POST",
				data:{user_id:user_id},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});
	

	$(document).on('click', '.status', function(){
		var user_id = $(this).attr("data-empid");
		var emp_status = $(this).attr("data-empstatus");
		var emp_remarks = $(this).attr("data-empremarks");

		$('#id_emp').val(user_id);
        $('#status_emp').val(emp_status);
        $('#remarks_emp').val(emp_remarks);
        $('#ModalUserChangeStatus').modal('show');
        $('#ModalUserChangeStatus')[0].reset();

	});

	$(document).on('submit', '#ModalUserChangeStatus', function(event){
        event.preventDefault();
        var user_id = $("#id_emp").val();
		var emp_status = $("#status_emp").val();
		var emp_remarks = $("#remarks_emp").val();
        $.ajax({
                url:"insert.php",
                method:"POST",
                data:{user_id:user_id,emp_status:emp_status,emp_remarks:emp_remarks },
                success:function(data){
                    alert("User status updated!");
                    $('#frmchangestatus')[0].reset();
                    $('#ModalUserChangeStatus').modal('hide');
                    dataTable.ajax.reload();
                    
                }
            });
    });
	
});
</script>