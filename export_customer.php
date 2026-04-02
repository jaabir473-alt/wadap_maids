<?php
include 'db_config.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="wadap_customers.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Name', 'Phone', 'Email', 'City', 'Joined Date'));

$query = "SELECT customer_id, name, phone, email, city, created_at FROM customers WHERE password IS NOT NULL";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
?>