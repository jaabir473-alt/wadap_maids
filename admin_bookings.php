<?php
session_start();
// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_config.php';

// Fetch Totals for the Dashboard Cards
$total_cust = $conn->query("SELECT COUNT(DISTINCT phone) as total FROM customers")->fetch_assoc()['total'];
$total_book = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];

// Main Query with LEFT JOIN
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Wadap Maids</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --wadap-green: #0b3d2c;
            --wadap-gold: #d4af37;
            --bg-light: #f4f7f6;
            --danger: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            display: flex; /* Enables sidebar layout */
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--wadap-green);
            color: white;
            position: fixed;
            padding: 30px 20px;
            box-sizing: border-box;
        }

        .sidebar h2 { color: var(--wadap-gold); text-align: center; margin-bottom: 30px; }
        
        .nav-link { 
            display: block; 
            color: white; 
            text-decoration: none; 
            padding: 12px; 
            margin-bottom: 10px; 
            border-radius: 8px;
            transition: 0.3s;
        }
        
        .nav-link:hover { background: rgba(212, 175, 55, 0.2); }
        .nav-link.active { background: var(--wadap-gold); color: var(--wadap-green); font-weight: bold; }

        /* Main Content Styling */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Stats Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            border-left: 5px solid var(--wadap-gold);
        }

        .stat-card i { font-size: 2rem; color: var(--wadap-green); margin-right: 15px; }
        .stat-info h3 { margin: 0; font-size: 0.8rem; color: #666; text-transform: uppercase; }
        .stat-info p { margin: 5px 0 0 0; font-size: 1.5rem; font-weight: bold; color: var(--wadap-green); }

        /* Table Styling */
        .table-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--wadap-green); color: white; }
        th { padding: 18px; text-align: left; color: var(--wadap-gold); }
        td { padding: 15px 18px; border-bottom: 1px solid #eee; }
        tr:hover { background-color: #f9fbf9; }

        .badge-id { background: #eee; padding: 4px 8px; border-radius: 6px; font-weight: bold; }
        .error-text { color: var(--danger); font-weight: bold; }
        .service-text { font-weight: 600; color: var(--wadap-green); }

        .btn-logout {
            position: absolute;
            bottom: 30px;
            left: 20px;
            right: 20px;
            background: var(--danger);
            color: white;
            padding: 12px;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>WADAP ADMIN</h2>
    <a href="admin_bookings.php" class="nav-link active"><i class="fas fa-calendar-alt"></i> Bookings</a>
    <a href="view_customers.php" class="nav-link"><i class="fas fa-users"></i> Customers</a>
    
    <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <div>
            <h1>Dashboard Overview</h1>
            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        </div>
        <button onclick="location.reload()" style="background: var(--wadap-green); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-user-friends"></i>
            <div class="stat-info">
                <h3>Customers</h3>
                <p><?php echo $total_cust; ?></p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-receipt"></i>
            <div class="stat-info">
                <h3>Total Bookings</h3>
                <p><?php echo $total_book; ?></p>
            </div>
        </div>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Linked ID</th>
                    <th>Service Type</th>
                    <th>Booking Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $displayName = $row['customer_name'] 
                                ? "<strong>" . htmlspecialchars($row['customer_name']) . "</strong>" 
                                : "<span class='error-text'><i class='fas fa-exclamation-triangle'></i> LINK BROKEN</span>";
                        
                        $service_id = $row['service_type'];
                        $service_sentence = "";
                        switch ($service_id) {
                            case "1": $service_sentence = "Basic Cleaning (RM25/hr)"; break;
                            case "2": $service_sentence = "Deep Cleaning (RM50/hr)"; break;
                            case "3": $service_sentence = "Office Pro (RM40/hr)"; break;
                            default: $service_sentence = "Other Service";
                        }

                        echo "<tr>
                                <td><span class='badge-id'>#{$row['booking_id']}</span></td>
                                <td>{$displayName}</td>
                                <td><code>{$row['booking_cust_id']}</code></td>
                                <td class='service-text'>{$service_sentence}</td>
                                <td>" . date('d M Y', strtotime($row['booking_date'])) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; padding: 40px;'>No bookings found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>