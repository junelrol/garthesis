<?php  
 //action.php  
 if(isset($_POST["action"]))  
 {  
      $output = '';  
      $connect = mysqli_connect("den1.mysql2.gear.host", "root", "@garthesis", "garthesis");  
      if($_POST["action"] =="Add")  
      {  
           $client_name = mysqli_real_escape_string($connect, $_POST["clientName"]);  
           $client_address = mysqli_real_escape_string($connect, $_POST["clientAddress"]);
			$client_email = mysqli_real_escape_string($connect, $_POST["clientEmail"]);
			$client_contact_num = mysqli_real_escape_string($connect, $_POST["clientContactNum"]);
			$client_contact_person = mysqli_real_escape_string($connect, $_POST["clientContactPerson"]);
           $procedure = "  
                CREATE PROCEDURE insertUser(IN clientName varchar(200), clientAddress varchar(200), clientEmail varchar(200), clientContactNum varchar(200), clientContactPerson varchar(200))  
                BEGIN  
                INSERT INTO client(client_name, client_address, client_email, client_contact_num, client_contact_person) VALUES (clientName, clientAddress, clientEmail, clientContactNum, clientContactPerson);   
                END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS insertUser"))  
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                     $query = "CALL insertUser('".$client_name."', '".$client_address."', '".$client_email."', '".$client_contact_num."', '".$client_contact_person."')";  
                     mysqli_query($connect, $query);  
                     echo 'Data Inserted';  
                }  
           }  
      }  
      if($_POST["action"] == "Edit")  
      {  
           $client_name = mysqli_real_escape_string($connect, $_POST["clientName"]);  
           $client_address = mysqli_real_escape_string($connect, $_POST["clientAddress"]);
		   $client_email = mysqli_real_escape_string($connect, $_POST["clientEmail"]);
		   $client_contact_num = mysqli_real_escape_string($connect, $_POST["clientContactNum"]);
		   $client_contact_person = mysqli_real_escape_string($connect, $_POST["clientContactPerson"]);
           $procedure = "  
                CREATE PROCEDURE updateUser(IN id int(11), clientName varchar(200), clientAddress varchar(200), clientEmail varchar(200), clientContactNum varchar(200), clientContactPerson varchar(200))  
                BEGIN   
                UPDATE client SET client_name = clientName, client_address = clientAddress, client_email = clientEmail, client_contact_num = clientContactNum, client_contact_person = clientContactNum  
                WHERE id = client_id;  
                END;   
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS updateUser"))  
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                     $query = "CALL updateUser('".$_POST["id"]."', '".$client_name."', '".$client_address."', '".$client_email."', '".$client_contact_num."', '".$client_contact_person."')";  
                     mysqli_query($connect, $query);  
                     echo 'Data Updated';  
                }  
           }  
      }  
      if($_POST["action"] == "Delete")  
      {  
           $procedure = "  
           CREATE PROCEDURE deleteUser(IN id int(11))  
           BEGIN   
           DELETE FROM client WHERE id = client_id;  
           END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS deleteUser"))  
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                     $query = "CALL deleteUser('".$_POST["id"]."')";  
                     mysqli_query($connect, $query);  
                     echo 'Data Deleted';  
                }  
           }  
      }  
 }  
 ?>  