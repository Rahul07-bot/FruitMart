<?php
   session_start();

   require('../config/connection.php');

   $order_id = $_GET['id'];

   // fetch order details
   $sql = "SELECT orders.*, users. name
           FROM orders
		   JOIN users
		   ON orders. user_id = users. id
		   WHERE orders. id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("i", $order_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $order = $result->fetch_assoc();
   
   // update 
   if(isset($_POST['update_order'])){
	   $order_status = $_POST['order_status'];
	   
	   $sql = "UPDATE orders 
	           SET order_status = ?
			   WHERE id = ?";
	   $stmt = $conn->prepare($sql);
	   $stmt->bind_param("si", $order_status, $order_id);
	   $stmt->execute();
	   header("Location:orders.php");
	   exit();
   }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Update Order</title>

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

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>Update Order</h2>

                <a href="orders.php" class="btn btn-secondary">
                    Back to Orders
                </a>

            </div>


            <div class="card shadow">

                <div class="card-body">

                    <form method="POST">


                        <!-- Order ID -->

                        <div class="mb-3">

                            <label class="form-label">
                                Order ID
                            </label>

                            <input type="text" class="form-control" value="<?php echo $order['id']; ?>" readonly>

                        </div>


                        <!-- Customer -->

                        <div class="mb-3">

                            <label class="form-label">
                                Customer
                            </label>

                            <input type="text" class="form-control" value="<?php echo $order['name']; ?>" readonly>

                        </div>


                        <!-- Order Status -->

                        <div class="mb-3">

                            <label class="form-label">
                                Order Status
                            </label>

                            <select name="order_status" class="form-select">

                                <option value="Pending" <?php if($order['order_status'] == 'Pending') echo 'Selected';?>>
                                    Pending
                                </option>

                                <option value="Processing"<?php if($order['order_status'] == 'Processing') echo 'Selected' ?>>
                                    Processing
                                </option>

                                <option value="Delivered"<?php if($order['order_status'] == 'Delivered') echo 'Selected' ?>>
                                    Delivered
                                </option>

                                <option value="Cancelled"<?php if($order['order_status'] == 'Cancelled') echo 'Selected' ?>>
                                    Cancelled
                                </option>

                            </select>

                        </div>


                        <!-- Update Button -->

                        <button type="submit" name="update_order" class="btn btn-success">
                            Update Order
                        </button>


                        <a href="orders.php" class="btn btn-secondary">
                            Cancel
                        </a>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>