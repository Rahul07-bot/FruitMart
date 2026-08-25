<?php

session_start();

require('../config/connection.php');


// Check if user is logged in

if(!isset($_SESSION['user_id'])){

    header("location:../login.php");
    exit();

}


// Customer cannot access admin pages

if($_SESSION['role_id'] == 5){

    header("location:../index.php");
    exit();

}


// Get category ID from URL

$id = $_GET['id'];


// Fetch category details

$sql = "SELECT * FROM categories WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();


// Delete image from folder

unlink("../category_images/" . $row['image']);


// Delete category from database

$sql = "DELETE FROM categories WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();


// Go back to categories page

header("Location: categories.php");
exit();

?>