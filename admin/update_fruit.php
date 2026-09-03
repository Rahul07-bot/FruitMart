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
   
   $id = $_GET['id'];
   
   // fetch fruit details
   $sql = "SELECT * from fruits WHERE id = ?";
   
   $stmt = $conn->prepare($sql);
   
   $stmt->bind_param("i", $id);
   
   $stmt->execute();
   
   $result = $stmt->get_result();
   
   $row = $result->fetch_assoc();
   
   $old_image = $row['image'];
   
   
   if(isset($_POST['update_fruit'])){
	   $category_id = $_POST['category_id'];
	   $fruit_name = trim($_POST['fruit_name']);
	   $price = $_POST['price'];
	   $quantity = $_POST['quantity'];
	   $description = trim($_POST['description']);
	   $status = $_POST['status'];
	   
	   // validate fields
	   if(empty($category_id) || empty($fruit_name) || empty($price) || empty($quantity) || empty($description)){
		   echo "All fields are required.";
	   }
	   
	   else{
		   // if image is selected
		   if(!empty($_FILES["image"]["name"])){
			   $target_dir = "../fruit_images/";
			   
			   $target_file = $target_dir . basename($_FILES["image"]["name"]);
			   
			   $uploadOk = 1;
			   
			   $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			   
			   // check if file already exist
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
				   echo "Sorry, only jpeg, jpg, png and gif files are allowed.";
				   $uploadOk = 0;
			   }
			   
			   if($uploadOk == 0){
				   echo "Sorry, your file cannot be uploaded.";
			   }
			   
			   else{
				   if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
					   $fileupload = basename($_FILES["image"]["name"]);
					   
					   // update fruits details and image also
					   $sql = "UPDATE fruits SET category_id = ?, fruit_name = ?, price = ?, quantity = ?, description = ?, 
					   image = ?, status = ? WHERE id = ?";
					    
					   $stmt = $conn->prepare($sql);
					   
					   $stmt->bind_param("isdisssi", $category_id, $fruit_name, $price, $quantity, $description, $fileupload, $status, $id);
					   
					   $stmt->execute();
					   
					   // delete old image
					   unlink("../fruit_images/" . $old_image);
					   
					   // redirect user
					   header("Location:fruits.php");
					   exit();
					   
				   }
				   
				   else{
					   echo "Sorry, there was an error to upload your file.";
				   }
			   }
		   }
		   
		   else{
			   // if image is not selecte
			   $sql = "UPDATE fruits SET category_id = ?, fruit_name = ?, price = ?, quantity = ?, description = ?, 
					   status = ? WHERE id = ?";
					   
					   $stmt = $conn->prepare($sql);
					   
					   $stmt->bind_param("isdissi", $category_id, $fruit_name, $price, $quantity, $description, $status, $id);
					   
					   $stmt->execute();
					   
					   header("Location:fruits.php");
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

    <title>Update Fruit</title>

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

            <h2>Update Fruit</h2>


            <div class="card mt-4">

                <div class="card-body">

                    <form action="" method="POST" enctype="multipart/form-data">


                        <!-- Category -->

                        <div class="mb-3">

                            <label class="form-label">
                                Category
                            </label>

                            <select name="category_id" class="form-select">

									<option value="">
										Select Category
									</option>

									<?php 
									   // fetch category id
									   $sql = "SELECT * FROM categories";
									   
									   $result = $conn->query($sql);
									   
									   while($category = $result->fetch_assoc()){
									?>
									<option value = "<?php echo $category['id']; ?>"
									   <?php if($category['id'] == $row['category_id']){
										   echo "selected";
									   }
									   ?>
									>
									   <?php echo $category['category_name']; ?>
									</option>
									   <?php } ?>

                            </select>

                        </div>


                        <!-- Fruit Name -->

                        <div class="mb-3">

                            <label class="form-label">
                                Fruit Name
                            </label>

                            <input type="text" name="fruit_name" class="form-control" value = "<?php echo $row['fruit_name']; ?>">

                        </div>


                        <!-- Price -->

                        <div class="mb-3">

                            <label class="form-label">
                                Price
                            </label>

                            <input type="number" name="price" class="form-control" value = "<?php echo $row['price']; ?>">

                        </div>


                        <!-- Quantity -->

                        <div class="mb-3">

                            <label class="form-label">
                                Quantity
                            </label>

                            <input type="number" name="quantity" class="form-control" value = "<?php echo $row['quantity']; ?>">

                        </div>


                        <!-- Description -->

                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description" class="form-control" rows="4"><?php echo $row['description']; ?></textarea>

                        </div>


                        <!-- Current Image -->

                        <div class="mb-3">

                            <label class="form-label">
                                Current Image
                            </label>

                            <br>

                            <img src="../fruit_images/<?php echo $row['image']; ?>" style = "width:100px; height:100px; border-radius:12px;">

                        </div>


                        <!-- New Image -->

                        <div class="mb-3">

                            <label class="form-label">
                                Change Image
                            </label>

                            <input type="file" name="image" class="form-control">

                        </div>


                        <!-- Status -->

                        <div class="mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="status" class="form-select">

                                <option value="Available" 
								   <?php 
								      if($row['status'] == 'Available'){
										  echo "selected";
									  }
								   ?>
								>
                                    Available
                                </option>


                                <option value="Out of Stock"
								   <?php 
								      if($row['status'] == 'Out of Stock'){
										  echo "selected";
									  }
								   ?>
								>
                                    Out of Stock
                                </option>

                            </select>

                        </div>


                        <button type="submit" name="update_fruit" class="btn btn-primary">
                            Update Fruit
                        </button>


                        <a href="fruits.php" class="btn btn-secondary">
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