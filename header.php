<?php
//header.php
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>G.A RUEDA TRUCKING COMPANY</title>
	<meta name="description" content="Doodle is a Dashboard & Admin Site Responsive Template by hencework." />
	<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Doodle Admin, Doodleadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
	<meta name="author" content="hencework"/>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="gr.ico">
	<link rel="icon" href="gr.ico" type="image/x-icon">
	
	<!-- Morris Charts CSS -->
    <link href="vendors/bower_components/morris.js/morris.css" rel="stylesheet" type="text/css"/>
	
	<!-- Data table CSS -->
	<link href="vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
	
	<link href="vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
		
	<!-- Custom CSS -->
	<link href="dist/css/style.css" rel="stylesheet" type="text/css">
		<title>G.A Rueda Trucking Company</title>
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
	
		<br />
		<div class="container">
		

			<nav class="navbar navbar-inverse navbar-fixed-top">
					
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["user_name"]; ?></a>
							<ul class="dropdown-menu">
								<li><a href="smsinfo.php">MANAGE SMS INFO</a></li>
								<li><a href="smsHistory.php">SMS HISTORY</a></li>
								<li><a href="profile.php">PROFILE</a></li>
								<li><a href="user.php">MAINTENANCE USER</a></li>
								<li><a href="logout.php">LOGOUT</a></li>
							</ul>
						</li>
					</ul>
					</ul>
					
					<div class="fixed-sidebar-left">
			<ul class="nav navbar-nav side-nav nicescroll-bar">
				<li class="navigation-header">
					<span>OPERATION</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
				<?php
					if($_SESSION['type'] == 'master')
					{
					?>
				<li>
					<a class="active" href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_dr"><div class="pull-left"><i class="glyphicon glyphicon-shopping-cart mr-20"></i><span class="right-nav-text">INVENTORY</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="dashboard_dr" class="collapse collapse-level-1">
					
						<li>
							<a class="active-page" href="category.php">ADD PARTS</a>
						</li>
						<li>
							<a  href="brand.php">ADD SUPPLIER</a>
						</li>
						<li>
							<a href="product.php">ADD STOCK</a>
						</li>
						<li>
							<a href="low.php">LOW STOCK</a>
						</li>
				
					</ul>
					
					<?php
					}
					?>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ecom_dr"><div class="pull-left"><i class="glyphicon glyphicon-wrench mr-20"></i><span class="right-nav-text">MAINTENANCE</span></div><div class="pull-right"><span class="label label-success"></span></div><div class="clearfix"></div></a>
					<ul id="ecom_dr" class="collapse collapse-level-1">
						<?php
						if($_SESSION['type'] == 'master')
						{
						?>
						<li>
							<a href="addtruck.php">TRUCK LIST</a>
						</li>
						<?php
						}
						?>
						<li>
							<a href="order.php">ADD MAINTENANCE</a>
						</li>
						<li>
							<a href="index.php">MAINTENANCE EXPENSES</a>
						</li>
						<?php
						if($_SESSION['type'] == 'master')
						{
						?>
						<li>
							<a href="maintenancehistory.php">MAINTENANCE HISTORY</a>
						</li>
						<?php
						}
						?>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_dr"><div class="pull-left"><i class="zmdi zmdi-smartphone-setup mr-20"></i><span class="right-nav-text">CONTRACTS</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_dr" class="collapse collapse-level-1 two-col-list">
						<li>
							<a href="ManageContracts.php">MANAGE CONTRACT</a>
						</li>
						<li>
							<a href="clientcontracthistory.php">CONTRACT HISTORY</a>
						</li>
						
					</ul>
				</li>
				<?php
				if($_SESSION['type'] == 'master')
					{
				?>
				<li>
					<a href="clientg_index.php"><div class="pull-left"><i class="glyphicon glyphicon-tasks mr-20"></i><span class="right-nav-text">CLIENT</span></div><div class="clearfix"></div></a>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#form_dr"><div class="pull-left"><i class="zmdi zmdi-edit mr-20"></i><span class="right-nav-text">EMPLOYEE PROFILING</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="form_dr" class="collapse collapse-level-1 two-col-list">
						<li>
							<a href="employee.php">ACTIVE EMPLOYEES</a>
						</li>
						<li>
							<a href="inactiveemployees.php">INACTIVE EMPLOYEES</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="scheduling.php"><div class="pull-left"><i class="glyphicon glyphicon-calendar mr-20"></i><span class="right-nav-text">SCHEDULING</span></div><div class="clearfix"></div></a>
				</li>
				</ul>	
				<?php
					}
					?>	
			</div>	
		</nav>
			</br></br></br></br>
			