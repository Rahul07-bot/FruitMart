<?php
   $host = "localhost";
   $username = "root";
   $password = "";
   $database = "fruit_mart";
   
   $conn = new mysqli($host, $username, $password, $database);
   
   if($conn->connect_error){
	   die("Connect Error" . $conn->connect_error);
   }
   else{
	 //  echo "Connect success";
   }
?>