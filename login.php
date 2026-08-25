<?php 

   require('header.php');

   
   
   require('config/connection.php');
   
   if(isset($_SESSION['user_id'])){
	   if($_SESSION['role_id'] == 5){
		   header("location:index.php");
		   exit();
	   }
	   else{
		   header("location:admin/dashboard.php");
		   exit();
	   }
   }
   
   if(isset($_POST['login'])){
	   $email = trim($_POST['email']);
	   $password = $_POST['password'];
	   
	   if(empty($email) || empty($password)){
		   $error = "All fields are required.";
	   }
	   
	   else{
		   $check_email = "SELECT * FROM users WHERE email = ?";
		   
		   $stmt = $conn->prepare($check_email);
		   
		   $stmt->bind_param("s", $email);
		   
		   $stmt->execute();
		   
		   $result = $stmt->get_result();
		   
		   if($result->num_rows == 1){
			   $user = $result->fetch_assoc();
			   
			   if(password_verify($password, $user['password'])){
				   
				   // remove guest cart after login
				   unset($_SESSION['guest_cart']);
				   
				   
				   $_SESSION['user_id'] = $user['id'];
				   $_SESSION['role_id'] = $user['role_id'];
				   $_SESSION['name'] = $user['name'];
				   $_SESSION['email'] = $user['email'];
				   
				   if($user['role_id'] != 5){
					   header("location:admin/dashboard.php");
					   exit();
				   }
				   else{
					   header("location:index.php");
					   exit();
				   }
			   }
			   else{
				   $error = "Incorrect Password.";
			   }
		   }
		   
		   else{
			   $error = "Email doesn't exist.";
		   }
	   }
   }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FruitMart</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- css link -->
	<link rel = "stylesheet" href = "css/login.css" type = "text/css">
</head>
<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h1>Login Form</h1>
                </div>

                <div class="card-body">

                    <form action="" method="POST" class = "login_form">
					
					<!-- error messagge close button -->
					
				    <?php if(!empty($error)){ ?>
					<div class = "error-message" id = "errorMsg">
					   <span><?php echo $error; ?></span>
					   <button type="button" class="close_btn" onclick="closeMessage()">
                          &times;
                       </button>
					</div>
					<?php } ?>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password">
                        </div>

                        <button type="submit" name="login" class="btn btn-success w-100 button">Login</button>
						<div class = "or">OR</div>
						<div class = "register">
						<span class = "register_content">Don't have any account?</span>&nbsp;&nbsp;
						<a href = "register.php" class = "register_link">Register</a>
					    </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
   function closeMessage(){
	   document.getElementById("errorMsg").style.display = "none";
   }
</script>
</body>
</html>

<?php require('footer.php'); ?>