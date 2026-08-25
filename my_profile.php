<?php
require('header.php');
require('config/connection.php');

if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit();
}
   $id = $_SESSION['user_id'];
      // fetch logged in user details
	  $sql = "SELECT * FROM users WHERE id = ?";
	  $stmt = $conn->prepare($sql);
	  $stmt->bind_param("i", $id);
	  $stmt->execute();
	  $result = $stmt->get_result();
	  $user = $result->fetch_assoc();
	  
	  // update user information
	  if(isset($_POST['update_profile'])){
		  $name = $_POST['name'];
		  $email = $_POST['email'];
		  $phone = $_POST['phone'];
		  
		  // email check 
		  $sql = "SELECT id FROM users WHERE email = ? AND id != ?";
		  $stmt = $conn->prepare($sql);
		  $stmt->bind_param("si", $email, $id);
		  $stmt->execute();
		  $result = $stmt->get_result();
		  
		  if($result->num_rows > 0){
			  echo "Email is already exist.";
		  }
		  else{
			  // update
			  $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
			  $stmt = $conn->prepare($sql);
			  $stmt->bind_param("sssi", $name, $email, $phone, $id);
			  $stmt->execute();
			  header("Location:index.php");
			  exit();
		  }
	  }
	  
	  // change Password
	  if(isset($_POST['change_password'])){
		  $current_password = $_POST['current_password'];
		  $new_password = $_POST['new_password'];
		  $confirm_password = $_POST['confirm_password'];
		  
		  // check current Password
		  if(!password_verify($current_password, $user['password'])){
			  echo "Current password doesn't matched";
			  exit();
		  }
		  
		  // check new password and confirm Password
		  if($new_password != $confirm_password){
			  echo "New password and confirm password doesn't matched.";
			  exit();
		  }
		  
		  // hash the password 
		  $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
		  
		  // update Password
		  $sql = "UPDATE users SET password = ? WHERE id = ?";
		  $stmt = $conn->prepare($sql);
		  $stmt->bind_param("si", $new_password_hash, $id);
		  $stmt->execute();
		  echo "Password changed successfully.";
		  
	  }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile - FruitMart</title>

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-7">

            <!-- Page Heading -->

            <div class="text-center mb-4">

                <h2>
                    My Profile
                </h2>

                <p class="text-muted">
                    Manage your account information
                </p>

            </div>


            <!-- Profile Information -->
			
			

            <div class="card shadow mb-4">

                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Profile Information
                    </h5>

                </div>


                <div class="card-body">

                    <form method="POST">


                        <!-- Name -->

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input type="text" name="name" class="form-control" value = "<?php echo $user['name']; ?>">

                        </div>


                        <!-- Email -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email" name="email" class="form-control" value = "<?php echo $user['email']; ?>">

                        </div>


                        <!-- Phone -->

                        <div class="mb-3">

                            <label class="form-label">
                                Phone
                            </label>

                            <input type="text" name="phone" class="form-control" value = "<?php echo $user['phone']; ?>">

                        </div>


                        <button type="submit" name="update_profile" class="btn btn-success">
                            Update Profile
                        </button>


                    </form>

                </div>

            </div>


            <!-- Change Password -->

            <div class="card shadow">

                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Change Password
                    </h5>

                </div>


                <div class="card-body">

                    <form method="POST">


                        <!-- Current Password -->

                        <div class="mb-3">

                            <label class="form-label">
                                Current Password
                            </label>

                            <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>

                        </div>


                        <!-- New Password -->

                        <div class="mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>

                        </div>


                        <!-- Confirm Password -->

                        <div class="mb-3">

                            <label class="form-label">
                                Confirm New Password
                            </label>

                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>

                        </div>


                        <button type="submit" name="change_password" class="btn btn-primary">
                            Change Password
                        </button>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>

<?php require('footer.php'); ?>