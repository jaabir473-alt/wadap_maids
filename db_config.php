<?php
// 1. Enable error reporting to stop the blank page
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "wadap_db";

// 2. Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// 3. Check if form submitted (Matches name="submit" in your HTML)
if (isset($_POST['submit'])) {

    // Ambil data dari form (Matches your HTML 'name' attributes)
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // 4. Corrected SQL: Matches 'customers' table and its column names
    $sql = "INSERT INTO customers (name, phone, email, address)
            VALUES ('$name', '$phone', '$email', '$address')";

    if ($conn->query($sql) === TRUE) {
        // Success message and redirect back to booking page
        echo "<script>
                alert('Customer data inserted successfully!');
                window.location.href='booking.html';
              </script>";
    } else {
        // Displays exact error if the insertion fails
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>