<?php
   session_start();
   
   require('../config/connection.php');
   
   // check if user is logged in
   if(!isset($_SESSION['user_id'])){
	   header("location:../login.php");
	   exit();
   }
   
   // check if customer not access this page
   if($_SESSION['role_id'] == 5){
	   header("location:../index.php");
	   exit();
   }
   
   $id = $_GET['id'];
   
   
   // fetch id details
   $sql = "SELECT * FROM categories WHERE id = ?";
   
   $stmt = $conn->prepare($sql);
   
   $stmt->bind_param("i", $id);
   
   $stmt->execute();
   
   $result = $stmt->get_result();
   
   $row = $result->fetch_assoc();
   
   // store old image
   $old_image = $row['image'];
   
   
   if(isset($_POST['update_category'])){
	   $category_name = trim($_POST['category_name']);
	   
	   // validate category_name
	   if(empty($category_name)){
		   echo "Category name is required.";
	   }
	   
	   else{
		   // if select image to update
		   if(!empty($_FILES["category_image"]["name"])){
			   $target_dir = "../category_images/";
			   
			   $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
			   
			   $uploadOk = 1;
			   
			   $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			   
			   // check if image is already exist
			   if(file_exists($target_file)){
				   echo "Sorry, file is already exist";
				   $uploadOk = 0;
			   }
			   
			   // check file size
			   if($_FILES["category_image"]["size"] > 500000){
				   echo "Sorry, file size is too large.";
				   $uploadOk = 0;
			   }
			   
			   // check file extension
			   if(
			      $imageFileType != "jpeg" &&
			      $imageFileType != "jpg" &&
			      $imageFileType != "gif" &&
			      $imageFileType != "png"
			   ){
				   echo "Sorry, only jpeg, jpg, png and gif files are allowed.";
				   $uploadOk = 0;
			   }
			   
			   if($uploadOk == 0){
				   echo "Sorry, there was an error to upload your file.";
			   }
			   
			   else{
				   if(move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)){
					   $fileupload = basename($_FILES["category_image"]["name"]);
					   
					   // update name and Image
					   $sql = "UPDATE categories SET category_name = ?, image = ? WHERE id = ?";
					   
					   $stmt = $conn->prepare($sql);
					   
					   $stmt->bind_param("ssi", $category_name, $fileupload, $id);
					   
					   $stmt->execute();
					   
					   // delete old image
					   unlink("../category_images/" . $old_image);
					   
					   header("location:categories.php");
					   exit();
				   }
			   }
		   }
		   // if only name update
		   else{
			   $sql = "UPDATE categories SET category_name = ? WHERE id = ?";
			   
			   $stmt = $conn->prepare($sql);
			   
			   $stmt->bind_param("si", $category_name, $id);
			   
			   $stmt->execute();
			   
			   header("location:categories.php");
			   exit();
		   }
	   }
   }
   
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Update Category</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body>


<?php include('includes/navbar.php'); ?>


<div class="container-fluid">

    <div class="row">

        <?php include('includes/sidebar.php'); ?>


        <div class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4">Update Category</h2>


            <div class="card">

                <div class="card-body">

                    <form action="" method="POST" enctype="multipart/form-data" >


                        <!-- Category Name -->

                        <div class="mb-3">

                            <label for="category_name" class="form-label" >
                                Category Name
                            </label>

                            <input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo $row['category_name']; ?>" >

                        </div>


                        <!-- Current Image -->

                        <div class="mb-3">

                            <label class="form-label">
                                Current Image
                            </label>

                            <br>

                            <img src="../category_images/<?php echo $row['image']; ?>" class="img-thumbnail" width="120" >

                        </div>


                        <!-- New Image -->

                        <div class="mb-3">

                            <label for="category_image" class="form-label">
                                Change Image
                            </label>

                            <input type="file" name="category_image" id="category_image" class="form-control" >

                        </div>


                        <!-- Update Button -->

                        <button type="submit" name="update_category" class="btn btn-primary" >
                            Update Category
                        </button>


                        <a href="categories.php" class="btn btn-secondary" >
                            Cancel
                        </a>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


</body>

</html>