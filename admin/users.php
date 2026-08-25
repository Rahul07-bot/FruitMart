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
                <h2>Users</h2>

                
            </div>

            <!-- Fruit table -->
			
			<table class = "display" id = "myTable">
			   <thead>
			      <tr>
				     <th>Id</th>
				     <th>Users Name</th>
				     <th>Email</th>
				     <th>Phone</th>
				     <th>Status</th>
				     <th>Created at</th>
				  </tr>
			   </thead>
			   <tbody>
			      <?php 
                     $sql = "SELECT * FROM users WHERE role_id = 5";
					 $result = $conn->query($sql);
					 while($user = $result->fetch_assoc()){
				  ?>
				  <tr>
				     <td><?php echo $user['id']; ?></td>
				     <td><?php echo $user['name']; ?></td>
				     <td><?php echo $user['email']; ?></td>
				     <td><?php echo $user['phone']; ?></td>
				     <td><?php echo $user['status']; ?></td>
				     <td><?php echo $user['created_at']; ?></td>
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