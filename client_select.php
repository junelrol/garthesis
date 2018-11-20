<?php  
 //select.php  
 $output = '';  
 $connect = mysqli_connect("den1.mysql2.gear.host", "root", "@garthesis", "garthesis");  
 if(isset($_POST["action"]))  
 {  
      $procedure = "  
      CREATE PROCEDURE selectUser()  
      BEGIN  
      SELECT * FROM client ORDER BY client_id DESC;  
      END;  
      ";  
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS selectUser"))  
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL selectUser()";  
                $result = mysqli_query($connect, $query);  
                $output .= '  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="20%">Client Name</th>  
                               <th width="15%">Client Address</th>
							   <th width="15%">Client Email</th>
							   <th width="15%">Client Contact Number</th>
							   <th width="15%">Client Contact Person</th>
                               <th width="10%">Update</th>  
                               <th width="10%">Delete</th>  
                          </tr>  
                ';  
                if(mysqli_num_rows($result) > 0)  
                {  
                     while($row = mysqli_fetch_array($result))  
                     {  
                          $output .= '  
                               <tr>  
                                    <td>'.$row["client_name"].'</td>  
                                    <td>'.$row["client_address"].'</td>
									<td>'.$row["client_email"].'</td>
									<td>'.$row["client_contact_num"].'</td>
									<td>'.$row["client_contact_person"].'</td>
                                    <td><button type="button" name="update" id="'.$row["client_id"].'" class="update btn btn-success btn-xs">Update</button></td>  
                                    <td><button type="button" name="delete" id="'.$row["client_id"].'" class="delete btn btn-danger btn-xs">Delete</button></td>  
                               </tr>  
                          ';  
                     }  
                }  
                else  
                {  
                     $output .= '  
                          <tr>  
                               <td colspan="7">Data not Found</td>  
                          </tr>  
                     ';  
                }  
                $output .= '</table>';  
                echo $output;  
           }  
      }  
 }  
 ?>  