<?php
include 'db_config.php';

// 1. Debug: Check if the 'customers' table has data
$check_cust = $conn->query("SELECT COUNT(*) as total FROM customers");
$cust_data = $check_cust->fetch_assoc();

// 2. Debug: Check if the 'bookings' table has data
$check_book = $conn->query("SELECT COUNT(*) as total FROM bookings");
$book_data = $check_book->fetch_assoc();

// 3. The main query with LEFT JOIN (shows records even if the link is broken)
$sql = "SELECT 
            b.booking_id, 
            c.name AS customer_name, 
            b.customer_id AS booking_cust_id,
            b.service_type, 
            b.booking_date
        FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.customer_id
        ORDER BY b.booking_id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Debug | Booking Records</title>
    <style>
        .debug-box { background: #f8d7da; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #0b3d2c; color: white; }
    </style>
</head>
<body>

<div style="padding: 20px;">
    <h2>Database Diagnostic Tool</h2>

    <div class="debug-box">
        <strong>System Status:</strong><br>
        - Total Customers in Database: <?php echo $cust_data['total']; ?><br>
        - Total Bookings in Database: <?php echo $book_data['total']; ?><br>
    </div>

    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Linked Customer Name</th>
                <th>Customer ID in Booking Table</th>
                <th>Service</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $name = $row['customer_name'] ? $row['customer_name'] : "<span style='color:red;'>NULL (Link Broken)</span>";
                    echo "<tr>
                            <td>{$row['booking_id']}</td>
                            <td>{$name}</td>
                            <td>{$row['booking_cust_id']}</td>
                            <td>{$row['service_type']}</td>
                            <td>{$row['booking_date']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found in 'bookings' table.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>