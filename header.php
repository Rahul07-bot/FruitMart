<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FruitMart</title>

    <!-- Bootstrap CDN -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
	
	<!-- css link -->
	<link rel = "stylesheet" href = "css/header.css" type = "text/css">
	
	<!-- icon link -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	

</head>

<body>

<!-- navbar -->
	<nav class="navbar navbar-expand-sm bg-black navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src = "images/logo.png" class = "main_logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text" href="fruits.php">Fruits</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text" href="about_us.php">About Us</a>
        </li>  
		<li class="nav-item">
          <a class="nav-link text" href="contact_us.php">Contact Us</a>
        </li>  
		
		<?php if(@$_SESSION['user_id'] == ''){ ?>
		<li class="nav-item">
          <a class="nav-link text" href="login.php"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp;Login</a>
        </li>  
		<?php } 
		   else{
		?>
		   <li class="nav-item user_name">
              <a class="nav-link text" href="#"><i class="fa fa-user-circle-o" style="font-size:24px"></i>
			  &nbsp;<span class = "user_name"><?php echo $_SESSION['name'] ?></span></a>
			  
			  <ul class = "name_dropdown">
			     <li><a href = "my_profile.php">My Profile</a></li>
				 <li><a href = "my_orders.php">My Orders</a></li>
				 <li><a href = "logout.php">Logout</a></li>
			  </ul>
			  
           </li>
		   <?php } ?>
		
		<li class="nav-item">
          <a class="nav-link text" href="cart.php"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Cart</a>
        </li>
        
      </ul>
    </div>
	
  </div>
</nav>