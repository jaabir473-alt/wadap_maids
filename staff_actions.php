<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['admin_id'])) { exit("Access Denied"); }

// --- ADD STAFF ---
if (isset($_POST['add_staff'])) {
    $name = mysqli_real_escape_string($conn, $_POST['staff_name']);
    $role = mysqli_real_escape_string($conn, $_POST['staff_role']);
    $place = mysqli_real_escape_string($conn, $_POST['staff_assignedPlace']);
    $phone = mysqli_real_escape_string($conn, $_POST['staff_contactNo']);
    $status = $_POST['staff_status'];

    $sql = "INSERT INTO staff (staff_name, staff_role, staff_assignedPlace, staff_contactNo, staff_status) 
            VALUES ('$name', '$role', '$place', '$phone', '$status')";
    
    if ($conn->query($sql)) {
        header("Location: view_staff.php?msg=Staff Added Successfully");
    }
}

// --- UPDATE STAFF ---
if (isset($_POST['update_staff'])) {
    $id = $_POST['staff_id'];
    $name = mysqli_real_escape_string($conn, $_POST['staff_name']);
    $role = mysqli_real_escape_string($conn, $_POST['staff_role']);
    $place = mysqli_real_escape_string($conn, $_POST['staff_assignedPlace']);
    $phone = mysqli_real_escape_string($conn, $_POST['staff_contactNo']);
    $status = $_POST['staff_status'];

    $sql = "UPDATE staff SET staff_name='$name', staff_role='$role', 
            staff_assignedPlace='$place', staff_contactNo='$phone', staff_status='$status' 
            WHERE staff_id='$id'";
    
    if ($conn->query($sql)) {
        header("Location: view_staff.php?msg=Staff Updated Successfully");
    }
}

// --- DELETE STAFF ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("DELETE FROM staff WHERE staff_id='$id'")) {
        header("Location: view_staff.php?msg=Staff Deleted");
    }
}
?>