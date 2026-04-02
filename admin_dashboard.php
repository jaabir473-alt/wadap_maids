<?php
session_start();
// Security: Redirect to login if not authenticated as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include 'db_config.php';

// --- DATA FETCHING ---
// Fetch counts for dashboard metrics
$total_bookings = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$active_cleaners = $conn->query("SELECT COUNT(*) as total FROM staff WHERE staff_status = 'Active'")->fetch_assoc()['total'];
$total_customers = $conn->query("SELECT COUNT(*) as total FROM customers WHERE password IS NOT NULL")->fetch_assoc()['total'];

// Recent Bookings (Limit 5 for the dashboard view)
$recent_bookings = $conn->query("SELECT b.booking_id, c.name, b.service_type, b.booking_date, b.status 
                                FROM bookings b 
                                LEFT JOIN customers c ON b.customer_id = c.customer_id 
                                ORDER BY b.booking_id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wadap Admin | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #04241a; }
        .sidebar-item:hover { background-color: rgba(255,255,255,0.1); }
        .card-glass { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="text-white flex min-h-screen">

    <aside class="w-64 bg-[#0b3d2c] flex flex-col p-6 border-r border-white/10 sticky top-0 h-screen">
        <div class="mb-10 px-2 text-center md:text-left">
            <h2 class="text-2xl font-black text-[#d4af37] tracking-tighter uppercase">WADAP MAIDS</h2>
            <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest mt-1">We Clean • We Care • We Excel</p>
        </div>
        
        <nav class="flex-1 space-y-1">
            <a href="admin_dashboard.php" class="flex items-center space-x-3 p-3 bg-white/10 rounded-xl text-white font-bold">
                <i class="fas fa-th-large w-5"></i> <span>Dashboard</span>
            </a>
            <a href="admin_bookings.php" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:text-white transition">
                <i class="fas fa-calendar-alt w-5"></i> <span>Bookings</span>
            </a>
            <a href="view_customers.php" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:text-white transition">
                <i class="fas fa-users w-5"></i> <span>Customers</span>
            </a>
            <a href="view_staff.php" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:text-white transition">
                <i class="fas fa-id-badge w-5"></i> <span>Cleaners</span>
            </a>
            <a href="services.php" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:text-white transition">
                <i class="fas fa-concierge-bell w-5"></i> <span>Services</span>
            </a>
        </nav>

        <a href="logout.php" class="mt-auto flex items-center space-x-3 p-3 text-red-400 font-bold hover:bg-red-500/10 rounded-xl transition">
            <i class="fas fa-sign-out-alt w-5"></i> <span>Logout Admin</span>
        </a>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold italic uppercase tracking-tight text-[#d4af37]">Welcome Back, Admin</h1>
            <div class="flex items-center space-x-6">
                <div class="relative cursor-pointer">
                    <i class="fas fa-bell text-xl text-slate-400"></i>
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </div>
                <div class="flex items-center space-x-3 bg-white/5 p-2 pr-4 rounded-full border border-white/10">
                    <div class="w-10 h-10 bg-[#d4af37] rounded-full flex items-center justify-center font-bold text-[#0b3d2c]">A</div>
                    <span class="font-bold text-sm">Administrator</span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card-glass p-8 rounded-[2.5rem] flex justify-between items-center transform hover:scale-[1.02] transition-all">
                <div>
                    <h3 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-2">Total Bookings</h3>
                    <p class="text-5xl font-black"><?php echo $total_bookings; ?></p>
                </div>
                <i class="far fa-calendar-check text-5xl text-[#d4af37]/30"></i>
            </div>
            
            <div class="card-glass p-8 rounded-[2.5rem] flex justify-between items-center transform hover:scale-[1.02] transition-all">
                <div>
                    <h3 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-2">Active Cleaners</h3>
                    <p class="text-5xl font-black"><?php echo $active_cleaners; ?></p>
                </div>
                <i class="fas fa-user-shield text-5xl text-emerald-500/30"></i>
            </div>

            <div class="card-glass p-8 rounded-[2.5rem] flex justify-between items-center transform hover:scale-[1.02] transition-all">
                <div>
                    <h3 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-2">Total Customers</h3>
                    <p class="text-5xl font-black"><?php echo $total_customers; ?></p>
                </div>
                <i class="fas fa-users text-5xl text-blue-500/30"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-3 card-glass p-8 rounded-[2.5rem] flex items-center justify-between">
                <div class="w-1/3">
                    <h3 class="text-xl font-bold mb-6">Booking Statistics</h3>
                    <canvas id="bookingChart" class="max-h-56"></canvas>
                </div>
                <div class="w-1/2 pr-10 space-y-6">
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-300 font-semibold"><i class="fas fa-circle text-emerald-500 mr-3"></i> Completed</span>
                        <span class="text-xl font-black">60%</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-300 font-semibold"><i class="fas fa-circle text-yellow-500 mr-3"></i> Pending</span>
                        <span class="text-xl font-black">25%</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-300 font-semibold"><i class="fas fa-circle text-red-500 mr-3"></i> Cancelled</span>
                        <span class="text-xl font-black">15%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-glass rounded-[2.5rem] overflow-hidden">
            <div class="p-6 border-b border-white/10 flex justify-between items-center bg-white/5">
                <h3 class="font-black uppercase tracking-widest text-sm text-[#d4af37]">Recent Activity Log</h3>
                <a href="admin_bookings.php" class="text-emerald-400 text-xs font-bold hover:underline italic">View Full Records</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-slate-500 text-[10px] uppercase font-black tracking-widest bg-black/20">
                        <tr>
                            <th class="px-8 py-5">ID</th>
                            <th class="px-8 py-5">Customer</th>
                            <th class="px-8 py-5">Service</th>
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-white/5">
                        <?php while($row = $recent_bookings->fetch_assoc()): 
                            $status = $row['status'] ?? 'Pending';
                            $status_color = "text-yellow-500 bg-yellow-500/10";
                            if($status == 'Confirmed') $status_color = "text-blue-400 bg-blue-400/10";
                            if($status == 'Completed') $status_color = "text-emerald-400 bg-emerald-400/10";
                        ?>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-8 py-5 font-mono text-slate-400 italic">B<?php echo str_pad($row['booking_id'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td class="px-8 py-5 font-bold text-slate-200"><?php echo htmlspecialchars($row['name'] ?? 'Guest'); ?></td>
                            <td class="px-8 py-5 text-slate-400 italic text-xs uppercase tracking-tighter">Plan Type <?php echo $row['service_type']; ?></td>
                            <td class="px-8 py-5 font-medium"><?php echo date('d M Y', strtotime($row['booking_date'])); ?></td>
                            <td class="px-8 py-5 text-right">
                                <span class="px-3 py-1 rounded-lg font-black text-[10px] uppercase tracking-tighter <?php echo $status_color; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <p class="mt-8 text-center text-slate-600 text-[10px] font-bold uppercase tracking-[0.4em]">Wadap Maids • Operational Intelligence Panel © 2026</p>
    </main>

    <script>
        const ctx = document.getElementById('bookingChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [60, 25, 15],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 10,
                    cutout: '82%'
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>