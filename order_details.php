<?php
   require('header.php');
   require('config/connection.php');
   
   // check if user is loged in 
   if(!isset($_SESSION['user_id'])){
	   header("Location:login.php");
	   exit();
   }
   
   // check if order id exist
   if(!isset($_GET['id'])){
	   echo "Invalid order";
	   exit();
   }
   
   $order_id = $_GET['id'];
   
   $user_id = $_SESSION['user_id'];
   
   // fetch order Details
   $sql = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
   
   $stmt = $conn->prepare($sql);
   
   $stmt->bind_param("ii", $order_id, $user_id);
   
   $stmt->execute();
   
   $result = $stmt->get_result();
   
   $order = $result->fetch_assoc();
   
   // fetch order items with frit Details
   $sql = "SELECT order_items.*, fruits. fruit_name, fruits. image
           FROM order_items
		   JOIN fruits
		   ON order_items. fruit_id = fruits. id
		   WHERE order_items. order_id = ?";
   
   $stmt = $conn->prepare($sql);
   
   $stmt->bind_param("i", $order_id);
   
   $stmt->execute();
   
   $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Order Details - FruitMart</title>

    <!-- Bootstrap CSS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body>


<div class="container py-5">

    <!-- Page Heading -->

    <h2 class="mb-4">
        Order Details
    </h2>


    <!-- Order Information -->

    <div class="card mb-4">

        <div class="card-body">

            <h5 class="card-title"> 
			Order #<?php echo $order['id']; ?>
            </h5>

            <p class="mb-1">
                <strong>Order Date:</strong>
				<?php echo $order['created_at']; ?>
            </p>

            <p class="mb-1">
                <strong>Payment Method:</strong>
				<?php echo $order['payment_method']; ?>
            </p>

            <p class="mb-1">
                <strong>Phone:</strong>
				<?php echo $order['phone']; ?>
            </p>

            <p class="mb-0">
                <strong>Address:</strong>
				<?php echo $order['address']; ?>
                
            </p>

        </div>

    </div>


    <!-- Ordered Fruits -->

    <h4 class="mb-3">
        Ordered Items
    </h4>


    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-dark">

                <tr>

                    <th>Image</th>

                    <th>Fruit Name</th>

                    <th>Price</th>

                    <th>Quantity</th>

                    <th>Item Total</th>

                </tr>

            </thead>


            <tbody>

                <?php 
				   $total = 0;
				while($items = $result->fetch_assoc()){ 
				   $item_total = $items['price'] * $items['quantity'];
				   
				   $total = $total + $item_total;
				?>
				<tr>

                    <td>

                        <img src = "fruit_images/<?php echo $items['image']; ?>" style = "height:100px;">

                    </td>

                    <td>
                        <?php echo $items['fruit_name']; ?>
                    </td>

                    <td>
                        ₹<?php echo $items['price']; ?>
                    </td>

                    <td>
                        <?php echo $items['quantity']; ?>
                    </td>

                    <td>
                        ₹<?php echo $item_total; ?>
                    </td>

                </tr>
				<?php } ?>

            </tbody>

        </table>

    </div>


    <!-- Total -->

    <div class="text-end mt-4">

        <h4>
            Total Amount: ₹<?php echo $total; ?>
        </h4>

    </div>


    <!-- Back Button -->

    <div class="mt-3">

        <a href="my_orders.php" class="btn btn-secondary">
            Back to My Orders
        </a>

    </div>


</div>


</body>

</html>