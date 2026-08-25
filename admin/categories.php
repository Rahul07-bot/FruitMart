<?php

   session_start();

   require('../config/connection.php');

   if(!isset($_SESSION['user_id'])){
       header("Location: ../login.php");
       exit();
   }

   if($_SESSION['role_id'] == 5){
       header("Location: ../index.php");
       exit();
   }

   
   if(isset($_POST['add_category'])){
	   $category_name = trim($_POST['category_name']);
	   
	   if(empty($category_name)){
		   echo "Category name is required";
	   }
	   else{
	   //file upload
	   $target_dir = "../category_images/";
	   
	   $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
	   
	   $uploadOk = 1;
	   
	   $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	   
	   // check if file exist
	   if(file_exists($target_file)){
		   echo "Sorry file is already exist";
		   $uploadOk = 0;
	   }
	   
	   // check file size
	   if($_FILES["category_image"]["size"] > 500000){
		   echo "Sorry, file size is too large";
		   $uploadOk = 0;
	   }
	   
	   // check file extension
	   if(
	     $imageFileType != "jpeg" &&
	     $imageFileType != "jpg" &&
	     $imageFileType != "png" &&
	     $imageFileType != "gif"
	   ){
		   echo "Sorry, only jpeg, jpg, png and gif files are allowed";
		   $uploadOk = 0;
	   }
	   
	   if($uploadOk == 0){
		   echo "Sorry, your file cannot be uploaded";
	   }
	   
	   else{
		   if(move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)){
			   $fileupload = basename($_FILES["category_image"]["name"]);
			   
			   $sql = "INSERT INTO categories (category_name, image)
			   VALUES(?, ?)";
			   
			   $stmt = $conn->prepare($sql);
			   
			   $stmt->bind_param("ss", $category_name, $fileupload);
			   
		       $stmt->execute();
		   }
	   }
   }
   }
  

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categories</title>
	<link rel = "stylesheet" href = "css/categories.css">

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
	<link rel="stylesheet" href="https://cdn.datatables.net/3.0.1/css/dataTables.dataTables.css" />
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/3.0.1/js/dataTables.js"></script>
	
	

</head>

<body>

<?php include('includes/navbar.php'); ?>

<div class="container-fluid">

    <div class="row">

        <?php include('includes/sidebar.php'); ?>

        <div class="col-md-9 col-lg-10 p-4 categories">

            <h2>Categories</h2>

            <form action="" method="POST" enctype="multipart/form-data">

    <div class="mb-3">

        <label class="form-label">Category Name</label>
        <input type = "text" name = "category_name" class = "form-control" placeholder = "Enter category name">

    </div>


    <div class="mb-3">

        <label class="form-label">Category Image</label>
        <input type="file" name="category_image" class="form-control">

    </div>


    <button type="submit" name="add_category" class="btn btn-success">Add Category</button>

</form>
			
			<h3 class="mt-5">Category List</h3>
			
			<table class = "display" id = "myTable">
			   <thead>
			      <tr>
				     <th>Id</th>
				     <th>Category Name</th>
				     <th>Image</th>
				     <th>Created at</th>
				     <th>Update</th>
				     <th>Delete</th>
				  </tr>
			   </thead>
			   
			   <tbody>
			   <?php 
			      $sql = "SELECT * FROM categories";
				  
				  $result = $conn->query($sql);
				  
				  while($row = $result->fetch_assoc()){
			   ?>
			      <tr>
				     <td><?php echo $row['id']; ?></td>
				     <td><?php echo $row['category_name']; ?></td>
				     <td><img src = "../category_images/<?php echo $row['image']; ?>" class = "category_img"></td>
				     <td><?php echo $row['created_at']; ?></td>
					 <td>
					    <a href = "update_category.php?id=<?php echo $row['id'];?>" class = "btn btn-primary btn-sm">Upadate</a>
					 </td>
					 <td>
					    <a href = "delete_category.php?id=<?php echo $row['id'];?>" class = "btn btn-danger btn-sm">Delete</a>
					 </td>
				  </tr>
				  <?php } ?>
			   </tbody>
			</table>
			
			<script>
			   $(document).ready(function(){
				   $('#myTable').DataTable({
					   lengthMenu : [5,10]
				   });
			   });
			</script>

        </div>

    </div>

</div>

</body>

</html>