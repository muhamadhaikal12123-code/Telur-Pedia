<?php
$dataFile = __DIR__ . '/data.json';
$data = json_decode(file_get_contents($dataFile), true);
$orders = $data['orders'] ?? [];

$orderId = isset($_GET['id']) ? $_GET['id'] : '';
$order = null;

// Cari order berdasarkan ID atau order_id
if ($orderId) {
    foreach ($orders as $o) {
        if ($o['id'] == $orderId || $o['order_id'] == $orderId) {
            $order = $o;
            break;
        }
    }
}

$statusColors = [
    'New' => 'text-blue-600 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300',
    'Process' => 'text-yellow-600 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-300',
    'Done' => 'text-green-600 bg-green-100 dark:bg-green-900/30 dark:text-green-300',
    'Cancel' => 'text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-300',
];

$statusSteps = [
    'New' => ['Pesanan dibuat', 'Menunggu konfirmasi'],
    'Process' => ['Pesanan dibuat', 'Pesanan diproses', 'Paket disiapkan'],
    'Done' => ['Pesanan dibuat', 'Pesanan diproses', 'Paket disiapkan', 'Paket dikirim', 'Paket sudah sampai 🎉'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lacak Pesanan - Telur Pedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; }
        .dark body { background: #0f172a; }
        .tracking-box { background: white; border-radius: 20px; padding: 32px; max-width: 600px; margin: 40px auto; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .dark .tracking-box { background: #1e293b; }
        .header-simple {
            background: #ffffff;
            padding: 16px 32px;
            border-bottom: 3px solid #f59e0b;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .dark .header-simple { background: #1e293b; border-bottom: 3px solid #f59e0b; }
        .header-simple .logo { font-size: 20px; font-weight: 800; color: #0f172a !important; display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .dark .header-simple .logo { color: #f1f5f9 !important; }
        .header-simple .logo span { color: #f59e0b !important; }
        .header-simple a { color: #0f172a !important; font-weight: 600; padding: 6px 14px; font-size: 13px; transition: 0.3s; text-decoration: none; border-radius: 8px; }
        .dark .header-simple a { color: #e2e8f0 !important; }
        .header-simple a:hover { color: #f59e0b !important; background: rgba(245, 158, 11, 0.1); }
        .header-right { display: flex; align-items: center; gap: 8px; }
        .form-input { width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; transition: 0.3s; background: #ffffff; color: #0f172a; }
        .dark .form-input { background: #0f172a; color: #f1f5f9; border-color: #334155; }
        .form-input:focus { outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15); }
        .btn-gold { background: #f59e0b; color: white; padding: 12px 24px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; }
        .btn-gold:hover { background: #d97706; transform: translateY(-2px); }
        .step-dot { width: 16px; height: 16px; border-radius: 50%; border: 3px solid #e2e8f0; flex-shrink: 0; }
        .dark .step-dot { border-color: #334155; }
        .step-dot.active { background: #f59e0b; border-color: #f59e0b; }
        .step-dot.done { background: #22c55e; border-color: #22c55e; }
        .step-line { width: 2px; background: #e2e8f0; flex-shrink: 0; }
        .dark .step-line { background: #334155; }
        .step-line.active { background: #f59e0b; }
        .step-line.done { background: #22c55e; }
        .footer-simple { background: #ffffff; padding: 16px 32px; border-top: 1px solid #e2e8f0; margin-top: 30px; }
        .dark .footer-simple { background: #0f172a; border-top: 1px solid #334155; }
        @media (max-width: 768px) {
            .header-simple { padding: 12px 16px; flex-direction: column; }
            .tracking-box { padding: 20px; margin: 20px 12px; }
        }
    </style>
</head>
<body>

<div class="header-simple">
    <a href="/" class="logo">
        <span>🥚</span> Telur<span>Pedia</span>
    </a>
    <div class="header-right">
        <a href="/">Beranda</a>
        <a href="#contact">Kontak</a>
        <button onclick="document.documentElement.classList.toggle('dark')" 
                style="background:none; border:none; font-size:18px; cursor:pointer; padding:6px 10px; border-radius:8px; color:#0f172a; transition:0.3s;">
            <i class="fas fa-moon dark:hidden"></i>
            <i class="fas fa-sun hidden dark:block text-yellow-400"></i>
        </button>
    </div>
</div>

<div class="tracking-box">
    <div class="text-center mb-6">
        <div class="text-5xl mb-2">📦</div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Lacak Pesanan</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan ID pesanan untuk cek status</p>
    </div>

    <form method="GET" class="flex gap-2 mb-6">
        <input type="text" name="id" placeholder="Masukkan ID Pesanan (contoh: 1)" 
               class="form-input" value="<?= htmlspecialchars($orderId) ?>" />
        <button type="submit" class="btn-gold"><i class="fas fa-search"></i> Cek</button>
    </form>

    <?php if ($orderId): ?>
        <?php if ($order): ?>
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white">#<?= $order['id'] ?> - <?= $order['order_id'] ?? 'ORD-' . $order['id'] ?></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Customer: <?= $order['customer'] ?></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Produk: <?= $order['product'] ?></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total: Rp <?= number_format($order['total'], 0, ',', '.') ?></p>
                </div>
                <span class="px-4 py-1 rounded-full text-sm font-semibold <?= $statusColors[$order['status']] ?? 'text-gray-600 bg-gray-100' ?>">
                    <?= $order['status'] ?>
                </span>
            </div>

            <!-- Progress Steps -->
            <div class="mt-4">
                <?php 
                $steps = $statusSteps[$order['status']] ?? ['Pesanan dibuat'];
                $currentStep = count($steps) - 1;
                ?>
                <?php foreach ($steps as $i => $step): ?>
                <div class="flex gap-4 items-start">
                    <div class="flex flex-col items-center">
                        <div class="step-dot <?= $i <= $currentStep ? 'done' : '' ?>"></div>
                        <?php if ($i < count($steps) - 1): ?>
                        <div class="step-line <?= $i < $currentStep ? 'done' : '' ?>" style="height: 30px;"></div>
                        <?php endif; ?>
                    </div>
                    <div class="pb-4">
                        <p class="font-medium text-gray-800 dark:text-white <?= $i <= $currentStep ? '' : 'text-gray-400 dark:text-gray-500' ?>">
                            <?= $step ?>
                            <?php if ($i == $currentStep && $order['status'] == 'Done'): ?>
                            <span class="text-green-500">✅</span>
                            <?php endif; ?>
                        </p>
                        <?php if ($i == 0): ?>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= $order['date'] ?? '-' ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if ($order['latitude'] && $order['longitude']): ?>
            <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <p class="text-xs text-blue-700 dark:text-blue-300">
                    <i class="fas fa-map-pin"></i> Lokasi: <?= $order['latitude'] ?>, <?= $order['longitude'] ?>
                    <a href="https://www.google.com/maps?q=<?= $order['latitude'] ?>,<?= $order['longitude'] ?>" target="_blank" class="text-[#f59e0b] hover:underline ml-2">
                        <i class="fas fa-external-link-alt"></i> Buka Maps
                    </a>
                </p>
            </div>
            <?php endif; ?>

            <?php if ($order['notes']): ?>
            <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <p class="text-xs text-gray-600 dark:text-gray-300">
                    <i class="fas fa-sticky-note"></i> Catatan: <?= $order['notes'] ?>
                </p>
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-8 text-red-500">
            <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
            <p>Pesanan dengan ID "<?= htmlspecialchars($orderId) ?>" tidak ditemukan</p>
            <p class="text-sm text-gray-400 mt-1">Pastikan ID pesanan benar</p>
        </div>
        <?php endif; ?>
    <?php else: ?>
    <div class="text-center py-8 text-gray-400 dark:text-gray-500">
        <i class="fas fa-search text-3xl mb-2"></i>
        <p>Masukkan ID pesanan untuk melacak</p>
    </div>
    <?php endif; ?>
</div>

<div class="footer-simple">
    <div class="max-w-5xl mx-auto text-center text-xs">
        <p>&copy; <?= date('Y') ?> TelurPedia</p>
    </div>
</div>

</body>
</html>
