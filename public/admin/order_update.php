<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$status = $_GET['status'] ?? '';

if ($id && $status) {
    $dataFile = __DIR__ . '/../data.json';
    $data = json_decode(file_get_contents($dataFile), true) ?: [];
    
    foreach ($data['orders'] as &$o) {
        if ($o['id'] == $id) {
            $o['status'] = $status;
            break;
        }
    }
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
}

header('Location: orders.php');
exit;
