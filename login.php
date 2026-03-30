<?php
session_start(); // Start the session to remember the admin
include 'db_config.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 1. Find the admin in the database
    $sql = "SELECT * FROM admins WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // 2. Verify the hashed password
        if (password_verify($pass, $row['password'])) {
            // SUCCESS: Store admin info in session
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['username'] = $row['username'];
            
            header("Location: admin_bookings.php"); // Send to dashboard
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Wadap Maids</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-box { max-width: 350px; margin: 120px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-top: 5px solid #0b3d2c; }
        .login-box h2 { color: #0b3d2c; text-align: center; margin-bottom: 25px; }
        .error-msg { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem; text-align: center; }
        .field { margin-bottom: 20px; }
        .field label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
        .field input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn-login { width: 100%; background: #0b3d2c; color: #d4af37; padding: 14px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 1rem; transition: 0.3s; }
        .btn-login:hover { background: #145a43; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Wadap Admin Login</h2>
    
    <?php if(isset($error)) { echo "<div class='error-msg'>$error</div>"; } ?>

    <form action="login.php" method="POST">
        <div class="field">
            <label>Username</label>
            <input type="text" name="username" required placeholder="Enter your username">
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Enter your password">
        </div>
        <button type="submit" name="login" class="btn-login">Sign In</button>
    </form>
    
    <p style="text-align:center; margin-top:20px; font-size:0.9rem;">
        New Admin? <a href="signup.php" style="color:#0b3d2c; text-decoration:none; font-weight:bold;">Register Here</a>
    </p>
</div>

</body>
</html>