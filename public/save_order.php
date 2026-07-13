<?php
header('Content-Type: application/json');

$dataFile = __DIR__ . '/data.json';
$data = json_decode(file_get_contents($dataFile), true);

$input = json_decode(file_get_contents('php://input'), true);

if ($input) {
    $orders = $data['orders'] ?? [];
    $newId = count($orders) + 1;
    
    $orderId = $input['order_id'] ?? 'ORD-' . date('Ymd') . '-' . rand(100, 999);
    
    $newOrder = [
        'id' => $newId,
        'order_id' => $orderId,
        'customer' => $input['customer'] ?? '',
        'phone' => $input['phone'] ?? '',
        'address' => $input['address'] ?? '',
        'product' => $input['products'] ?? '',
        'qty' => intval($input['qty'] ?? 1),
        'total' => intval($input['total'] ?? 0),
        'payment' => $input['payment'] ?? 'Transfer Bank',
        'status' => $input['status'] ?? 'New',
        'date' => $input['date'] ?? date('Y-m-d'),
        'latitude' => $input['latitude'] ?? '',
        'longitude' => $input['longitude'] ?? '',
        'notes' => $input['notes'] ?? ''
    ];
    
    $data['orders'][] = $newOrder;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
    
    // Kirim WhatsApp ke customer (simulasi)
    // Sebenarnya ini cuma nyiapin pesan, nanti di checkout udah dikirim ke WA admin
    // Tapi kita tambahin link tracking di response
    
    echo json_encode([
        'status' => 'success', 
        'order_id' => $newOrder['id'],
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data']);
}
