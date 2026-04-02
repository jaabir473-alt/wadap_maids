<?php
session_start();
include 'db_config.php';

// Security: Redirect to login if session is empty
if (!isset($_SESSION['cust_id'])) {
    header("Location: customer_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Maid | Wadap Maids</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center px-4 py-12">

    <div class="bg-white p-10 rounded-[2.5rem] w-full max-w-lg shadow-2xl border border-slate-100">
        
        <div class="mb-6">
            <a href="customer_dashboard.php" class="text-[#0b3d2c] font-bold text-sm flex items-center space-x-2 hover:translate-x-[-5px] transition-transform">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-[#0b3d2c] tracking-tighter">Make a Booking</h2>
            <div class="mt-4 inline-flex items-center space-x-2 bg-emerald-50 text-emerald-700 px-4 py-2 rounded-full text-sm font-bold">
                <i class="fas fa-user-circle"></i>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['cust_name']); ?>!</span>
            </div>
        </div>

        <div class="text-center mb-8">
            <a href="my_bookings.php" class="text-[#0b3d2c] text-sm font-bold underline hover:text-emerald-700 decoration-[#d4af37] decoration-2 underline-offset-4">
                <i class="fas fa-list-ul mr-1"></i> View My Past Bookings
            </a>
        </div>

        <form action="submit_booking.php" method="POST" class="space-y-6">
            
            <div class="space-y-2">
                <label class="block text-xs font-bold text-[#0b3d2c] uppercase tracking-widest ml-1">Choose Service</label>
                <select name="service_id" required 
                        class="w-full p-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-[#d4af37] outline-none transition-all cursor-pointer font-medium text-slate-700">
                    <option value="">-- Select Service --</option>
                    <option value="1">Basic Cleaning (RM25/hr)</option>
                    <option value="2">Deep Cleaning (RM50/hr)</option>
                    <option value="3">Office Pro (RM40/hr)</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-[#0b3d2c] uppercase tracking-widest ml-1">Booking Date</label>
                <input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required 
                       class="w-full p-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-[#d4af37] outline-none transition-all font-medium text-slate-700">
            </div>

            <button type="submit" name="submit" 
                    class="w-full bg-[#0b3d2c] text-[#d4af37] p-5 rounded-2xl font-black text-lg shadow-xl hover:bg-emerald-950 transition-all transform active:scale-95">
                Confirm My Booking
            </button>
        </form>
        
        <p class="text-center mt-8 text-xs text-slate-400 font-bold uppercase tracking-widest">
            Not you? <a href="logout.php" class="text-red-500 hover:underline">Logout</a>
        </p>
    </div>

</body>
</html>