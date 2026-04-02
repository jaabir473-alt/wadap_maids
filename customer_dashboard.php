<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['cust_id'])) {
    header("Location: customer_login.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];

// 1. Fetch Stats for the Customer
$stats_query = $conn->query("SELECT 
    COUNT(*) as total_bookings,
    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_jobs,
    MAX(booking_date) as last_service
    FROM bookings WHERE customer_id = '$cust_id'");
$stats = $stats_query->fetch_assoc();

// 2. Fetch Recent Activity (Limit to 5)
$recent_sql = "SELECT * FROM bookings WHERE customer_id = '$cust_id' ORDER BY booking_id DESC LIMIT 5";
$recent_result = $conn->query($recent_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | Wadap Maids</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    <aside class="w-64 bg-[#0b3d2c] h-screen sticky top-0 text-white flex flex-col p-6 shadow-2xl">
        <div class="mb-10">
            <h2 class="text-2xl font-black text-[#d4af37] tracking-tighter">WADAP<span class="text-white">MAIDS</span></h2>
            <p class="text-[10px] uppercase tracking-[0.2em] opacity-50">Customer Portal</p>
        </div>
        
        <nav class="flex-1 space-y-2">
            <a href="customer_dashboard.php" class="flex items-center space-x-3 p-3 bg-emerald-900 rounded-xl text-[#d4af37] font-bold shadow-lg transition-all">
                <i class="fas fa-home w-5 text-center"></i> 
                <span>Dashboard</span>
            </a>

            <a href="services.php" class="flex items-center space-x-3 p-3 hover:bg-emerald-800 text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-broom w-5 text-center"></i> 
                <span>Our Services</span>
            </a>

            <a href="booking.php" class="flex items-center space-x-3 p-3 hover:bg-emerald-800 text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-plus-circle w-5 text-center"></i> 
                <span>Book a Maid</span>
            </a>

            <a href="my_bookings.php" class="flex items-center space-x-3 p-3 hover:bg-emerald-800 text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-history w-5 text-center"></i> 
                <span>My History</span>
            </a>
        </nav>

        <a href="logout.php" class="p-3 text-red-400 font-bold hover:bg-red-500 hover:text-white rounded-xl transition mt-auto flex items-center space-x-3">
            <i class="fas fa-power-off w-5 text-center"></i> 
            <span>Logout</span>
        </a>
    </aside>

    <main class="flex-1 p-10">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black text-[#0b3d2c] capitalize">Hello, <?php echo explode(' ', $_SESSION['cust_name'])[0]; ?>!</h1>
                <p class="text-slate-500">Welcome back to your cleaning portal.</p>
            </div>
            <div class="bg-white p-2 rounded-full shadow-sm flex items-center pr-6 space-x-3 border border-slate-100">
                <div class="w-10 h-10 rounded-full bg-[#d4af37] flex items-center justify-center text-[#0b3d2c] font-bold text-lg uppercase shadow-inner">
                    <?php echo substr($_SESSION['cust_name'], 0, 1); ?>
                </div>
                <span class="font-bold text-sm text-[#0b3d2c]"><?php echo htmlspecialchars($_SESSION['cust_name']); ?></span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Total Bookings</h3>
                <p class="text-4xl font-black text-[#0b3d2c]"><?php echo $stats['total_bookings']; ?></p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Jobs Completed</h3>
                <p class="text-4xl font-black text-emerald-600"><?php echo $stats['completed_jobs']; ?></p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Last Service</h3>
                <p class="text-xl font-bold text-slate-700 mt-2">
                    <?php echo ($stats['last_service']) ? date('d M Y', strtotime($stats['last_service'])) : 'No history yet'; ?>
                </p>
            </div>
        </div>

        <div class="bg-[#0b3d2c] rounded-[2.5rem] p-10 text-white flex items-center justify-between mb-10 relative overflow-hidden shadow-xl border border-emerald-900">
            <div class="z-10 relative">
                <h2 class="text-2xl font-bold mb-2 text-[#d4af37]">Need a fresh start?</h2>
                <p class="text-emerald-100 opacity-80 mb-6 max-w-sm">Book a professional cleaning today and let us handle the dust while you relax.</p>
                <a href="booking.php" class="bg-[#d4af37] text-[#0b3d2c] px-8 py-3 rounded-2xl font-black shadow-lg hover:scale-105 hover:bg-yellow-400 transition-all inline-block">
                    Book Now
                </a>
            </div>
            <i class="fas fa-broom text-9xl text-emerald-900 absolute -right-6 -bottom-6 opacity-30 rotate-12"></i>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h2 class="text-lg font-bold text-[#0b3d2c]">Recent Activity</h2>
                <a href="my_bookings.php" class="text-xs font-bold text-emerald-700 hover:underline">View All History</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-100">
                        <?php if($recent_result->num_rows > 0): ?>
                            <?php while($row = $recent_result->fetch_assoc()): 
                                $status = $row['status'] ?? 'Pending';
                                // Dynamic color based on status
                                $status_color = "text-blue-500";
                                if($status == 'Completed') $status_color = "text-emerald-500";
                                if($status == 'Cancelled') $status_color = "text-red-500";
                                if($status == 'Confirmed') $status_color = "text-amber-500";
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="p-5">
                                    <div class="font-bold text-slate-700 group-hover:text-[#0b3d2c]">Plan Type <?php echo $row['service_type']; ?></div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase">ID #<?php echo $row['booking_id']; ?></div>
                                </td>
                                <td class="p-5 text-slate-500 font-medium"><?php echo date('d M Y', strtotime($row['booking_date'])); ?></td>
                                <td class="p-5 text-right font-black uppercase text-[10px] tracking-widest <?php echo $status_color; ?>">
                                    <?php echo $status; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="p-10 text-center text-slate-400 italic">No recent activity found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>