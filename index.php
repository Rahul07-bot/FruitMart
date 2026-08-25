<?php 
   require('header.php');
   require('config/connection.php');
   
   
   
?>
<html>
   <head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
      <!-- css link -->
	  <link rel = "stylesheet" href = "css/index.css" type = "text/css">
	  
	  <!-- Bootstrap link -->
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
		
	  
   </head>
   
   <body>
      <div class = "main_index">
	     <div class = "index_content">
		    <ul>
			   <li>Fresh Fruits</li>
			   <li>Straight From Nature</li>
			   <li>Handpicked, hygienically packed, and delivered fresh to your doorstep.</li>
			   <li><a href = "fruits.php"><button>Shop Now</button></a></li>
			   <li><i class="fa fa-check-circle" style="color:#4DBD18"></i>&nbsp;100% Fresh&nbsp;&nbsp;
			       <i class="fa fa-check-circle" style="color:#4DBD18"></i>&nbsp;No Pesticides&nbsp;&nbsp;
				   <i class="fa fa-check-circle" style="color:#4DBD18"></i>&nbsp;100% Natural</li>
			</ul>
		 </div>
		 <div class = "index_content">
		    <img src = "images/index_logo.png">
		 </div>
		 

	  </div>
	  
	  	 <div class = "container index_fruit">
		    <span class = "index_fruit_category">Shop by Category<span>
		 </div>
		 
		<div class="container index_category">

    <?php
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);

        while ($category = $result->fetch_assoc()) {
    ?>

        <div class="index_category_box">
		  <a href = "fruits.php?id=<?php echo $category['id']; ?>">
            <img src="category_images/<?php echo $category['image']; ?>" class="index_category_image">
			<p class = "index_category_name">
		       <?php echo $category['category_name']; ?>
		    </p>
		  </a>
        </div>
		

    <?php } ?>

         </div>
		 
		 <div class = "container index_banner2">
		    <div class = "index_banner_div">
			   <ul>
			      <li>Fresh Fruits</li>
			      <li>Straight From Nature</li>
			      <li>Handpicked, hygienically packed, and delivered fresh to you doorstep.</li>
			      <li><a href = "fruits.php"><button type = "submit">Shop Now</button></a></li>
			   </ul>
			</div>
			
			<div class = "index_banner_div">
			   <img src = "images/index_logo.png" class = "index_banner_div_image">
			</div>
		 </div>
   </body>
</html>



<?php require('footer.php'); ?>