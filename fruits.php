<?php 
   
   
   require('header.php');
   
   
   
   require('config/connection.php');
   
   
   
   if(isset($_GET['id'])){
	   $category_id = $_GET['id'];
	   
	   $sql = "SELECT * FROM fruits WHERE category_id = ?";
	   $stmt = $conn->prepare($sql);
	   $stmt->bind_param("i", $category_id);
	   $stmt->execute();
	   $result = $stmt->get_result();
   }
	
   
   else{
   $sql = "SELECT * FROM fruits WHERE status = 'Available'";
   
   $result = $conn->query($sql);
   }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fruits - FruitMart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<link rel = "stylesheet" href = "css/fruits.css" type = "text/css">

</head>

<body>

<div class="container py-5">

    <h2 class="mb-4">
	Fresh Fruits
	
	</h2>

    <div class="row">

        <?php while($row = $result->fetch_assoc()){ ?>

            <div class="col-md-4 mb-4">

                <div class="card">

                    <img src="fruit_images/<?php echo $row['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">

                    <div class="card-body">

                        <h5 class="card-title">
                            <?php echo $row['fruit_name']; ?>
                        </h5>

                        <p class="card-text">
                            ₹<?php echo $row['price']; ?>
                        </p>

                        <a href="fruit_details.php?id=<?php echo $row['id']; ?>" class="btn  fruit_button">
                            View Details
                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

</body>

</html>


<?php require('footer.php'); ?>