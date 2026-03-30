<?php
session_start();
include 'db_config.php';

if (isset($_POST['login'])) {
    $phone = $_POST['phone'];
    $pass = $_POST['password'];

    $result = $conn->query("SELECT * FROM customers WHERE phone = '$phone'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['cust_id'] = $row['customer_id'];
            $_SESSION['cust_name'] = $row['name'];
            header("Location: booking.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Phone number not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Login | Wadap Maids</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background:#f4f7f6; display:flex; justify-content:center; align-items:center; height:100vh;">

<div style="background:white; padding:40px; border-radius:15px; width:350px; box-shadow:0 10px 25px rgba(0,0,0,0.1); border-top:8px solid #d4af37;">
    <h2 style="color:#0b3d2c; text-align:center;">Customer Login</h2>
    <?php if(isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="phone" placeholder="Phone Number" required style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px;">
        <input type="password" name="password" placeholder="Password" required style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px;">
        <button type="submit" name="login" style="width:100%; background:#0b3d2c; color:#d4af37; padding:15px; border:none; border-radius:5px; cursor:pointer; font-weight:bold;">Sign In</button>
    </form>
    <p style="text-align:center; margin-top:15px;">New here? <a href="customer_signup.php" style="color:#0b3d2c; font-weight:bold;">Sign up now</a></p>
</div>

</body>
</html>