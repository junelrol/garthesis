<?php
//index.php
include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header("location:login.php");
}

include('header.php');

?>
	<br />
	<div class="row">
	<?php
	if($_SESSION['type'] == 'master')
	{
	?>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>USERS</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_user($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>ALL TRUCK PARTS</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_category($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>SUPPLIER</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_brand($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>PARTS AVAILABLE</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_product($connect); ?></h1>
			</div>
		</div>
	</div>
	<?php
	}
	?>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>TOTAL MAINTENANCE VALUE</strong></div>
				<div class="panel-body" align="center">
					<h1>₱<?php echo count_total_order_value($connect); ?></h1>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>PREVENTIVE MAINTENANCE VALUE</strong></div>
				<div class="panel-body" align="center">
					<h1>₱<?php echo count_total_cash_order_value($connect); ?></h1>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>OVERALL MAINTENANCE VALUE</strong></div>
				<div class="panel-body" align="center">
					<h1>₱<?php echo count_total_credit_order_value($connect); ?></h1>
				</div>
			</div>
		</div>
		<hr />
		<?php
		if($_SESSION['type'] == 'master')
		{
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>TOTAL MAINTENANCE VALUE TABLE</strong></div>
				<div class="panel-body" align="center">
					<?php echo get_user_wise_total_order($connect); ?>
				</div>
			</div>
		</div>
		<?php
		}
		?>
	</div>

<?php
include("footer.php");
?>