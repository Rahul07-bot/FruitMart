<?php
    require('header.php');
	
	if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){ ?>
		<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Order Successful - FruitMart</title>


    <!-- Bootstrap CDN -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- css link -->
	<link rel = "stylesheet" href = "css/cart.css" type = "text/css">

</head>


<body>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow text-center">

                <div class="card-body p-5">

                    <h1 class="text-success mb-3">
                        Your cart is empty !
                    </h1>

                    

                    <p>
                        Must add items on the cart before you proceed to check out.	
                    </p>


                    <a
                        href="index.php"
                        class="btn btn-primary mt-3"
                    >
                        Continue Shopping
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


</body>

</html>


		<?php 
		require('footer.php');
		exit();
	}
	
	// increase Quantity
	if(isset($_POST['increase'])){
		$index = $_POST['index'];
		
		$_SESSION['cart'][$index]['cart_quantity']++;
		
		header("Location:cart.php");
		exit();
	}
	
	// decrease Quantity
	if(isset($_POST['decrease'])){
		$index = $_POST['index'];
		
		if($_SESSION['cart'][$index]['cart_quantity'] > 1){
			$_SESSION['cart'][$index]['cart_quantity']--;
			
			header("Location:cart.php");
			exit();
		}
	}
	
	// remove items
	if(isset($_POST['remove'])){
		$index = $_POST['index'];
		
		unset($_SESSION['cart'][$index]);
		
		header("Location:cart.php");
		exit();
	}
   
   
   $total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cart - FruitMart</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
	
	<link rel = "stylesheet" href = "css/cart.css" type = "text/css">

</head>


<body>


<div class="container py-5">

    <h2 class="mb-4">
        My Cart
    </h2>

<div class = "cart_table">
    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Image</th>

                <th>Fruit Name</th>

                <th>Price</th>

                <th>Quantity</th>

                <th>Item Total</th>

                <th>Remove</th>

            </tr>

        </thead>


        <tbody>


        

   <?php foreach($_SESSION['cart'] as $index => $fruit){ 
      $item_total = $fruit['price'] * $fruit['cart_quantity'];
	  
	  $total = $total + $item_total;
   ?>
            <tr>


                <!-- Image -->

                <td>

                    <img
                        src="fruit_images/<?php echo $fruit['image']; ?>"
                        width="80"
                        height="80"
                    >

                </td>


                <!-- Fruit Name -->

                <td>

                    <?php echo $fruit['fruit_name']; ?>

                </td>


                <!-- Price -->

                <td>

                    ₹<?php echo $fruit['price']; ?>

                </td>


                <!-- Quantity -->

                <td>

                    <form method="POST" class="d-inline">
                        <input type="hidden" name="index" value="<?php echo $index; ?>"> 
                        <button type="submit" name="decrease" class="btn btn-sm btn-secondary">
						-
                        </button>
                    </form>
					<?php echo $fruit['cart_quantity']; ?>
					<form method="POST" class="d-inline">
                        <input type="hidden" name="index" value="<?php echo $index; ?>"> 
                        <button type="submit" name="increase" class="btn btn-sm btn-secondary">
						+
                        </button>
                    </form>

                </td>


                <!-- Item Total -->

                <td>

                    ₹<?php echo $item_total; ?>/-

                </td>


                <!-- Remove -->

                <td>

                    

                    <form method = "POST">
					   <input type = "hidden" name = "index" value = "<?php echo $index; ?>">
						<button type="submit" name="remove" class="btn btn-danger">
                            Remove
                        </button>
                    </form>

                </td>


            </tr>
   <?php } ?>

        


        </tbody>

    </table>
</div>

    <!-- Cart Total -->

    <h4 class="text-end mt-4">

        Total:
        ₹<?php echo $total; ?>/-

    </h4>
	
	<div class="text-end mt-3">

    <a href="checkout.php" class="btn btn-success">
        Proceed to Checkout
    </a>

</div>


</div>


</body>

</html>


<?php require('footer.php'); ?>