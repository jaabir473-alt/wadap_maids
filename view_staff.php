<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }
include 'db_config.php';

// Stats logic for the cards [cite: 137, 143]
$total_staff = $conn->query("SELECT COUNT(*) as total FROM staff")->fetch_assoc()['total'];
$active_staff = $conn->query("SELECT COUNT(*) as total FROM staff WHERE staff_status = 'Active'")->fetch_assoc()['total'];

$sql = "SELECT * FROM staff ORDER BY staff_id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Management | Wadap Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        
        /* THE KEY: Modal starts hidden  */
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 50; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.6); 
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="flex">

    <aside class="fixed inset-y-0 left-0 w-64 bg-[#0b3d2c] text-white flex flex-col shadow-2xl">
        <div class="p-8"><h2 class="text-2xl font-black text-[#d4af37]">WADAP<span class="text-white">MAIDS</span></h2></div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="admin_dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-[#145a43] text-slate-300 rounded-xl transition-all font-bold"><i class="fas fa-th-large w-5"></i><span>Dashboard</span></a>
            <a href="admin_bookings.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-[#145a43] text-slate-300 rounded-xl transition-all font-bold"><i class="fas fa-calendar-check w-5"></i><span>Bookings</span></a>
            <a href="view_customers.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-[#145a43] text-slate-300 rounded-xl transition-all font-bold"><i class="fas fa-users w-5"></i><span>Customers</span></a>
            <a href="view_staff.php" class="flex items-center space-x-3 px-4 py-3 bg-[#d4af37] text-[#0b3d2c] rounded-xl font-bold transition-all shadow-lg"><i class="fas fa-id-badge w-5"></i><span>Staff Management</span></a>
        </nav>
    </aside>

    <main class="md:ml-64 flex-1 min-h-screen p-8">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl font-extrabold text-[#0b3d2c]">Staff Management</h1>
                <p class="text-slate-500 text-sm italic">Operational Crew Performance Logs</p>
            </div>
            <button onclick="toggleModal('addModal')" class="bg-[#0b3d2c] text-[#d4af37] font-bold px-6 py-3 rounded-xl shadow-md hover:scale-105 transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i><span>Add New Staff</span>
            </button>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-5">
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-2xl"><i class="fas fa-user-check text-2xl"></i></div>
                <div><h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Active Crew</h3><p class="text-3xl font-black text-[#0b3d2c]"><?php echo $active_staff; ?></p></div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-5">
                <div class="bg-yellow-50 text-[#0b3d2c] p-4 rounded-2xl"><i class="fas fa-users text-2xl"></i></div>
                <div><h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Members</h3><p class="text-3xl font-black text-[#0b3d2c]"><?php echo $total_staff; ?></p></div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="p-6 text-slate-400 font-bold text-xs uppercase tracking-widest">Staff ID</th>
                        <th class="p-6 text-slate-400 font-bold text-xs uppercase tracking-widest">Full Name</th>
                        <th class="p-6 text-slate-400 font-bold text-xs uppercase tracking-widest text-center">Status</th>
                        <th class="p-6 text-slate-400 font-bold text-xs uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while($row = $result->fetch_assoc()): 
                        $status_badge = ($row['staff_status'] == 'Active') ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400';
                    ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-6 font-mono text-slate-400 italic">S<?php echo str_pad($row['staff_id'], 4, '0', STR_PAD_LEFT); ?></td>
                        <td class="p-6 font-bold text-slate-700"><?php echo htmlspecialchars($row['staff_name']); ?></td>
                        <td class="p-6 text-center">
                            <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest <?php echo $status_badge; ?>">
                                <?php echo $row['staff_status']; ?>
                            </span>
                        </td>
                        <td class="p-6 text-right space-x-3">
                            <button onclick="editStaff(<?php echo htmlspecialchars(json_encode($row)); ?>)" class="text-blue-600 font-black text-[10px] uppercase hover:underline">Update</button>
                            <a href="staff_actions.php?delete=<?php echo $row['staff_id']; ?>" onclick="return confirm('Delete this staff?')" class="text-red-500 font-black text-[10px] uppercase hover:underline">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addModal" class="modal flex items-center justify-center">
        <div class="bg-white p-10 rounded-[2.5rem] w-full max-w-md shadow-2xl transform transition-all">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-black text-[#0b3d2c]">Add New Staff</h2>
                <button onclick="toggleModal('addModal')" class="text-slate-400 hover:text-red-500 transition-colors"><i class="fas fa-times text-xl"></i></button>
            </div>

            <form action="staff_actions.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Full Name</label>
                    <input type="text" name="staff_name" required class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37] transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Role</label>
                    <input type="text" name="staff_role" required class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37] transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Location</label>
                        <input type="text" name="staff_assignedPlace" required class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37] transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Status</label>
                        <select name="staff_status" class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37] transition-all cursor-pointer font-bold text-sm">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Contact No</label>
                    <input type="text" name="staff_contactNo" required class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37] transition-all">
                </div>

                <div class="flex space-x-3 pt-6">
                    <button type="button" onclick="toggleModal('addModal')" class="flex-1 py-4 font-bold text-slate-400 hover:text-slate-600">Cancel</button>
                    <button type="submit" name="add_staff" class="flex-1 py-4 bg-[#0b3d2c] text-[#d4af37] rounded-2xl font-black shadow-lg hover:bg-emerald-900 transition-all">
                        Save Staff
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="updateModal" class="modal flex items-center justify-center">
        <div class="bg-white p-10 rounded-[2.5rem] w-full max-w-md shadow-2xl">
            <h2 class="text-2xl font-black text-[#0b3d2c] mb-8">Update Staff Info</h2>
            <form action="staff_actions.php" method="POST" class="space-y-4">
                <input type="hidden" name="staff_id" id="edit_id">
                <input type="text" name="staff_name" id="edit_name" required class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37]">
                <input type="text" name="staff_role" id="edit_role" required class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37]">
                <input type="text" name="staff_assignedPlace" id="edit_place" required class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37]">
                <input type="text" name="staff_contactNo" id="edit_phone" required class="w-full p-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-[#d4af37]">
                <select name="staff_status" id="edit_status" class="w-full p-4 bg-slate-100 rounded-2xl font-bold">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <div class="flex space-x-3 pt-6">
                    <button type="button" onclick="toggleModal('updateModal')" class="flex-1 py-4 font-bold text-slate-400">Cancel</button>
                    <button type="submit" name="update_staff" class="flex-1 py-4 bg-[#0b3d2c] text-[#d4af37] rounded-2xl font-black shadow-lg">
                        Update Info
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        [cite_start]// FUNCTION TO TOGGLE MODAL VISIBILITY [cite: 191]
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal.style.display === "flex") {
                modal.style.display = "none";
            } else {
                modal.style.display = "flex";
            }
        }

        function editStaff(staff) {
            document.getElementById('edit_id').value = staff.staff_id;
            document.getElementById('edit_name').value = staff.staff_name;
            document.getElementById('edit_role').value = staff.staff_role;
            document.getElementById('edit_place').value = staff.staff_assignedPlace;
            document.getElementById('edit_phone').value = staff.staff_contactNo;
            document.getElementById('edit_status').value = staff.staff_status;
            toggleModal('updateModal');
        }

        // Close modal if user clicks outside of the box
        window.onclick = function(event) {
            if (event.target.className.includes('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>
</body>
</html>