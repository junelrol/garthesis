<?php
//product.php

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

      



        <span id='alert_action'></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Stock List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
					
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive" style="overflow-x:auto;">
                            <table id="product_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Kind of Parts</th>
                                    <th>Supplier</th>
                                    <th>Parts Name</th>
                                    <th>Quantity</th>
                                    <th>Enter By</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr></thead>
                            </table>
                        </div></div>
                    </div>
                </div>
			</div>
		</div>

        <div id="productModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="product_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Select Kind of Parts</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Select Kind of Parts</option>
                                    <?php echo fill_category_list($connect);?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Supplier</label>
                                <select name="brand_id" id="brand_id" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Enter Parts Name</label>
                                <input type="text" name="product_name" id="product_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Enter Parts Description</label>
                                <textarea name="product_description" id="product_description" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Enter Parts Quantity</label>
                                <div class="input-group">
                                    <input type="text" name="product_quantity" id="product_quantity" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" /> 
                                    <span class="input-group-addon">
                                        <select name="product_unit" id="product_unit" required>
                                            <option value="">Select Unit</option>
                                            <option value="Bags">Bags</option>
											<option value="Pieces">Pieces</option>
											<option value="Drums">Drums</option>
                                            <option value="Bottles">Bottles</option>
                                            <option value="Box">Box</option>
                                            <option value="Dozens">Dozens</option>
                                            <option value="Feet">Feet</option>
                                            <option value="Gallon">Gallon</option>
                                            <option value="Grams">Grams</option>
                                            <option value="Inch">Inch</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Liters">Liters</option>
                                            <option value="Meter">Meter</option>
                                            <option value="Nos">Nos</option>
                                            <option value="Packet">Packet</option>
                                            <option value="Rolls">Rolls</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Enter Parts Price</label>
                                <input type="text" name="product_base_price" id="product_base_price" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                            <div class="form-group" style="display: none;">
                                <label>Enter Parts Tax (%)</label>
                                <input type="text" name="product_tax" value="0.00" id="product_tax" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" readonly/>
                            </div>
                            <div class="form-group">
                                <label>Low Stock Start</label>
                                <input type="Number" name="low_stocksStart" value="0" id="low_stocksStart" class="form-control" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="product_id" id="product_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="productdetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="product_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Stock Parts Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="product_details"></Div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div id="productDeductStocksModal" class="modal fade">
            <div class="modal-dialog">
            
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Add Stocks</h4>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="frmDeductStocks">
                                    <input type="hidden" name="productid" id="theprodid" value="">
                                    <input type="hidden" name="oldstocks" id="theoldstocks" value="">
                                    Number of stocks to be Deducted:
                                    <input type="Number" min="0" name="newstocks" id="thenewstocks" class="form-control" required>
                                    <br />
                                    <input type="submit" class="btn btn-primary" style="width: 100%;" id="#add_stocks" value="Deduct Stocks">
                                    
                                </form>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                
            </div>
        </div>

        <div id="productAddingStocksModal" class="modal fade">
            <div class="modal-dialog">
            
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Add Stocks</h4>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="frmDeductStocks2">
                                    <input type="hidden" name="productid" id="theprodid2" value="">
                                    <input type="hidden" name="oldstocks" id="theoldstocks2" value="">
                                    Number of stocks to be Added:
                                    <input type="Number" min="0" name="newstocks" id="thenewstocks2" class="form-control" required>
                                    <br />
                                    <input type="submit" class="btn btn-primary" style="width: 100%;" id="#add_stocks2" value="Add Stocks">
                                    
                                </form>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                
            </div>
        </div>

<script>
$(document).ready(function(){
    var productdataTable = $('#product_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"product_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":[7, 8, 9,10,11],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });

    $('#add_button').click(function(){
        $('#productModal').modal('show');
        $('#product_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Parts");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    $('#category_id').change(function(){
        var category_id = $('#category_id').val();
        var btn_action = 'load_brand';
        $.ajax({
            url:"product_action.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data)
            {
                $('#brand_id').html(data);
            }
        });
    });

    $(document).on('submit', '#product_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"product_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#product_form')[0].reset();
                $('#productModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                productdataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.view', function(){
        var product_id = $(this).attr("id");
        var btn_action = 'product_details';
        $.ajax({
            url:"product_action.php",
            method:"POST",
            data:{product_id:product_id, btn_action:btn_action},
            success:function(data){
                $('#productdetailsModal').modal('show');
                $('#product_details').html(data);
            }
        })
    });
	
   

    $(document).on('click', '.update', function(){
        var product_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"product_action.php",
            method:"POST",
            data:{product_id:product_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#productModal').modal('show');
                $('#category_id').val(data.category_id);
                $('#brand_id').html(data.brand_select_box);
                $('#brand_id').val(data.brand_id);
                $('#product_name').val(data.product_name);
                $('#product_description').val(data.product_description);
                $('#product_quantity').val(data.product_quantity);
                $('#product_unit').val(data.product_unit);
                $('#product_base_price').val(data.product_base_price);
                $('#product_tax').val(data.product_tax);
                $('#low_stocksStart').val(data.low_stocksStart);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Parts");
                $('#product_id').val(product_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var product_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"product_action.php",
                method:"POST",
                data:{product_id:product_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    productdataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
	

    });

    $(document).on('click', '.addingstock', function(){
        $('#productAddingStocksModal').modal('show');
        var product_id = $(this).attr("id");
        var oldstocks = $(this).data("oldstocks")
        $("#theprodid2").val(product_id);
        $("#theoldstocks2").val(oldstocks);
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Stocks");
    });

    $(document).on('submit', '#frmDeductStocks2', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        var prodid = $("#theprodid2").val();
        var oldstocks = parseInt($("#theoldstocks2").val(),10);
        var newstocks =  parseInt($("#thenewstocks2").val(),10);
        var sumstocks =  oldstocks+newstocks;
        
         $.ajax({
                url:"product_action.php",
                method:"POST",
                data:{ prodid:prodid ,sumstocks:sumstocks, btn_action:"adding_stocks"},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info"><font color="black">'+data+'</font></div>');
                    $('#frmDeductStocks2')[0].reset();
                    $('#productAddingStocksModal').modal('hide');
                    productdataTable.ajax.reload();
                    
                }
            });

        
    });

    $(document).on('click', '.RemoveStocks', function(){
        $('#productDeductStocksModal').modal('show');
        var product_id = $(this).attr("id");
        var oldstocks = $(this).data("oldstocks")
        $("#theprodid").val(product_id);
        $("#theoldstocks").val(oldstocks);
        $('.modal-title').html("<i class='fa fa-minus'></i> Deduct Stocks");
    });

    $(document).on('submit', '#frmDeductStocks', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        var prodid = $("#theprodid").val();
        var oldstocks = parseInt($("#theoldstocks").val(),10);
        var newstocks =  parseInt($("#thenewstocks").val(),10);
        var sumstocks =  oldstocks-newstocks;
        console.log(oldstocks);
        if(newstocks>oldstocks)
        {
            $('#alert_action').fadeIn().html('<div class="alert alert-danger"><font color="black">Stocks to be deducted is greater than the current stocks of this item</font></div>');
        }
        else{
            $.ajax({
                url:"product_action.php",
                method:"POST",
                data:{ prodid:prodid ,sumstocks:sumstocks, btn_action:"deduct_stocks"},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info"><font color="black">'+data+'</font></div>');
                    $('#frmDeductStocks')[0].reset();
                    $('#productDeductStocksModal').modal('hide');
                    productdataTable.ajax.reload();
                    
                }
            });
        }

        
    });


});
</script>
