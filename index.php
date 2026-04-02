<?php
session_start();
// If already logged in, redirect to their respective dashboard
if (isset($_SESSION['cust_id'])) {
    header("Location: customer_dashboard.php");
    exit();
}
if (isset($_SESSION['admin_id'])) {
    header("Location: admin_bookings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wadap Maids Empire | Premium Cleaning Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="fixed w-full z-50 glass border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-[#0b3d2c] rounded-xl flex items-center justify-center text-[#d4af37]">
                    <i class="fas fa-broom text-xl"></i>
                </div>
                <span class="text-2xl font-black text-[#0b3d2c] tracking-tighter uppercase">Wadap Maids</span>
            </div>
            
            <div class="hidden md:flex space-x-8 font-bold text-sm text-slate-600 uppercase tracking-widest">
                <a href="#services" class="hover:text-[#0b3d2c] transition">Services</a>
                <a href="services.php" class="hover:text-[#0b3d2c] transition">Pricing</a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="customer_login.php" class="text-[#0b3d2c] font-bold text-sm px-4">Login</a>
                <a href="customer_signup.php" class="bg-[#0b3d2c] text-[#d4af37] px-6 py-3 rounded-2xl font-black text-sm shadow-xl hover:bg-emerald-900 transition-all">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            <div class="z-10">
                <span class="bg-emerald-100 text-[#0b3d2c] px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest mb-6 inline-block">
                    #1 Cleaning Service in Penang & Kedah
                </span>
                <h1 class="text-6xl lg:text-8xl font-black text-[#0b3d2c] leading-[0.9] tracking-tighter mb-8">
                    Pure Clean. <br><span class="text-[#d4af37]">No Stress.</span>
                </h1>
                <p class="text-xl text-slate-500 mb-10 max-w-lg leading-relaxed">
                    Premium professional cleaning for homes and offices. Book in 60 seconds and reclaim your free time.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="customer_signup.php" class="bg-[#0b3d2c] text-[#d4af37] px-10 py-5 rounded-[2rem] font-black text-xl shadow-2xl hover:scale-105 transition-all text-center">
                        Book Your First Clean
                    </a>
                    <a href="#services" class="bg-white text-slate-700 border border-slate-200 px-10 py-5 rounded-[2rem] font-bold text-xl hover:bg-slate-50 transition-all text-center">
                        Our Services
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="w-full aspect-square bg-[#d4af37] rounded-[3rem] rotate-3 overflow-hidden shadow-2xl relative">
                    <div class="absolute inset-0 bg-emerald-950 opacity-20 group-hover:opacity-0 transition"></div>
                    <div class="absolute inset-0 flex items-center justify-center p-12">
                         <i class="fas fa-house-chimney-window text-[15rem] text-[#0b3d2c] opacity-20 -rotate-12"></i>
                    </div>
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-3xl shadow-2xl border border-slate-100 flex items-center space-x-4">
                    <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="font-black text-[#0b3d2c]">Verified Maids</p>
                        <p class="text-xs text-slate-400 font-bold uppercase">100% Background Checked</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center mb-16">
            <h2 class="text-4xl font-black text-[#0b3d2c] mb-4 uppercase tracking-tighter">What We Offer</h2>
            <div class="w-24 h-2 bg-[#d4af37] mx-auto rounded-full"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8">
            <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:border-[#d4af37] transition-all group">
                <i class="fas fa-broom text-4xl text-[#d4af37] mb-6 block"></i>
                <h3 class="text-2xl font-black text-[#0b3d2c] mb-4">Residential</h3>
                <p class="text-slate-500 mb-6">Routine cleaning to keep your home sparkless every single week.</p>
                <span class="text-sm font-black text-[#0b3d2c]">From RM25/hr</span>
            </div>
            <div class="p-10 rounded-[2.5rem] bg-[#0b3d2c] text-white border border-slate-100 shadow-2xl transform scale-105">
                <i class="fas fa-sparkles text-4xl text-[#d4af37] mb-6 block"></i>
                <h3 class="text-2xl font-black mb-4">Deep Clean</h3>
                <p class="text-emerald-100 opacity-80 mb-6">A heavy-duty scrub for when your house needs a total reset.</p>
                <span class="text-sm font-black text-[#d4af37] uppercase tracking-widest">Most Popular</span>
            </div>
            <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:border-[#d4af37] transition-all">
                <i class="fas fa-building text-4xl text-[#d4af37] mb-6 block"></i>
                <h3 class="text-2xl font-black text-[#0b3d2c] mb-4">Commercial</h3>
                <p class="text-slate-500 mb-6">Office and industrial cleaning tailored to your business hours.</p>
                <span class="text-sm font-black text-[#0b3d2c]">Custom Quotes</span>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white py-20 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-12 border-b border-slate-800 pb-16 mb-12">
            <div class="col-span-2">
                <h2 class="text-3xl font-black text-[#d4af37] mb-6">WADAP MAIDS</h2>
                <p class="text-slate-400 max-w-sm">The leading professional cleaning platform in Northern Malaysia. Providing jobs for locals and sparkless homes for you.</p>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase text-xs tracking-[0.2em] text-[#d4af37]">Quick Links</h4>
                <ul class="space-y-4 text-slate-400 text-sm font-bold">
                    <li><a href="customer_login.php" class="hover:text-white transition">Customer Login</a></li>
                    <li><a href="login.php" class="hover:text-white transition">Admin Portal</a></li>
                    <li><a href="services.php" class="hover:text-white transition">Full Services List</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase text-xs tracking-[0.2em] text-[#d4af37]">Support</h4>
                <p class="text-slate-400 text-sm font-bold mb-2 underline">support@wadapmaids.com</p>
                <p class="text-slate-400 text-sm font-bold">Penang & Kedah, Malaysia</p>
            </div>
        </div>
        <p class="text-center text-slate-500 text-xs font-bold uppercase tracking-widest">
            &copy; 2026 Wadap Maids Empire Operational Dashboard.
        </p>
    </footer>

</body>
</html>