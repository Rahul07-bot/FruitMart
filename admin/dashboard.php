<?php 
   session_start();
   
   require('../config/connection.php');
   
   if(!isset($_SESSION['user_id'])){
	   header("location:../login.php");
	   exit();
   }
   
   if($_SESSION['role_id'] == 5){
	   header("location:../index.php");
	   exit();
   }
   
   
   
   
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FruitMart Admin Dashboard</title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >

</head>

<body>

<?php include('includes/navbar.php'); ?>
<?php include('includes/sidebar.php'); ?>



   <div class="col-md-9 col-lg-10 p-4">

    <h2>Admin Dashboard</h2>

    <div class="card mt-4" style="width: 18rem;">

        <div class="card-body">

            <h5 class="card-title">
                Total Users
            </h5>
			
			<?php 
			   $sql = "SELECT COUNT(*) AS total_users FROM users WHERE role_id = 5";
			   
			   $result = $conn->query($sql);
			   
			   $row = $result->fetch_assoc();
			   
			   $total_users = $row['total_users'];
			?>
            <h2>
                <?php echo $total_users; ?>
            </h2>

        </div>

    </div>

</div>



</div>
</div>