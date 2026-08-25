<?php 
   session_start();
   
   require('../config/connection.php');
   
   if(!isset($_SESSION['user_id'])){
	   header("Location:../login.php");
	   exit();
   }
   
   if($_SESSION['role_id'] == 5){
	   header("Location:../index.php");
	   exit();
   }
   
   if(isset($_POST['add_fruit'])){
	   $category_id = $_POST['category_id'];
	   $fruit_name = trim($_POST['fruit_name']);
	   $price = $_POST['price'];
	   $quantity = $_POST['quantity'];
	   $description = $_POST['description'];
	   $status = $_POST['status'];
	   
	   // validate fields
	   if(empty($category_id) || empty($fruit_name) || empty($price) || empty($quantity) || empty($description)){
		   echo "All fields are required.";
	   }
	   
	   else{
		   // file upload
		   $target_dir = "../fruit_images/";
		   
		   $target_file = $target_dir . basename($_FILES["image"]["name"]);
		   
		   $uploadOk = 1;
		   
		   $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		   
		   // check if file is already exist
		   if(file_exists($target_file)){
			   echo "Sorry, file is already exist.";
			   $uploadOk = 0;
		   }
		   
		   // check file size
		   if($_FILES["image"]["size"] > 500000){
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
			   echo "Sorry! only jpeg, jpg, gif and png files are allowed.";
			   $uploadOk = 0;
		   }
		   
		   if($uploadOk == 0){
			   echo "Sorry, your file cannot be uploaded.";
		   }
		   
		   else{
			   if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
				   $fileupload = basename($_FILES["image"]["name"]);
				   
				   // insert query
				   $sql = "INSERT INTO fruits (category_id, fruit_name, price, quantity, description, image, status)
				   VALUES (?, ?, ?, ?, ?, ?, ?)";
				   
				   $stmt = $conn->prepare($sql);
				   
				   $stmt->bind_param("isdisss", $category_id, $fruit_name, $price, $quantity, $description, $fileupload, $status);
				   
				   if($stmt->execute()){
					   header("Location:fruits.php");
					   exit();
				   }
				   else{
					   echo "Error: " . $stmt->error;
				   }
			   }
			   
			   else{
				   echo "Sorry! there was an error to upload your file.";
			   }
		   }
	   }
	   
   }
?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Fruit</title>


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

            <h2>Add Fruit</h2>
			
			<div class="card mt-4">

    <div class="card-body">

        <form action="" method="POST" enctype="multipart/form-data">

            <!-- Category -->

            <div class="mb-3">

                <label for="category_id" class="form-label">
                    Category
                </label>

                <select name="category_id" id="category_id" class="form-select">

                    <option value="">
                        Select Category
                    </option>
					
					<?php 
					   $sql = "SELECT * FROM categories";
					   
					   $result = $conn->query($sql);
					   
					   while($row = $result->fetch_assoc()){
					?>
					
					<option value = "<?php echo $row['id']; ?>">
					   <?php echo $row['category_name']; ?>
					</option>
					   <?php } ?>

                </select>

            </div>


            <!-- Fruit Name -->

            <div class="mb-3">

                <label for="fruit_name" class="form-label">
                    Fruit Name
                </label>

                <input type="text" name="fruit_name" id="fruit_name" class="form-control">

            </div>


            <!-- Price -->

            <div class="mb-3">

                <label for="price" class="form-label">
                    Price
                </label>

                <input type="number" name="price" id="price" class="form-control">

            </div>


            <!-- Quantity -->

            <div class="mb-3">

                <label for="quantity" class="form-label">
                    Quantity
                </label>

                <input type="number" name="quantity" id="quantity" class="form-control" >

            </div>


            <!-- Description -->

            <div class="mb-3">

                <label for="description" class="form-label">
                    Description
                </label>

                <textarea name="description" id="description" class="form-control" rows="4" ></textarea>

            </div>


            <!-- Image -->

            <div class="mb-3">

                <label for="image" class="form-label">
                    Fruit Image
                </label>

                <input type="file" name="image" id="image" class="form-control" >

            </div>


            <!-- Status -->

            <div class="mb-3">

                <label for="status" class="form-label">
                    Status
                </label>

                <select name="status" id="status" class="form-select" >

                    <option value="Available">
                        Available
                    </option>

                    <option value="Out of Stock">
                        Out of Stock
                    </option>

                </select>

            </div>


            <button type="submit" name="add_fruit" class="btn btn-primary" >
                Add Fruit
            </button>


            <a href="fruits.php" class="btn btn-secondary" >
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