<?php
$dataFile = __DIR__ . '/data.json';
$data = json_decode(file_get_contents($dataFile), true);
$orders = $data['orders'] ?? [];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$order = null;
foreach ($orders as $o) {
    if ($o['id'] == $id) { $order = $o; break; }
}

if (!$order) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Struk Pesanan #<?= $order['id'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * { font-family: 'Courier New', monospace; }
        body { background: #f1f5f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .struk { background: white; padding: 30px; max-width: 380px; width: 100%; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .line { border-top: 2px dashed #ccc; margin: 12px 0; }
        .center { text-align: center; }
        .bold { font-weight: 700; }
        @media print { body { background: white; } .struk { box-shadow: none; } .no-print { display: none; } }
    </style>
</head>
<body>
<div class="struk">
    <div class="center">
        <div class="text-3xl">🥚</div>
        <div class="text-xl font-bold">Telur Pedia</div>
        <div class="text-xs text-gray-500">Tangerang, Indonesia</div>
        <div class="text-xs text-gray-500">0812-3456-7890</div>
    </div>
    <div class="line"></div>
    <div class="text-xs">
        <div class="flex justify-between"><span>ID Pesanan</span><span class="bold">#<?= $order['id'] ?></span></div>
        <div class="flex justify-between"><span>Tanggal</span><span><?= $order['date'] ?></span></div>
        <div class="flex justify-between"><span>Status</span><span class="bold"><?= $order['status'] ?></span></div>
    </div>
    <div class="line"></div>
    <div class="text-xs">
        <div><span class="bold">Customer:</span> <?= $order['customer'] ?></div>
        <div><span class="bold">WA:</span> <?= $order['phone'] ?></div>
        <div><span class="bold">Alamat:</span> <?= $order['address'] ?></div>
    </div>
    <div class="line"></div>
    <div class="text-xs">
        <div class="flex justify-between"><span>Produk</span><span><?= $order['product'] ?></span></div>
        <div class="flex justify-between"><span>Jumlah</span><span><?= $order['qty'] ?> kg</span></div>
        <div class="flex justify-between"><span>Pembayaran</span><span><?= $order['payment'] ?? 'Transfer' ?></span></div>
    </div>
    <div class="line"></div>
    <div class="flex justify-between text-lg">
        <span class="bold">TOTAL</span>
        <span class="bold">Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
    </div>
    <div class="line"></div>
    <div class="center text-xs text-gray-500">
        <p>Terima kasih telah berbelanja! 🙏</p>
        <p class="mt-1">*Simpan struk ini sebagai bukti pesanan</p>
    </div>
    <div class="line"></div>
    <div class="center no-print">
        <button onclick="window.print()" class="bg-[#f59e0b] text-white px-6 py-2 rounded-lg font-bold hover:bg-[#d97706] transition">
            <i class="fas fa-print"></i> Cetak
        </button>
        <a href="/" class="block mt-2 text-xs text-gray-500 hover:text-[#f59e0b]">Kembali</a>
    </div>
</div>
</body>
</html>
