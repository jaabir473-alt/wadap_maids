<?php
include 'db_config.php';

if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // --- STEP 1: CHECK IF PHONE ALREADY EXISTS ---
    // This prevents the customer count from incrementing for the same person
    $check = $conn->query("SELECT * FROM customers WHERE phone = '$phone'");
    
    if ($check->num_rows > 0) {
        // Person is already in the system!
        echo "<script>
                alert('This phone number is already registered! Please Login instead.');
                window.location.href='customer_login.php';
              </script>";
        exit(); // Stop the script here
    } else {
        // --- STEP 2: INSERT NEW CUSTOMER ---
        $sql = "INSERT INTO customers (name, phone, email, password, address, city) 
                VALUES ('$name', '$phone', '$email', '$pass', '$address', '$city')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Account Created Successfully! Welcome to Wadap Maids.');
                    window.location.href='customer_login.php';
                  </script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Signup | Wadap Maids</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background:#f4f7f6; display:flex; justify-content:center; align-items:center; min-height:100vh; font-family: 'Segoe UI', sans-serif;">

<div style="background:white; padding:40px; border-radius:15px; width:450px; box-shadow:0 10px 25px rgba(0,0,0,0.1); border-top:8px solid #0b3d2c;">
    <div style="text-align:center; margin-bottom:20px;">
        <h2 style="color:#0b3d2c; margin-bottom:5px;">Join Wadap Maids</h2>
        <p style="color:#666; font-size:0.9rem;">Create an account for faster bookings</p>
    </div>

    <form method="POST">
        <label style="font-size:0.85rem; font-weight:bold; color:#444;">Full Name</label>
        <input type="text" name="name" placeholder="Enter your full name" required style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px; box-sizing:border-box;">
        
        <label style="font-size:0.85rem; font-weight:bold; color:#444;">Phone Number</label>
        <input type="text" name="phone" placeholder="01X-XXXXXXX" required style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px; box-sizing:border-box;">
        
        <label style="font-size:0.85rem; font-weight:bold; color:#444;">Email Address</label>
        <input type="email" name="email" placeholder="email@example.com" required style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px; box-sizing:border-box;">
        
        <label style="font-size:0.85rem; font-weight:bold; color:#444;">Create Password</label>
        <input type="password" name="password" placeholder="Min. 6 characters" required style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px; box-sizing:border-box;">
        
        <label style="font-size:0.85rem; font-weight:bold; color:#444;">City</label>
        <select name="city" required style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px; box-sizing:border-box;">
            <option value="">-- Select City --</option>
            <option value="Penang">Penang</option>
            <option value="Kedah">Kedah</option>
        </select>
        
        <label style="font-size:0.85rem; font-weight:bold; color:#444;">Full Address</label>
        <textarea name="address" placeholder="House No, Street Name, Postcode" required style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px; box-sizing:border-box; height:80px;"></textarea>
        
        <button type="submit" name="signup" style="width:100%; background:#0b3d2c; color:#d4af37; padding:15px; border:none; border-radius:5px; cursor:pointer; font-weight:bold; font-size:1rem; transition:0.3s;">Create Account</button>
    </form>
    
    <p style="text-align:center; margin-top:20px; font-size:0.9rem;">
        Already have an account? <a href="customer_login.php" style="color:#0b3d2c; font-weight:bold; text-decoration:none;">Login here</a>
    </p>
</div>

</body>
</html>