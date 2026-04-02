<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['cust_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['cust_id'];

// Fetch customer bookings including the status column
$sql = "SELECT booking_id, service_type, booking_date, status 
        FROM bookings 
        WHERE customer_id = '$customer_id' 
        ORDER BY booking_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings | Wadap Maids</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans antialiased">

<div class="max-w-4xl mx-auto my-12 px-6">
    <div class="mb-6">
        <a href="customer_dashboard.php" class="text-[#0b3d2c] font-bold flex items-center space-x-2 hover:translate-x-[-5px] transition-transform">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Dashboard</span>
        </a>
    </div>

    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-black text-[#0b3d2c]">My Bookings</h2>
            <p class="text-slate-500 font-medium">History of your cleaning services</p>
        </div>
        <a href="booking.php" class="bg-[#0b3d2c] text-[#d4af37] px-6 py-3 rounded-2xl font-bold shadow-lg hover:bg-emerald-950 transition-all">
            + New Booking
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="p-6 text-xs font-bold uppercase text-slate-400 tracking-widest">Service Plan</th>
                    <th class="p-6 text-xs font-bold uppercase text-slate-400 tracking-widest">Date</th>
                    <th class="p-6 text-xs font-bold uppercase text-slate-400 tracking-widest text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $status = $row['status'] ?? 'Pending';
                        
                        // Dynamic Status Colors
                        $badge_class = "bg-slate-100 text-slate-500"; 
                        if($status == 'Confirmed') $badge_class = "bg-blue-100 text-blue-600";
                        if($status == 'Completed') $badge_class = "bg-emerald-100 text-emerald-600";
                        if($status == 'Cancelled') $badge_class = "bg-red-100 text-red-600";

                        // Service Mapping
                        $services = ["1" => "Basic Cleaning", "2" => "Deep Cleaning", "3" => "Office Pro"];
                        $srv_name = $services[$row['service_type']] ?? "Custom Cleaning";

                        echo "<tr class='hover:bg-slate-50 transition-colors'>
                                <td class='p-6'>
                                    <div class='font-bold text-[#0b3d2c] text-lg'>{$srv_name}</div>
                                    <div class='text-[10px] text-slate-400 uppercase font-black tracking-tighter'>Booking #{$row['booking_id']}</div>
                                </td>
                                <td class='p-6 text-slate-600 font-bold'>
                                    " . date('d M Y', strtotime($row['booking_date'])) . "
                                </td>
                                <td class='p-6 text-center'>
                                    <span class='px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {$badge_class}'>
                                        {$status}
                                    </span>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='p-20 text-center text-slate-400 italic font-bold'>No cleaning history found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="mt-10 text-center">
        <a href="logout.php" class="text-red-500 font-black text-xs uppercase tracking-widest hover:underline">
            <i class="fas fa-sign-out-alt mr-2"></i> End Session / Logout
        </a>
    </div>
</div>

</body>
</html>