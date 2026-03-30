<?php
session_start();
// Security: Redirect to login if session is empty
if (!isset($_SESSION['cust_id'])) {
    header("Location: customer_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Maid | Wadap Maids</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --wadap-green: #0b3d2c; --wadap-gold: #d4af37; }
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; }
        .booking-container { max-width: 500px; margin: 80px auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        h2 { color: var(--wadap-green); text-align: center; }
        .user-welcome { background: #e8f5e9; padding: 15px; border-radius: 10px; margin-bottom: 25px; color: #2e7d32; font-weight: bold; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: var(--wadap-green); }
        select, input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 1rem; }
        .btn-submit { width: 100%; background: var(--wadap-green); color: var(--wadap-gold); padding: 16px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1.1rem; transition: 0.3s; }
        .btn-submit:hover { background: #145a43; }
        .logout-link { color: #e74c3c; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="booking-container">
    <h2>Make a Booking</h2>
    
    <div class="user-welcome">
        <i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($_SESSION['cust_name']); ?>!
    </div>

    <form action="submit_booking.php" method="POST">
        <div class="form-group">
            <label>Choose Service</label>
            <select name="service_id" required>
                <option value="">-- Select --</option>
                <option value="1">Basic Cleaning (RM25/hr)</option>
                <option value="2">Deep Cleaning (RM50/hr)</option>
                <option value="3">Office Pro (RM40/hr)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Booking Date</label>
            <input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <button type="submit" name="submit" class="btn-submit">Confirm My Booking</button>
    </form>
    
    <p style="text-align:center; margin-top:20px; font-size:0.9rem;">
        Not you? <a href="logout.php" class="logout-link">Logout</a>
    </p>
</div>

</body>
</html>