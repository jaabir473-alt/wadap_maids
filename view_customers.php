<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include 'db_config.php';

// Fetch Customer Data
$sql = "SELECT * FROM customers WHERE password IS NOT NULL ORDER BY customer_id ASC";
$result = $conn->query($sql);
$total_clients = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Database | Wadap Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 flex">

    <aside class="fixed inset-y-0 left-0 w-64 bg-[#0b3d2c] text-white hidden md:flex flex-col shadow-2xl no-print">
        <div class="p-8">
            <h2 class="text-2xl font-black tracking-tighter text-[#d4af37]">WADAP<span class="text-white">MAIDS</span></h2>
        </div>
        
        <nav class="flex-1 px-4 space-y-2">
            <a href="admin_bookings.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-[#145a43] text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-calendar-check w-5 text-center"></i>
                <span>Bookings</span>
            </a>

            <a href="view_customers.php" class="flex items-center space-x-3 px-4 py-3 bg-[#d4af37] text-[#0b3d2c] rounded-xl font-bold transition-all shadow-lg">
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

    <main class="md:ml-64 flex-1 min-h-screen">
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-200 px-8 py-6 flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-[#0b3d2c]">Customer Database</h1>
                <p class="text-slate-500 text-sm">Managing <span class="font-bold text-emerald-700"><?php echo $total_clients; ?></span> registered clients</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="relative w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400"><i class="fas fa-search text-xs"></i></span>
                    <input type="text" id="custSearch" placeholder="Search name, phone, email..." class="w-full pl-9 pr-4 py-2 bg-slate-100 border-none rounded-xl text-sm focus:ring-2 focus:ring-[#d4af37] outline-none">
                </div>
                <button onclick="window.print()" class="bg-[#0b3d2c] text-[#d4af37] font-bold px-6 py-2.5 rounded-xl shadow-md hover:bg-[#145a43] transition-all flex items-center space-x-2">
                    <i class="fas fa-print"></i>
                    <span>Print Report</span>
                </button>
            </div>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="custTable">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="p-6 text-slate-400 font-bold text-xs uppercase tracking-widest">ID</th>
                                <th class="p-6 text-slate-400 font-bold text-xs uppercase tracking-widest">Full Name</th>
                                <th class="p-6 text-slate-400 font-bold text-xs uppercase tracking-widest">Contact Details</th>
                                <th class="p-6 text-slate-400 font-bold text-xs uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                <td class="p-6 font-mono text-slate-400 italic">
    C<?php echo str_pad($row['customer_id'], 4, '0', STR_PAD_LEFT); ?>
</td>
                                    <td class="p-6">
                                        <div class="font-bold text-slate-700"><?php echo htmlspecialchars($row['name']); ?></div>
                                        <div class="text-[10px] font-black text-emerald-600 uppercase tracking-tighter">Verified Client</div>
                                    </td>
                                    <td class="p-6">
                                        <div class="flex items-center text-slate-600 text-sm mb-1">
                                            <i class="fas fa-phone mr-2 text-xs text-slate-400"></i> <?php echo htmlspecialchars($row['phone']); ?>
                                        </div>
                                        <div class="flex items-center text-slate-400 text-xs italic">
                                            <i class="fas fa-envelope mr-2 text-[10px]"></i> <?php echo htmlspecialchars($row['email']); ?>
                                        </div>
                                    </td>
                                    <td class="p-6 text-right">
                                        <button class="bg-white border-2 border-slate-100 text-slate-600 px-4 py-1.5 rounded-xl text-xs font-bold uppercase hover:bg-slate-100 transition-all">
                                            <i class="fas fa-user-edit mr-2"></i> Update
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="p-20 text-center text-slate-400 italic font-medium">No customers found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="mt-10 text-center text-slate-300 font-bold text-[10px] uppercase tracking-[0.3em]">WADAP MAIDS EMPIRE OPERATIONAL DATA DASHBOARD © 2026</p>
        </div>
    </main>

    <script>
        document.getElementById('custSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.cust-row');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
            });
        });
    </script>
</body>
</html>