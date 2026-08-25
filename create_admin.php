<?php

require('config/connection.php');

   $name = "Super Admin";
   $email = "admin123@gmail.com";
   $phone = "7876013060";
   $password = "1234";
   $role_id = 1;
   
   $password = password_hash($password, PASSWORD_DEFAULT);
   
   $sql = "INSERT INTO users (role_id, name, email, phone, password)
   VALUES (?, ?, ?, ?, ?)";
   
   $stmt = $conn->prepare($sql);
   
   $stmt->bind_param("issss", $role_id, $name, $email, $phone, $password);
   
   if($stmt->execute()){
	   echo "Super Admin created";
   }
   else{
	   echo "Failed";
   }
?>