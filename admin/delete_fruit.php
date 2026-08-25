<?php 
   session_start();
   
   require('../config/connection.php');
   
   if(!isset($_SESSION['user_id'])){
	   header('Location:../login.php');
	   exit();
   }
   
   if($_SESSION['role_id'] == 5){
	   header("Location:../index.php");
	   exit();
   }
   
   $id = $_GET['id'];
   
   // fetch fruits details
   $sql = "SELECT * FROM fruits WHERE id = ?";
   
   $stmt = $conn->prepare($sql);
   
   $stmt->bind_param("i", $id);
   
   $stmt->execute();
   
   $result = $stmt->get_result();
   
   $row = $result->fetch_assoc();
   
   // old image
   $old_image = $row['image'];
   
   
   
   // Delete fruit row
   $sql = "DELETE FROM fruits WHERE id = ?";
   
   $stmt = $conn->prepare($sql);
   
   $stmt->bind_param("i", $id);
   
   if($stmt->execute()){
	   // delete old image
	   unlink("../fruit_images/" . $old_image);
	   
	   // redirect user
	   header("Location:fruits.php");
	   exit();
   }
   else{
	   echo "Error:" . $stmt->error;
   }
?>