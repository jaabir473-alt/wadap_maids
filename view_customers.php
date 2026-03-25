<?php
include 'db_config.php';

// Fetch all customers from the database
$sql = "SELECT customer_id, name, phone, email, address, city, created_at FROM customers ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Database | Wadap Maids</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container { padding: 40px; max-width: 1100px; margin: auto; }
        .table-wrapper { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #0b3d2c; color: #d4af37; padding: 15px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 0.95rem; }
        tr:hover { background-color: #f9f9f9; }
        .btn-action { padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 0.8rem; }
        .edit-btn { background: #d4af37; color: #0b3d2c; }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="table-header">
        <h2>Customer Records</h2>
        <p>Manage all registered clients in Penang and Kedah.</p>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>#{$row['customer_id']}</td>
                                <td><strong>{$row['name']}</strong></td>
                                <td>{$row['phone']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['city']}</td>
                                <td>" . date('d M Y', strtotime($row['created_at'])) . "</td>
                                <td>
                                    <a href='edit_customer.php?id={$row['customer_id']}' class='btn-action edit-btn'>Edit</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center;'>No customers found in database.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>