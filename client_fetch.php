<?php  
 //fetch.php  
 $connect = mysqli_connect("den1.mysql2.gear.host","root", "@garthesis", "garthesis");  
 if(isset($_POST["id"]))  
 {  
      $output = array();  
      $procedure = "  
      CREATE PROCEDURE whereUser(IN id int(11))  
      BEGIN   
      SELECT * FROM client WHERE id = client_id;  
      END;   
      ";  
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS whereUser"))  
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL whereUser(".$_POST["id"].")";  
                $result = mysqli_query($connect, $query);  
                while($row = mysqli_fetch_array($result))  
                {  
                     $output['client_name'] = $row["client_name"];  
                     $output['client_address'] = $row["client_address"]; 
					 $output['client_email'] = $row["client_email"]; 
					 $output['client_contact_num'] = $row["client_contact_num"]; 
					 $output['client_contact_person'] = $row["client_contact_person"]; 
                }  
                echo json_encode($output);  
           }  
      }  
 }  
 ?>  