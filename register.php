<?php
   require('header.php');
   require('config/connection.php');
   
   if(isset($_POST['register'])){
	   $name = trim($_POST['name']);
	   $email = trim($_POST['email']);
	   $phone = trim($_POST['phone']);
	   $password = $_POST['password'];
	   $confirm_password = $_POST['confirm_password'];
	   
	   if(empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)){
		   $error = "All fields are required.";
	   }
	   
	   else if($password != $confirm_password){
		   $error = "password doesn't matched.";
	   }
	   
	   else{
		   $check_email = "SELECT * FROM users WHERE email = ?";
		   
		   $stmt = $conn->prepare($check_email);
		   
		   $stmt->bind_param("s", $email);
		   
		   $stmt->execute();
		   
		   $result = $stmt->get_result();
		   
		   if($result->num_rows > 0){
			   $error = "Email already exist";
		   }
		   
		   else{
			   $password = password_hash($password, PASSWORD_DEFAULT);
			   
			   $role_id = 5;
			   
			   $insert_query = "INSERT INTO users (role_id, name, email, phone, password)
			      VALUES(?, ?, ?, ?, ?)
			   ";
			   
			   $stmt = $conn->prepare($insert_query);
			   
			   $stmt->bind_param("issss", $role_id, $name, $email, $phone, $password);
			   
			   if($stmt->execute()){
				   header("location:login.php");
				   exit();
			   }
			   else{
				   echo "Registration failed";
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
    <title>Register | FruitMart</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- css link -->
	<link rel = "stylesheet" href = "css/register.css" type = "text/css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h1>Create Your <span class = "card_header">Account</span></h1>
                </div>

                <div class="card-body">

                    <form action="" method="POST">
					<?php if(!empty($error)){ ?>
					<div id = "errorMsg" class = "error-message">
					   <span><?php echo $error; ?></span>
					   <button type = "button" class="close_btn" onclick = "closeMessage()">&times;</button>
					</div>
					<?php } ?>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder = "Enter your name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder = "Enter your email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder = "Enter your number">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder = "Enter passowrd">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control"  placeholder = "Enter confirm password">
                        </div>

                        <button type="submit" name="register" class="btn button w-100">
                            Register
                        </button>
						<div class = "or">OR</div>
						<div class = "register">
						<span class = "register_content">Already have an account?</span>&nbsp;&nbsp;
						<a href = "login.php" class = "register_link">Login</a>
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