<?php

session_start();

unset($_SESSION['user_id']);
unset($_SESSION['role_id']);
unset($_SESSION['name']);
unset($_SESSION['email']);

header("Location:login.php");
exit();

?>