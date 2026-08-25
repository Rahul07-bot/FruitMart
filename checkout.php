<?php
   require('header.php');

   require('config/connection.php');
   
   if(!isset($_SESSION['user_id'])){
	   header("Location:login.php");
	   exit();
   }
   
   if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
	   echo "Your cart is empty.";
	   exit();
   }
   
   // fetch total Amount
   $total = 0;
   
   foreach($_SESSION['cart'] as $fruit){
	   $total_item = $fruit['price'] * $fruit['cart_quantity'];
	   
	   $total = $total + $total_item;
   }
   
   
   if(isset($_POST['place_order'])){
	   $phone = $_POST['phone'];
	   
	   $address = $_POST['address'];
	   
	   $payment_method = $_POST['payment_method'];
	   
	   // insert order to table
	   $sql = "INSERT INTO orders (user_id, total_amount, address, phone, payment_method)
	   VALUES(?, ?, ?, ?, ?)";
	   
	   $stmt = $conn->prepare($sql);
	   
	   $stmt->bind_param("idsss", $_SESSION['user_id'], $total, $address, $phone, $payment_method);
	   
	   $stmt->execute();
	   
	   $order_id = $conn->insert_id;
	   
	   // take each fruit from cart
	   foreach($_SESSION['cart'] as $fruit){
		   $sql = "INSERT INTO order_items (order_id, fruit_id, quantity, price)
		   VALUES(?, ?, ?, ?)";
		   
		   $stmt = $conn->prepare($sql);
		   
		   $stmt->bind_param("iiid", $order_id, $fruit['id'], $fruit['cart_quantity'], $fruit['price']);
		   
		   $stmt->execute();
	   }
	   
	   // clear cart
	   unset($_SESSION['cart']);
	   
	   // regirect users
	   header("location:order_success.php");
	   exit();
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

    <title>Checkout - FruitMart</title>


    <!-- Bootstrap CDN -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- css link -->
	<link rel = "stylesheet" href = "css/checkout.css" type = "text/css">

</head>


<body>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body">

                    <h1 class="mb-4">
                        Checkout
                    </h1>


                    <form method="POST">


                        <!-- Phone -->

                        <div class="mb-3">

                            <label for="phone" class="form-label">
                                Phone Number
                            </label>

                            <input type="text" name="phone" id="phone" class="form-control" required>

                        </div>


                        <!-- Address -->

                        <div class="mb-3">

                            <label for="address" class="form-label">
                                Delivery Address
                            </label>

                            <textarea name="address" id="address" class="form-control" rows="4" required></textarea>

                        </div>


                        <!-- Payment Method -->

                        <div class="mb-3">

                            <label for="payment_method" class="form-label">
                                Payment Method
                            </label>

                            <select name="payment_method" id="payment_method" class="form-select" required>

                                <option value="">
                                    Select Payment Method
                                </option>

                                <option value="Cash on Delivery">
                                    Cash on Delivery
                                </option>

                            </select>

                        </div>


                        <!-- Total -->

                        <div class="mb-3">

                            <h5>
                                Total Amount:
                                ₹<?php echo $total; ?>
                            </h5>

                        </div>


                        <!-- Place Order -->

                        <button type="submit" name="place_order" class="btn  w-100 button">

                            Place Order

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