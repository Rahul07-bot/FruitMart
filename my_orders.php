<?php 
   require('header.php');
   
   require('config/connection.php');
   
   // check if user log in
   if(!isset($_SESSION['user_id'])){
	   header("Location:login.php");
	   exit();
   }
   
   $user_id = $_SESSION['user_id'];
   
   // fetch the user's order
   $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC";
   
   $stmt = $conn->prepare($sql);
   
   $stmt->bind_param("i", $user_id);
   
   $stmt->execute();
   
   $result = $stmt->get_result();
   
   
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- datatable link -->
	<link rel="stylesheet" href="https://cdn.datatables.net/3.0.1/css/dataTables.dataTables.css" />
	<script src="https://code.jquery.com/jquery-4.0.0.min.js"></script>
	<script src="https://cdn.datatables.net/3.0.1/js/dataTables.js"></script>

    <title>My Orders - FruitMart</title>
	
	

</head>
<body>
<div class="container py-5">

    <h2 class="mb-4">
        My Orders
    </h2>

    <div class="table-responsive">

        <table class="table table-bordered table-striped align-middle">

            <thead class="table-dark">

                <tr>

                    <th>Order ID</th>

                    <th>Total Amount</th>

                    <th>Payment Method</th>

                    <th>Phone</th>

                    <th>Address</th>

                    <th>Order Date</th>

                    <th>Action</th>
					
					<th>Status</th>

                </tr>

            </thead>

            <tbody>

            <?php while($order = $result->fetch_assoc()){ ?>

                <tr>

                    <td>
                        <?php echo $order['id']; ?>
                    </td>

                    <td>
                        ₹<?php echo $order['total_amount']; ?>
                    </td>

                    <td>
                        <?php echo $order['payment_method']; ?>
                    </td>

                    <td>
                        <?php echo $order['phone']; ?>
                    </td>

                    <td>
                        <?php echo $order['address']; ?>
                    </td>

                    <td>
                        <?php echo $order['created_at']; ?>
                    </td>

                    <td>

                        <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">
                            View Details
                        </a>

                    </td>
					
					<td>
					   <button type = "button" class = "btn btn-danger"><?php echo $order['order_status']; ?></button>
					</td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>
</body>
</html>


<?php require('footer.php'); ?>