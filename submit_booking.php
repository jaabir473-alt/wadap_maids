<?php
include 'db_config.php';

if (isset($_POST['submit'])) {
    // Collect form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $service = $_POST['service_id'];
    $date = $_POST['booking_date'];

    // STEP 1: Insert into Customers
    $sql1 = "INSERT INTO customers (name, phone, email, address) 
             VALUES ('$name', '$phone', '$email', '$address')";

    if ($conn->query($sql1) === TRUE) {
        // STEP 2: GET THE NEW CUSTOMER ID (CRITICAL!)
        $last_id = $conn->insert_id;

        // STEP 3: Insert into Bookings using that ID
        $sql2 = "INSERT INTO bookings (customer_id, service_type, booking_date) 
                 VALUES ('$last_id', '$service', '$date')";

        if ($conn->query($sql2) === TRUE) {
            echo "<script>alert('Booking successfully saved!'); window.location='admin_bookings.php';</script>";
        } else {
            echo "Error in Booking Table: " . $conn->error;
        }
    } else {
        echo "Error in Customer Table: " . $conn->error;
    }
}
?>