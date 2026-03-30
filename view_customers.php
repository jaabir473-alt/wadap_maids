<?php
include 'db_config.php';

// Fetch all customers, ensuring 'city' is pulled from the database
// This will group duplicates together so you only see 1 Jaabir and 1 Kevin
// Only fetch customers who have a password (valid registered accounts)
$sql = "SELECT * FROM customers WHERE password IS NOT NULL ORDER BY customer_id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Database | Wadap Maids</title>
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --wadap-green: #0b3d2c;
            --wadap-gold: #d4af37;
        }
        .admin-container { padding: 40px; max-width: 1200px; margin: auto; }
        .table-wrapper { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: var(--wadap-green); color: var(--wadap-gold); padding: 15px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 0.95rem; }
        tr:hover { background-color: #f9fbf9; }
        
        /* Action Buttons */
        .btn-action { padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 0.8rem; font-weight: bold; display: inline-block; }
        .edit-btn { background: var(--wadap-gold); color: var(--wadap-green); border: 1px solid var(--wadap-green); transition: 0.3s; }
        .edit-btn:hover { background: var(--wadap-green); color: white; }

        /* City Badge - Professional Look */
        .city-badge { 
            background: #e1f5fe; 
            color: #01579b; 
            padding: 4px 10px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
            font-weight: bold;
            text-transform: uppercase;
        }
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
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Display the city directly from the database
                        // If the database has "Penang", it will show "Penang"
                        $city = !empty($row['city']) ? htmlspecialchars($row['city']) : "N/A";
                        
                        echo "<tr>
                                <td>#{$row['customer_id']}</td>
                                <td><strong>" . htmlspecialchars($row['name']) . "</strong></td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['address']) . "</td>
                                <td><span class='city-badge'>{$city}</span></td>
                                <td>" . date('d M Y', strtotime($row['created_at'])) . "</td>
                                <td>
                                    <a href='edit_customer.php?id={$row['customer_id']}' class='btn-action edit-btn'>Edit Details</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center; padding: 40px; color: #777;'>No customers found. Try submitting a new booking!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>