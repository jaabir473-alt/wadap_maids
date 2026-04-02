<?php
session_start();
include 'db_config.php';

// 1. Check Login
if (!isset($_SESSION['cust_id'])) {
    header("Location: customer_login.php");
    exit();
}

if (isset($_POST['submit'])) {
    // 2. Get the logged-in ID
    $customer_id = $_SESSION['cust_id'];

    // 3. Get booking data
    $service = mysqli_real_escape_string($conn, $_POST['service_id']);
    $date = mysqli_real_escape_string($conn, $_POST['booking_date']);

    // 4. THE ONLY SQL ALLOWED: Insert into bookings ONLY
    // If you see any code below this line mentioning 'INSERT INTO customers', delete it!
    $sql = "INSERT INTO bookings (customer_id, service_type, booking_date) 
            VALUES ('$customer_id', '$service', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Success! Booking saved for Customer ID: $customer_id');
                window.location.href='my_bookings.php'; 
              </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>