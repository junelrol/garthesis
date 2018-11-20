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
?>
<style type="text/css">
    .feedback {
  background-color : #31B0D5;
  color: white;
  padding: 10px 20px;
  border-radius: 4px;
  border-color: #46b8da;
}

#mybutton {
  position: fixed;
  bottom: -4px;
  right: 10px;
}
@media print {
  #mybutton {
    display: none;
  }

  #thistable {
  width: 50%;
  height: auto;
  overflow: hidden;
 }

}
</style>
<div id="mybutton">
<button class="feedback" onclick="window.print()">Print</button>
</div>
<span id='alert_action'></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">SMS History</h3>
                            </div>
                        
                            <!-- <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
					
                            </div> -->
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="thistable" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>Device ID</th>
                                    <th>SMS details</th>
                                    <th>Date Sent</th>
                                    <th>To:</th>
                                </tr></thead>
                                <tbody>
                                	<?php
                                		$query = mysqli_query($mycon,"SELECT * FROM tblsmshistory
                                		 INNER JOIN tblemployee on tblemployee.emp_id=tblsmshistory.sendedid
                                		 ORDER BY datesend DESC");
                                		while ($row = mysqli_fetch_array($query)) {
                                			echo '
                                				<tr>
                                					<td>'.$row['deviceid'].'</td>
                                					<td>'.$row['smsDetails'].'</td>
                                					<td>'.date("M jS, Y", strtotime($row['datesend'])).'</td>
                                					<td>'.$row['emp_first_name'].' '.$row['emp_last_name'].'</td>

                                				</tr>
                                			';
                                		}
                                	?>
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div>
			</div>
		</div>