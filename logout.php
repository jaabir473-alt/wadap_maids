<?php
session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session itself
header("Location: customer_login.php"); // Send back to login
exit();
?>