<?php
session_start();
// Check if admin is logged in [cite: 54]
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_config.php';

// --- STATUS UPDATE HANDLER --- [cite: 54]
if (isset($_POST['update_status'])) {
    $b_id = $_POST['booking_id'];
    $new_status = $_POST['status'];
    $update_sql = "UPDATE bookings SET status = '$new_status' WHERE booking_id = '$b_id'";
    $conn->query($update_sql);
    // Refresh to show changes with the current month filter
    header("Location: admin_bookings.php?month=" . $_GET['month']);
    exit();
}

// --- MONTHLY FILTER LOGIC --- [cite: 43]
$filter_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// Fetch Totals for Dashboard Cards [cite: 43, 46]
$total_cust = $conn->query("SELECT COUNT(*) as total FROM customers WHERE password IS NOT NULL")->fetch_assoc()['total'];
$total_book = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];

// Main Query with JOIN, Status, and Month Filter [cite: 45, 135]
$sql = "SELECT b.booking_id, c.name AS customer_name, b.customer_id AS booking_cust_id,
               b.service_type, b.booking_date, b.status
        FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.customer_id
        WHERE b.booking_date LIKE '$filter_month%'
        ORDER BY b.booking_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wadap Admin | Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }

        /* PRINT STYLING - High quality for physical reports [cite: 43] */
        @media print {
            aside, header, .no-print, select { display: none !important; }
            main { margin-left: 0 !important; padding: 0 !important; }
            .bg-white { box-shadow: none !important; border: 1px solid #eee !important; }
            body::before {
                content: "WADAP MAIDS - Operational Booking Report (<?php echo date('F Y', strtotime($filter_month)); ?>)";
                display: block;
                text-align: center;
                font-size: 20pt;
                font-weight: bold;
                margin-bottom: 30px;
                color: #0b3d2c;
            }
            .status-text { display: block !important; } 
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <aside class="fixed inset-y-0 left-0 w-64 bg-[#0b3d2c] text-white hidden md:flex flex-col shadow-2xl no-print">
        <div class="p-8 text-center">
            <h2 class="text-2xl font-black tracking-tighter text-[#d4af37]">WADAP<span class="text-white">MAIDS</span></h2>
        </div>
        
        <nav class="flex-1 px-4 space-y-2">
            <a href="admin_bookings.php" class="flex items-center space-x-3 px-4 py-3 bg-[#d4af37] text-[#0b3d2c] rounded-xl font-bold transition-all shadow-lg">
                <i class="fas fa-calendar-check w-5 text-center"></i>
                <span>Bookings</span>
            </a>

            <a href="view_customers.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-[#145a43] text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Customers</span>
            </a>

            <a href="view_staff.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-[#145a43] text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-id-badge w-5 text-center"></i>
                <span>Staff Management</span>
            </a>
        </nav>

        <div class="p-4 border-t border-[#145a43]">
            <a href="logout.php" class="flex items-center space-x-3 px-4 py-3 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all font-medium">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Logout Admin</span>
            </a>
        </div>
    </aside>

    <main class="md:ml-64 min-h-screen">
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-200 px-8 py-6 flex flex-wrap justify-between items-center gap-4 no-print">
            <div>
                <h1 class="text-2xl font-extrabold text-[#0b3d2c]">Booking Management</h1>
                <p class="text-slate-500 text-sm italic">Reviewing <span class="font-bold text-emerald-700"><?php echo date('F Y', strtotime($filter_month)); ?></span></p>
            </div>
            
            <div class="flex items-center space-x-3">
                <form method="GET" class="flex items-center space-x-2">
                    <input type="month" name="month" value="<?php echo $filter_month; ?>" onchange="this.form.submit()" 
                           class="bg-slate-100 border-none rounded-xl text-sm font-semibold px-4 py-2 focus:ring-2 focus:ring-[#d4af37] outline-none">
                </form>

                <button onclick="window.print()" class="bg-[#0b3d2c] text-[#d4af37] font-bold px-6 py-2.5 rounded-xl shadow-md hover:bg-[#145a43] transition-all flex items-center space-x-2">
                    <i class="fas fa-print"></i>
                    <span>Print</span>
                </button>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 no-print">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-5">
                    <div class="bg-emerald-50 text-[#0b3d2c] p-4 rounded-2xl">
                        <i class="fas fa-user-friends text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Active Clients</h3>
                        <p class="text-3xl font-black text-[#0b3d2c]"><?php echo $total_cust; ?></p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-5">
                    <div class="bg-yellow-50 text-[#d4af37] p-4 rounded-2xl">
                        <i class="fas fa-receipt text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Monthly Bookings</h3>
                        <p class="text-3xl font-black text-[#0b3d2c]"><?php echo $result->num_rows; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="p-5 text-slate-400 font-bold text-xs uppercase tracking-wider">ID</th>
                                <th class="p-5 text-slate-400 font-bold text-xs uppercase tracking-wider">Customer</th>
                                <th class="p-5 text-slate-400 font-bold text-xs uppercase tracking-wider">Service</th>
                                <th class="p-5 text-slate-400 font-bold text-xs uppercase tracking-wider">Date</th>
                                <th class="p-5 text-slate-400 font-bold text-xs uppercase tracking-wider text-center">Status Control</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $status = $row['status'] ?? 'Pending';
                                    
                                    // Status Colors for UI
                                    $status_bg = "bg-slate-100 text-slate-600";
                                    if($status == 'Confirmed') $status_bg = "bg-blue-100 text-blue-700";
                                    if($status == 'Completed') $status_bg = "bg-emerald-100 text-emerald-700";
                                    if($status == 'Cancelled') $status_bg = "bg-red-100 text-red-700";

                                    echo "<tr class='hover:bg-slate-50 transition-colors'>
                                    
                                            <td class='p-5 font-mono text-slate-400 italic'>#{$row['booking_id']}</td>
                                            <td class='p-5 font-bold text-slate-700'>" . htmlspecialchars($row['customer_name'] ?? 'Unknown') . "</td>
                                            <td class='p-5'>
                                                <span class='text-[11px] font-bold uppercase tracking-tighter px-2 py-1 bg-slate-100 rounded text-slate-500'>Type {$row['service_type']}</span>
                                            </td>
                                            <td class='p-5 font-medium text-slate-500'>" . date('d M Y', strtotime($row['booking_date'])) . "</td>
                                            <td class='p-5 text-center'>
                                                <form method='POST' class='no-print inline-block'>
                                                    <input type='hidden' name='booking_id' value='{$row['booking_id']}'>
                                                    <select name='status' onchange='this.form.submit()' 
                                                            class='text-[11px] font-black py-1.5 px-3 rounded-lg border-none focus:ring-2 focus:ring-[#d4af37] {$status_bg} cursor-pointer transition-all uppercase tracking-widest shadow-sm'>
                                                        <option value='Pending' " . ($status == 'Pending' ? 'selected' : '') . ">Pending</option>
                                                        <option value='Confirmed' " . ($status == 'Confirmed' ? 'selected' : '') . ">Confirmed</option>
                                                        <option value='Completed' " . ($status == 'Completed' ? 'selected' : '') . ">Completed</option>
                                                        <option value='Cancelled' " . ($status == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                                                    </select>
                                                    <input type='hidden' name='update_status' value='1'>
                                                </form>
                                                <span class='hidden status-text font-black uppercase text-[10px] tracking-widest'>{$status}</span>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='p-20 text-center text-slate-400 italic font-medium'>No bookings found for this month.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>