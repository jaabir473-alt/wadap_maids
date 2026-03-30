<?php
include 'db_config.php';

if (isset($_POST['signup'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Securely hash the password before saving
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Insert into the new admins table
    $sql = "INSERT INTO admins (username, password) VALUES ('$user', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Admin Account Created Successfully!');
                window.location.href='login.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Signup | Wadap Maids</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container { max-width: 400px; margin: 100px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 5px solid #0b3d2c; }
        .auth-container h2 { color: #0b3d2c; text-align: center; margin-bottom: 20px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .input-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-signup { width: 100%; background: #0b3d2c; color: #d4af37; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1rem; }
    </style>
</head>
<body>

<div class="auth-container">
    <h2>Admin Registration</h2>
    <form action="signup.php" method="POST">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required placeholder="Choose a username">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Create a strong password">
        </div>
        <button type="submit" name="signup" class="btn-signup">Register Admin Account</button>
    </form>
    <p style="text-align:center; margin-top:15px; font-size:0.9rem;">
        Already have an account? <a href="login.php" style="color:#0b3d2c;">Login here</a>
    </p>
</div>

</body>
</html>