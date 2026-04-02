<?php
session_start();
// Security: Redirect to login if not authenticated as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: view_staff.php");
    exit();
}

include 'db_config.php';