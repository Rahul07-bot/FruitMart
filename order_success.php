<?php 
   require('header.php');
?>

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

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow text-center">

                <div class="card-body p-5">

                    <h1 class="text-success mb-3">
                        Order Placed Successfully!
                    </h1>

                    <p class="lead">
                        Thank you for shopping with FruitMart.
                    </p>

                    <p>
                        Your order has been received successfully.
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


<?php require('footer.php') ?>