
 <html>  
      <head>  
           <title>G.A Rueda Trucking Company</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
		   <link href="css/bootstrap.min.css" rel="stylesheet">
           <style>  
                body  
                {  
                     margin:0;  
                     padding:0;  
                     background-color:#ffffff;  
                }  
                .box  
                {  
                     width:1130px;  
                     padding:10px;  
                     background-color:#ffffff;  
                     border:1px solid #ccc;  
                     border-radius:5px;  
                     margin-top:30px;  
                }  
           </style>  
      </head>  
      <body> 
	  </br>
	  <div class="container">
			<h2 align="center">G.A RUEDA TRUCKING COMPANY</h2>

	<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a href="index.php" class="navbar-brand">HOME</a>
					</div>
					<ul class="nav navbar-nav">
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>GAS AND SUPPLY INVENTORY</a>
							<ul class="dropdown-menu">
						<li><a href="user.php">ADD USER</a></li>
						<li><a href="category.php">KIND OF TRUCK PARTS</a></li>
						<li><a href="brand.php">ADD SUPPLIER</a></li>
						<li><a href="product.php">ADD PARTS STOCK</a></li>
						</ul>
						<li><a href="employee.php">EMPLOYEE PROFILING</a></li>
						<li><a href="client.php">CLIENT LIST</a></li>
						<li><a href="scheduling.php">SCHEDULING</a></li>
						<li><a href="order.php">MAINTENANCE OF TRUCK</a></li>
						</ul>
						
					</li>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>admin</a>
							<ul class="dropdown-menu">
								<li><a href="profile.php">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>

           <div class="container box">  
                <h3 align="center">GART CLIENT LIST</h3>  
                <br />  
                  
					<label>Client Name</label>  
                <input type="text" name="client_name" id="client_name" class="form-control" />  
					<label>Client Address</label>  
                <input type="text" name="client_address" id="client_address" class="form-control" />  
					<label>Client Email</label>  
                <input type="text" name="client_email" id="client_email" class="form-control" />  
					<label>Client Contact Number</label>  
                <input type="text" name="client_contact_num" id="client_contact_num" class="form-control" />  
					<label>Contact Person</label>  
                <input type="text" name="client_contact_person" id="client_contact_person" class="form-control" />  
                <br />  
                <div align="center">  
                     <input type="hidden" name="id" id="client_id" />  
                     <button type="button" name="action" id="action" class="btn btn-warning">Add</button>  
                </div>  
                <br />  
                <br />  
                <div id="result" class="table-responsive">  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      fetchUser();  
      function fetchUser()  
      {  
           var action = "select";  
           $.ajax({  
                url : "client_select.php",  
                method:"POST",  
                data:{action:action},  
                success:function(data){  
                     $('#client_name').val('');  
                     $('#client_address').val('');
					 $('#client_email').val('');
					 $('#client_contact_num').val('');
					 $('#client_contact_person').val('');  
                     $('#action').text("Add");  
                     $('#result').html(data);  
                }  
           });  
      }  
      $('#action').click(function(){  
           var clientName = $('#client_name').val();  
           var clientAddress = $('#client_address').val(); 
			var clientEmail = $('#client_email').val();
			var clientContactNum = $('#client_contact_num').val();
			var clientContactPerson = $('#client_contact_person').val();
           var id = $('#client_id').val();  
           var action = $('#action').text();  
           if(clientName != '' && clientAddress != '')  
           {  
                $.ajax({  
                     url : "client_action.php",  
                     method:"POST",  
                     data:{clientName:clientName, clientAddress:clientAddress, clientEmail:clientEmail, clientContactNum:clientContactNum, clientContactPerson:clientContactPerson, id:id, action:action},  
                     success:function(data){  
                          alert(data);  
                          fetchUser();  
                     }  
                });  
           }  
           else  
           {  
                alert("Both Fields are Required");  
           }  
      });  
      $(document).on('click', '.update', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"client_fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#action').text("Edit");  
                     $('#client_id').val(id);  
                     $('#client_name').val(data.client_name);  
                     $('#client_address').val(data.client_address);
						$('#client_email').val(data.client_email);
						$('#client_contact_num').val(data.client_contact_num);
						$('#client_contact_person').val(data.client_contact_person);
                }  
           })  
      });  
      $(document).on('click', '.delete', function(){  
           var id = $(this).attr("id");  
           if(confirm("Are you sure you want to remove this data?"))  
           {  
                var action = "Delete";  
                $.ajax({  
                     url:"client_action.php",  
                     method:"POST",  
                     data:{id:id, action:action},  
                     success:function(data)  
                     {  
                          fetchUser();  
                          alert(data);  
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