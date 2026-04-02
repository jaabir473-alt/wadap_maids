<?php
session_start();
include 'db_config.php';

// If user is logged in, we show the dashboard layout. 
// If not, we show a simplified version (optional, but good for UX).
$logged_in = isset($_SESSION['cust_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Wadap Maids</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    <?php if($logged_in): ?>
    <aside class="w-64 bg-[#0b3d2c] h-screen sticky top-0 text-white flex flex-col p-6 shadow-2xl">
        <div class="mb-10">
            <h2 class="text-2xl font-black text-[#d4af37] tracking-tighter">WADAP<span class="text-white">MAIDS</span></h2>
        </div>
        
        <nav class="flex-1 space-y-2">
            <a href="customer_dashboard.php" class="flex items-center space-x-3 p-3 hover:bg-emerald-800 text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-home w-5 text-center"></i> <span>Dashboard</span>
            </a>
            <a href="services.php" class="flex items-center space-x-3 p-3 bg-emerald-900 rounded-xl text-[#d4af37] font-bold shadow-lg transition-all">
                <i class="fas fa-broom w-5 text-center"></i> <span>Our Services</span>
            </a>
            <a href="booking.php" class="flex items-center space-x-3 p-3 hover:bg-emerald-800 text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-plus-circle w-5 text-center"></i> <span>Book a Maid</span>
            </a>
            <a href="my_bookings.php" class="flex items-center space-x-3 p-3 hover:bg-emerald-800 text-slate-300 hover:text-white rounded-xl transition-all">
                <i class="fas fa-history w-5 text-center"></i> <span>My History</span>
            </a>
        </nav>

        <a href="logout.php" class="p-3 text-red-400 font-bold hover:bg-red-500 hover:text-white rounded-xl transition mt-auto flex items-center space-x-3">
            <i class="fas fa-power-off w-5 text-center"></i> <span>Logout</span>
        </a>
    </aside>
    <?php endif; ?>

    <main class="flex-1 p-10">
        <div class="max-w-6xl mx-auto">
            <header class="flex justify-between items-end mb-12">
                <div>
                    <h1 class="text-4xl font-black text-[#0b3d2c] mb-2">Our Professional Services</h1>
                    <p class="text-slate-500 text-lg">Expert Cleaning Solutions for Every Need in Penang & Kedah</p>
                </div>
                <?php if($logged_in): ?>
                <a href="customer_dashboard.php" class="text-emerald-700 font-bold hover:underline">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
                <?php endif; ?>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group border-t-8 border-t-[#d4af37]">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 text-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-tint"></i>
                    </div>
                    <h3 class="text-xl font-black text-[#0b3d2c] mb-3">Basic House Cleaning</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">General dusting, mopping, and vacuuming for a fresh daily home environment.</p>
                    <span class="inline-block bg-[#f1d592] text-[#0b3d2c] px-4 py-1.5 rounded-full font-black text-xs uppercase tracking-wider">From RM25/hr</span>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group border-t-8 border-t-[#d4af37]">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 text-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-sparkles"></i>
                    </div>
                    <h3 class="text-xl font-black text-[#0b3d2c] mb-3">Deep Cleaning</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Intensive scrub of bathrooms, kitchens, and hard-to-reach areas. Highly recommended.</p>
                    <span class="inline-block bg-[#f1d592] text-[#0b3d2c] px-4 py-1.5 rounded-full font-black text-xs uppercase tracking-wider">From RM50/hr</span>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group border-t-8 border-t-[#d4af37]">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 text-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="text-xl font-black text-[#0b3d2c] mb-3">Office & Commercial</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Maintain a professional workspace with our customized maintenance packages.</p>
                    <span class="inline-block bg-[#f1d592] text-[#0b3d2c] px-4 py-1.5 rounded-full font-black text-xs uppercase tracking-wider">Contact for Quote</span>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group border-t-8 border-t-[#d4af37]">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 text-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-truck-loading"></i>
                    </div>
                    <h3 class="text-xl font-black text-[#0b3d2c] mb-3">Move In/Out</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Full sanitization before you move into your new home or to get your deposit back.</p>
                    <span class="inline-block bg-[#f1d592] text-[#0b3d2c] px-4 py-1.5 rounded-full font-black text-xs uppercase tracking-wider">From RM150</span>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group border-t-8 border-t-[#d4af37]">
                    <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6 text-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-couch"></i>
                    </div>
                    <h3 class="text-xl font-black text-[#0b3d2c] mb-3">Sofa & Carpet</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Professional steam cleaning to remove stains and allergens from your upholstery.</p>
                    <span class="inline-block bg-[#f1d592] text-[#0b3d2c] px-4 py-1.5 rounded-full font-black text-xs uppercase tracking-wider">From RM80</span>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group border-t-8 border-t-[#d4af37]">
                    <div class="w-14 h-14 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center mb-6 text-2xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h3 class="text-xl font-black text-[#0b3d2c] mb-3">Homestay Prep</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Quick turnaround cleaning and linen changes for high-rated guest experiences.</p>
                    <span class="inline-block bg-[#f1d592] text-[#0b3d2c] px-4 py-1.5 rounded-full font-black text-xs uppercase tracking-wider">RM40 / Session</span>
                </div>

            </div>

            <div class="mt-16 text-center">
                <a href="booking.php" class="bg-[#0b3d2c] text-[#d4af37] px-12 py-4 rounded-2xl font-black text-lg shadow-2xl hover:scale-105 hover:bg-emerald-900 transition-all inline-block">
                    Book a Service Now
                </a>
            </div>
        </div>
    </main>

</body>
</html>