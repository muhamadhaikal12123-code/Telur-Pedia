<?php
header('Content-Type: application/json');

$dataFile = __DIR__ . '/data.json';

if (!file_exists($dataFile)) {
    $default = [
        'products' => [],
        'orders' => [],
        'users' => [
            ['id' => 1, 'username' => 'admin', 'password' => 'admin123', 'role' => 'admin', 'name' => 'Administrator']
        ],
        'settings' => [
            'store_name' => 'Telur Pedia',
            'store_phone' => '0812-3456-7890',
            'store_email' => 'info@telurpedia.com',
            'store_address' => 'Tangerang, Indonesia',
            'whatsapp_number' => '6281234567890'
        ]
    ];
    file_put_contents($dataFile, json_encode($default, JSON_PRETTY_PRINT));
}

$data = json_decode(file_get_contents($dataFile), true);
$input = json_decode(file_get_contents('php://input'), true);

if ($input) {
    $orders = $data['orders'] ?? [];
    $newId = count($orders) + 1;
    
    $orderId = $input['order_id'] ?? 'ORD-' . date('Ymd') . '-' . rand(100, 999);
    
    $productsList = $input['products_list'] ?? [];
    $productDetail = '';
    $totalQty = 0;
    $totalPrice = 0;
    
    if (!empty($productsList)) {
        $items = [];
        foreach ($productsList as $item) {
            $items[] = $item['name'] . ' x' . $item['qty'] . ' (' . $item['weight'] . ')';
            $totalQty += $item['qty'];
            $totalPrice += $item['subtotal'];
        }
        $productDetail = implode(', ', $items);
    } else {
        $productDetail = $input['products'] ?? '';
        $totalQty = intval($input['qty'] ?? 1);
        $totalPrice = intval($input['total'] ?? 0);
    }
    
    $newOrder = [
        'id' => $newId,
        'order_id' => $orderId,
        'customer' => $input['customer'] ?? '',
        'phone' => $input['phone'] ?? '',
        'address' => $input['address'] ?? '',
        'product' => $productDetail,
        'qty' => $totalQty,
        'total' => $totalPrice,
        'payment' => $input['payment'] ?? 'Transfer Bank',
        'status' => 'New',
        'date' => date('Y-m-d'),
        'latitude' => $input['latitude'] ?? '',
        'longitude' => $input['longitude'] ?? '',
        'notes' => $input['notes'] ?? ''
    ];
    
    $data['orders'][] = $newOrder;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
    
    echo json_encode([
        'status' => 'success', 
        'order_id' => $newOrder['id'],
        'tracking_link' => '/tracking.php?id=' . $newOrder['id']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}
