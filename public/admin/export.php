<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$dataFile = __DIR__ . '/../data.json';
$data = json_decode(file_get_contents($dataFile), true);
$orders = $data['orders'] ?? [];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=orders-' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Customer', 'Phone', 'Product', 'Qty', 'Total', 'Payment', 'Status', 'Date', 'Address']);

foreach ($orders as $o) {
    fputcsv($output, [
        $o['id'],
        $o['customer'],
        $o['phone'],
        $o['product'],
        $o['qty'],
        $o['total'],
        $o['payment'] ?? 'Transfer',
        $o['status'],
        $o['date'],
        $o['address']
    ]);
}
fclose($output);
exit;
