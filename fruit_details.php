<?php 
   require('header.php');
   
   include('config/connection.php');
   
   $id = $_GET['id'];
   
   // fetch fruit Details
   $sql = "SELECT * FROM fruits WHERE id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("i", $id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   
   // crate cart if it doesn't exist
   if(!isset($_SESSION['cart'])){
	   $_SESSION['cart'] = [];
   }
   
   // add fruits in the cart
   if(isset($_POST['add_to_cart'])){
	   $id = $_POST['id'];
	   
	   // fetch fruits
	   $sql = "SELECT * FROM fruits WHERE id = ?";
	   $stmt = $conn->prepare($sql);
	   $stmt->bind_param("i", $id);
	   $stmt->execute();
	   $result = $stmt->get_result();
	   $fruit = $result->fetch_assoc();
	   $fruit['cart_quantity'] = 1;
	   
	   // if fruit is already in the cart 
	   foreach($_SESSION['cart'] as $index => $item){
		   if($item['id'] == $fruit['id']){
			   $_SESSION['cart'][$index]['cart_quantity']++;
			   $fond = true;
			   break;
		   }
	   }
	   
	   // if fruit is not in the cart
	   if(!isset($fond)){
		   $_SESSION['cart'][] = $fruit;
	   }
	   
	   header("Location:cart.php");
	   exit();
   }
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $row['fruit_name']; ?> - FruitMart</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container py-5">

    <div class="row">

        <!-- Image -->

        <div class="col-md-6">

            <img src="fruit_images/<?php echo $row['image']; ?>" class="img-fluid rounded">

        </div>


        <!-- Details -->

        <div class="col-md-6">
<!-- fruit name -->
            <h2>
                <?php echo $row['fruit_name']; ?>
            </h2>
<!--price -->
            <h4>
                ₹<?php echo $row['price']; ?>
            </h4>
<!-- description -->
            <p>
                <?php echo $row['description'] ?>
            </p>

            <p>
                Available Quantity:<?php echo $row['quantity']; ?>
                
            </p>

            <form method = "POST">
			<input type = "hidden" name = "id" value = "<?php echo $row['id']; ?>">
			<button type = "submit" name = "add_to_cart" class="btn btn-primary">
                Add to Cart
            </button>
			</form>
			

        </div>

    </div>

</div>

</body>

</html>