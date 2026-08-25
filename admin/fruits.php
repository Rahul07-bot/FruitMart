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
   
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruits</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="https://cdn.datatables.net/3.0.1/css/dataTables.dataTables.css" />
	<script src="https://code.jquery.com/jquery-4.0.0.min.js"></script>
	<script src="https://cdn.datatables.net/3.0.1/js/dataTables.js"></script>
</head>
<body>

<?php include('includes/navbar.php'); ?>


<div class="container-fluid">
    <div class="row">
<?php include('includes/sidebar.php'); ?>
        <div class="col-md-9 col-lg-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Fruits</h2>

                <a href="add_fruit.php" class="btn btn-primary">
                    + Add Fruit
                </a>
            </div>

            <!-- Fruit table -->
			
			<table class = "display" id = "myTable">
			   <thead>
			      <tr>
				     <th>Id</th>
				     <th>Category Id</th>
				     <th>Fruit Name</th>
				     <th>Price</th>
				     <th>Quantity</th>
				     <th>Image</th>
				     <th>Status</th>
				     <th>Created at</th>
				     <th>Update</th>
				     <th>Delete</th>
				  </tr>
			   </thead>
			   
			   <tbody>
			      <?php 
				     $sql = "SELECT fruits.*, categories.category_name
					         FROM fruits
							 INNER JOIN categories
							 ON fruits.category_id = categories.id
					 ";
					 
					 $result = $conn->query($sql);
					 
					 while($row = $result->fetch_assoc()){
				  ?>
				  <tr>
				     <td><?php echo $row['id']; ?></td>
				     <td><?php echo $row['category_name']; ?></td>
				     <td><?php echo $row['fruit_name']; ?></td>
				     <td><?php echo $row['price']; ?></td>
				     <td><?php echo $row['quantity']; ?></td>
				     <td><img src = "../fruit_images/<?php echo $row['image']; ?>" style = "width:100px; border-radius:12px;"></td>
				     <td><?php echo $row['status']; ?></td>
				     <td><?php echo $row['created_at']; ?></td>
				     <td>
					    <a href = "update_fruit.php?id=<?php echo $row['id']; ?>" class = "btn btn-primary btn-sm">Update</a>
					 </td>
				     <td>
					    <a href = "delete_fruit.php?id=<?php echo $row['id']; ?>" class = "btn btn-danger btn-sm">Delete</a>
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