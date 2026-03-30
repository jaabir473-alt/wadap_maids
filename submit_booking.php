<?php
session_start();
include 'db_config.php';

// Check if customer is actually logged in
if (!isset($_SESSION['cust_id'])) {
    // If not logged in, they MUST go to login. This prevents "Ghost" rows.
    header("Location: customer_login.php");
    exit();
}

if (isset($_POST['submit'])) {
    // 1. Get ONLY the Customer ID from the SESSION
    // This is the "Key" that links back to the existing user row.
    $customer_id = $_SESSION['cust_id'];

    // 2. Collect Booking Details from the form
    $service = mysqli_real_escape_string($conn, $_POST['service_id']);
    $date = mysqli_real_escape_string($conn, $_POST['booking_date']);

    // 3. INSERT INTO BOOKINGS TABLE ONLY
    // We never "INSERT INTO customers" here.
    $sql = "INSERT INTO bookings (customer_id, service_type, booking_date) 
            VALUES ('$customer_id', '$service', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Success! Your booking for " . date('d M Y', strtotime($date)) . " has been recorded.');
                window.location.href='booking.php'; 
              </script>";
        exit();
    } else {
        echo "Database Error: " . $conn->error;
    }
}
?>