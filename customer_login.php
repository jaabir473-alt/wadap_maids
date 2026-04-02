<?php
session_start();
include 'db_config.php';

if (isset($_POST['login'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pass = $_POST['password'];

    $result = $conn->query("SELECT * FROM customers WHERE phone = '$phone'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['cust_id'] = $row['customer_id'];
            $_SESSION['cust_name'] = $row['name'];
            // Redirect to Dashboard
            header("Location: customer_dashboard.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Phone number not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login | Wadap Maids</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex justify-center items-center h-screen px-4">

<div class="bg-white p-10 rounded-[2.5rem] w-full max-w-md shadow-2xl border-t-8 border-[#d4af37]">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-black text-[#0b3d2c] tracking-tighter uppercase">Customer Login</h2>
        <p class="text-slate-400 text-xs mt-1 font-bold tracking-widest">WADAP MAIDS EMPIRE</p>
    </div>

    <?php if(isset($error)): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-2xl text-center text-sm font-bold mb-6 border border-red-100">
            <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-xs font-bold text-[#0b3d2c] uppercase tracking-wider mb-2 ml-1">Phone Number</label>
            <input type="text" name="phone" placeholder="01X-XXXXXXX" required 
                   class="w-full p-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-[#d4af37] outline-none transition-all">
        </div>
        <div>
            <label class="block text-xs font-bold text-[#0b3d2c] uppercase tracking-wider mb-2 ml-1">Password</label>
            <input type="password" name="password" placeholder="••••••••" required 
                   class="w-full p-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-[#d4af37] outline-none transition-all">
        </div>
        <button type="submit" name="login" class="w-full bg-[#0b3d2c] text-[#d4af37] p-5 rounded-2xl font-black text-lg shadow-xl hover:bg-emerald-950 transition-all transform active:scale-95">
            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
        </button>
    </form>

    <p class="text-center mt-8 text-sm font-medium text-slate-500">
        New here? <a href="customer_signup.php" class="text-[#0b3d2c] font-black hover:underline">Create an account</a>
    </p>

    <div class="relative my-10">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
        <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-4 text-slate-300 font-bold tracking-widest">Admin Access</span></div>
    </div>

    <div class="text-center">
        <a href="login.php" class="inline-block w-full py-4 border-2 border-[#0b3d2c] text-[#0b3d2c] rounded-2xl font-black text-sm hover:bg-[#0b3d2c] hover:text-[#d4af37] transition-all">
            <i class="fas fa-user-shield mr-2"></i> Admin Login
        </a>
    </div>
</div>

</body>
</html>