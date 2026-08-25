<?php 
   session_start();
   
   require('../config/connection.php');
   
   $order_id = $_GET['id'];
   
   
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
	
	<style>
	   .order_details{
		   position:absolute;
		   width:80%;
		   left:40vh;
	   }
	</style>
</head>
<body>

<?php include('includes/navbar.php'); ?>


<div class="container-fluid">
    <div class="row">
<?php include('includes/sidebar.php'); ?>
        <!-- Main Content -->

<div class="main-content order_details">

    <div class="container-fluid py-4">


        <!-- Page Heading -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Order Details
            </h2>

            <a href="orders.php" class="btn btn-secondary">
                Back to Orders
            </a>

        </div>


        <!-- Ordered Items -->

        <div class="card shadow">

            <div class="card-header">

                <h5 class="mb-0">
                    Ordered Items
                </h5>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

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


                            <!-- Temporary item -->

                            <tr>
							<?php
                               $sql = "SELECT order_items.*, fruits.fruit_name, fruits. image
							          FROM order_items
									  JOIN fruits
									  ON order_items.fruit_id = fruits. id
									  WHERE order_items. order_id = ?";
							   $stmt = $conn->prepare($sql);
							   $stmt->bind_param("i", $order_id);
							   $stmt->execute();
							   $result = $stmt->get_result();
							   $total = 0;
							   while($item = $result->fetch_assoc()){
								   $item_total = $item['price'] * $item['quantity'];
								   $total = $total + $item_total;
							?>

                                <td>

                                    <img src = "../fruit_images/<?php echo $item['image']; ?>" 
									style = "height:100px;width:40%;border-radius:8px;">

                                </td>


                                <td>
                                    <?php echo $item['fruit_name']; ?>
                                </td>


                                <td>
                                    ₹<?php echo $item['price']; ?>
                                </td>


                                <td>
                                    <?php echo $item['quantity']; ?>
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

                <div class="text-end mt-3">

                    <h4>
                        Total Amount: ₹<?php echo $total; ?>
                    </h4>

                </div>

            </div>

        </div>


    </div>

</div>

    </div>
</div>

</body>
</html>