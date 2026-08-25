<?php 
   session_start();
   
   require('../config/connection.php');
   
   
   
   
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
</head>
<body>

<?php include('includes/navbar.php'); ?>


<div class="container-fluid">
    <div class="row">
<?php include('includes/sidebar.php'); ?>
        <div class="col-md-9 col-lg-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Orders</h2>

                
            </div>

            <!-- Fruit table -->
			
			<table class = "display" id = "myTable">
			   <thead>
			      <tr>
				     <th>Order Id</th>
				     <th>Customer</th>
				     <th>Total Amount</th>
				     <th>Phone</th>
				     <th>Payment Method</th>
				     <th>Order Status</th>
				     <th>Order Date</th>
				     <th>Action</th>
				     <th>Update</th>
				  </tr>
			   </thead>
			   
			   <tbody>
			      <?php 
				     $sql = "SELECT orders.*, users. name
					         FROM orders
							 JOIN users
							 ON orders. user_id = users. id
							 ORDER BY orders.id DESC";
					 $result = $conn->query($sql);
					 
					 while($order = $result->fetch_assoc()){
				  ?>
				  <tr>
				     <td><?php echo $order['id']; ?></td>
				     <td><?php echo $order['name']; ?></td>
				     <td><?php echo $order['total_amount']; ?></td>
				     <td><?php echo $order['phone']; ?></td>
				     <td><?php echo $order['payment_method']; ?></td>
				     <td>
					 <span class="badge bg-warning text-dark">
					 <?php echo $order['order_status']; ?>
					 </span>
					 </td>
				     <td><?php echo $order['created_at']; ?></td>
				     <td>
					 <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">
					     View
				     </a>
					 </td>
					 <td>
				     <a href = "update_order.php?id=<?php echo $order['id']; ?>" class = "btn btn-danger btn-sm">Update</a>
				     </td>
				  </tr>
				  
					 <?php } ?>
			   </tbody>
			</table>
			<script>
			   $(document).ready(function(){
				   $("#myTable").DataTable();
			   });
			</script>
			

        </div>

    </div>
</div>

</body>
</html>