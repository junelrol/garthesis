<?php
require_once('bd.php');
include('database_connection.php');
include('function.php');

$sql = "SELECT SchedulingID, EmployeeID, DateStart, DateEnd, color, TruckID, theid, thetime FROM tblscheduling ";

$req = $connect->prepare($sql);
$req->execute();

$events = $req->fetchAll();
date_default_timezone_set('Asia/Manila');
$datenow= date('Y-m-d\TH:i');
//$datenow2= date('Y-M-D h:i:s a', time());

// echo date('Y-m-d');
// die();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>G.A Rueda Trucking Company</title>

    <!-- Bootstrap Core CSS -->
    <!--<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
	<!-- FullCalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />	
	<link rel="shortcut icon" href="gr.ico">
	<link rel="icon" href="gr.ico" type="image/x-icon">

    <!-- Custom CSS -->
   
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- Custom CSS -->
	<link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>
 <style>
    body {
        padding-top: 0px;
		background-color: #ffffff;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
	#calendar {
		max-width: 800px;
	
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>

<body>

    <?php
    	include('header.php');
    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>GART DRIVER SCHEDULING</h1>
                
                <div id="calendar" class="col-centered">
                </div>
            </div>
			
        </div>
        <!-- /.row -->
		
		<!-- Modal -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="addEvent.php">
			
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">ADD SCHEDULE</h4>
			  </div>
			  <div class="modal-body">
			  <?php
			  
			  $hostname = "den1.mysql2.gear.host";
			  $username = "root";
			  $password = "@garthesis";
			  $databasename = "garthesis";
			  $connect1 = mysqli_connect($hostname, $username, $password, $databasename);
			  $query ="SELECT * FROM employee";
			  $result1 = mysqli_query($connect1, $query);
			  
			  
			  ?>
				
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
					  <!-- <input type="text" name="title" class="form-control" id="title" placeholder="Name"> -->
					  <select class="form-control" name="title" id="title">
					  	<?php
					  		echo fill_user_list_driver($connect);
					  	?>
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="color" class="col-sm-2 control-label">Color</label>
					<div class="col-sm-10">
					  <select name="color" class="form-control" id="color">
						  <option value="">Choose</option>
						  <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
						  <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
						  <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
						  <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
						  <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
						  <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
						  <option style="color:#000;" value="#000">&#9724; Black</option>
						  
						</select>
					</div>
				  </div>

				   <div class="form-group">
					<label for="truckid" class="col-sm-2 control-label">Truck</label>
					<div class="col-sm-10">
					  <select name="truckid" class="form-control" id="truckid">
						 <?php
						 		echo  fill_truck_list($connect,"available");
						 ?>
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Time</label>
					<div class="col-sm-10">
					   <input type="time" name="time" class="form-control" id="time" required>
					</div>
				  </div>
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Date Start</label>
					<div class="col-sm-10">
					   <input type="text" name="fakestart" class="form-control" id="fakestart" readonly>
					</div>
				  </div>
				  <div class="form-group" style="display:none;">
					<label for="start" class="col-sm-2 control-label">Start date</label>
					<div class="col-sm-10">
					   <input type="text" name="start" class="form-control" id="start" readonly>
					</div>
				  </div>
				  <div class="form-group" style="display: none;">
					<label for="end" class="col-sm-2 control-label">End date</label>
					<div class="col-sm-10">
					  <input type="text" name="end" class="form-control" id="end" readonly>
					</div>
				  </div>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
		
		
		
		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEventTitle.php">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Schedule</h4>
			  </div>
			  <div class="modal-body">
				
				  <div class="form-group">
					<label for="title2" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
					  <!-- <input type="text" name="title" class="form-control" id="title" placeholder="Name"> -->
					   <select class="form-control" name="title2" id="title2">
					  	<?php
					  		echo fill_user_list_driver($connect);
					  	?>
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="color" class="col-sm-2 control-label">Color</label>
					<div class="col-sm-10">
					  <select name="color" class="form-control" id="color">
						  <option value="">Choose</option>
						  <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
						  <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
						  <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
						  <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
						  <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
						  <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
						  <option style="color:#000;" value="#000">&#9724; Black</option>
						  
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="truckid2" class="col-sm-2 control-label">Truck</label>
					<div class="col-sm-10">
					  <select name="truckid" class="form-control" id="truckid2">
						 <?php
						 		echo  fill_truck_list($connect,"available");
						 ?>
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Time</label>
					<div class="col-sm-10">
					   <input type="time" name="time" class="form-control" id="time2" required>
					</div>
				  </div>
				    <div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="">
							<label class="text-danger"><input type="checkbox" name="delete"> Remove Schedule</label>
						  </div>
						</div>
					</div>
				  <!-- <input type="checkbox"  name="delete">  -->
				  <input type="hidden" name="id" class="form-control" id="id">
				  
			  </div>
			  <div class="modal-footer">
			  		<a href="asd" class="btn btn-warning" id="sndmessage">Send Message</a>
			  		<button type="submit" class="btn btn-primary">Save changes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</form>
			  </div>
			
			</div>
		  </div>
		</div>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- FullCalendar -->
	<script src='js/moment.min.js'></script>
	<script src='js/fullcalendar.min.js'></script>
	
	<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'basicWeek,basicDay,month'
			},
			defaultDate: '2018-10-20',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				$('#ModalAdd #fakestart').val(moment(start).format('YYYY-MM-DD'));
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					//$('#ModalEdit #title2').val(event.title);
					$("#title2").val(event.theid);
					$('#ModalEdit #color').val(event.color);
					$('#truckid2').val(event.truckid);
					$('#time2').val(event.thetime);
					$('#ModalEdit').modal('show');
					$('#sndmessage').attr('href',"sendsms.php?id="+event.id+"&userid="+event.theid);
					
				});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				editdrop(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [
			<?php foreach($events as $event): 
				//$thestary  = date('y-m-d h:m:s',);
				$start = explode(" ", $event['DateStart']);
				$end = explode(" ", $event['DateEnd']);
				if($start[1] = '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['DateStart'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['DateEnd'];
				}
				$thetitle =$event['EmployeeID'];
				$getquery = mysqli_query($mycon,"SELECT * FROM tblemployee WHERE emp_id='$thetitle'");
				$row1 = mysqli_fetch_array($getquery);
				$fullname = $row1['emp_first_name']." ".$row1['emp_last_name'];
			?>
				{
					id: '<?php echo $event['SchedulingID']; ?>',
					title: '<?php echo $fullname; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					color: '<?php echo $event['color']; ?>',
					truckid: '<?php echo $event['TruckID']; ?>',
					theid: '<?php echo $event['EmployeeID']; ?>',
					thetime:'<?php echo $event['thetime']; ?>',
				},
			<?php endforeach; ?>
			]
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			getid = event.theid;
			getruck = event.truckid;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			Event[3] = getid;
			Event[4] = getruck;
			
			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else if (rep=='no'){
						alert('Truck or Driver not available at that time'); 
						location.replace("scheduling.php"); 
					}else
					{
						alert('Could not be saved. try again.'); 
					}
				}
			});
		}
		
		function editdrop(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			getid = event.theid;
			getruck = event.truckid;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			Event[3] = getid;
			Event[4] = getruck;
			
			$.ajax({
			 url: 'editEventDateDrop.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else if (rep=='no'){
						alert('Truck or Driver not available at that time');
						location.replace("scheduling.php"); 
					}else
					{
						alert('Could not be saved. try again.'); 
					}
				}
			});
		}
	});

	
		


</script>

</body>

</html>
