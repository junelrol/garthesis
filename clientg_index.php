<?php
//order.php

include('database_connection.php');

include('function.php');

if(!isset($_SESSION['type']))
{
	header('location:login.php');
}

include('header.php');
$datenow = date("Y-m-d");

?>
	<link rel="stylesheet" href="css/datepicker.css">
	<script src="js/bootstrap-datepicker1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

	<script>
	$(document).ready(function(){
		$('#client_startcontract').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true
		});
	});
	
	$(document).ready(function(){
		$('#client_endcontract').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true
		});
	});
	</script>

	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-20">
			
			<div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                    	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            <h3 class="panel-title">CLIENT LIST</h3>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">ADD CLIENT</button>    	
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                	<table id="order_data" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>CONTRACT ID</th>
								<th>COMPANY NAME</th>
								<th>COMPANY EMAIL</th>
								<!-- <th>CONTRACT TYPE</th>
								<th>CONTRACT STATUS</th>
								<th>CONTRACT START DATE</th>
								<th>CONTRACT END DATE</th> -->
								<?php
								if($_SESSION['type'] == 'master')
								{
									echo '<th>PREPARED BY</th>';
								}
								?>
								<th></th>
								<th></th>
								<!-- <th></th> -->
							</tr>
						</thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div id="orderModal" class="modal fade">

    	<div class="modal-dialog">
    		<form method="post" id="order_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Create Maintenance</h4>
    				</div>
    				<div class="modal-body">
    					<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Enter Company Name</label>
									<input type="text" name="client_name" id="client_name" class="form-control" required />
								</div>
							</div>
							<!-- <div class="col-md-6">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="client_startcontract" id="client_startcontract" class="form-control" required />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="client_endcontract" id="client_endcontract" class="form-control" required />
								</div>
							</div> -->
						</div>
						<div class="form-group">
							<label>Company Address</label>
							<textarea name="client_address" id="client_address" class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Company Email</label>
							<textarea name="client_email" id="client_email" class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Company Number</label>
							<textarea name="client_number" id="client_number" class="form-control" required></textarea>
						</div>
						<!-- <div class="form-group">
							<label>Company Payment</label>
							<textarea name="client_total_pay" id="client_total_pay" class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Select Kind of Contract</label>
							<select name="payment_status" id="payment_status" class="form-control"required>
								<option value="shortterm">Short Term</option>
								<option value="longterm">Long Term</option>
							</select>
						</div> -->
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="client_id" id="client_id" />
    					<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" style="width: 100%" />
    				</div>
    			</div>
    		</form>
    	</div>

    </div>
		
<script type="text/javascript">
    $(document).ready(function(){

    	var orderdataTable = $('#order_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"clientg_fetch.php",
				type:"POST"
			},
			<?php
			if($_SESSION["type"] == 'master')
			{
			?>
			"columnDefs":[
				{
					"targets":[4, 5],
					"orderable":false,
				},
			],
			<?php
			}
			else
			{
			?>
			"columnDefs":[
				{
					"targets":[4, 5],
					"orderable":false,
				},
			],
			<?php
			}
			?>
			"pageLength": 10
		});

		$('#add_button').click(function(){
			$('#orderModal').modal('show');
			$('#order_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> CREATE CONTRACT");
			$('#action').val('Add');
			$('#btn_action').val('Add');

			add_product_row();
		});

		function add_product_row(count = '')
		{
			var html = '';
			html += '<span id="row'+count+'"><div class="row">';
			html += '<div class="col-md-8">';
			html += '<select name="product_id[]" id="product_id'+count+'" class="form-control selectpicker" data-live-search="true" required>';
			html += '<?php echo fill_product_list($connect); ?>';
			html += '</select><input type="hidden" name="hidden_product_id[]" id="hidden_product_id'+count+'" />';
			html += '</div>';
			html += '<div class="col-md-3">';
			html += '<input type="text" name="quantity[]" class="form-control" required />';
			html += '</div>';
			html += '<div class="col-md-1">';
			if(count == '')
			{
				html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			}
			else
			{
				html += '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove">-</button>';
			}
			html += '</div>';
			html += '</div></div><br /></span>';
			

			$('.selectpicker').selectpicker();
		}

		var count = 0;

		$(document).on('click', '#add_more', function(){
			count = count + 1;
			add_product_row(count);
		});
		$(document).on('click', '.remove', function(){
			var row_no = $(this).attr("id");
			$('#row'+row_no).remove();
		});

		$(document).on('submit', '#order_form', function(event){
			event.preventDefault();
			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"clientg_action.php",
				method:"POST",
				data:form_data,
				success:function(data){
					$('#order_form')[0].reset();
					$('#orderModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
					$('#action').attr('disabled', false);
					orderdataTable.ajax.reload();
				}
			});
		});

		$(document).on('click', '.update', function(){
			var client_id = $(this).attr("id");
			var btn_action = 'fetch_single';
			$.ajax({
				url:"clientg_action.php",
				method:"POST",
				data:{client_id:client_id, btn_action:btn_action},
				dataType:"json",
				success:function(data)
				{
					$('#orderModal').modal('show');
					$('#client_name').val(data.client_name);
					//$('#client_startcontract').val(data.client_startcontract);
					//$('#client_endcontract').val(data.client_endcontract);
					$('#client_address').val(data.client_address);
					$('#client_email').val(data.client_email);
					$('#client_number').val(data.client_number);
					//$('#client_total_pay').val(data.client_total_pay);
					//$('#payment_status').val(data.payment_status);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i>CLIENT DETAILS");
					$('#client_id').val(client_id);
					$('#action').val('Edit');
					$('#btn_action').val('Edit');
				}
			})
		});

		$(document).on('click', '.delete', function(){
			var client_id = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "delete";
			if(confirm("Are you sure you want to change status?"))
			{
				$.ajax({
					url:"clientg_action.php",
					method:"POST",
					data:{client_id:client_id, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						orderdataTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		});

    });
</script>