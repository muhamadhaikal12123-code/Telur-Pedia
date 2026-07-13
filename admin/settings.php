<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$dataFile = __DIR__ . '/../data.json';
$data = json_decode(file_get_contents($dataFile), true);
$settings = $data['settings'] ?? [];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data['settings'] = [
        'store_name' => $_POST['store_name'],
        'store_phone' => $_POST['store_phone'],
        'store_email' => $_POST['store_email'],
        'store_address' => $_POST['store_address'],
        'whatsapp_number' => $_POST['whatsapp_number']
    ];
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
    $msg = 'Settings berhasil diupdate!';
    $settings = $data['settings'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings - Telur Pedia Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; }
        .sidebar {
            width: 260px;
            background: #0f172a;
            min-height: 100vh;
            padding: 20px 16px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            transition: transform 0.3s;
            z-index: 100;
        }
        .sidebar .logo { color: white; font-size: 20px; font-weight: 800; padding: 8px 12px 20px; border-bottom: 1px solid #1e293b; margin-bottom: 16px; }
        .sidebar .logo span { color: #f59e0b; }
        .sidebar .menu-label { color: #64748b; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; padding: 12px 12px 6px; }
        .sidebar a { display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #94a3b8; text-decoration: none; border-radius: 10px; transition: 0.3s; font-size: 14px; font-weight: 500; }
        .sidebar a:hover { background: #1e293b; color: white; }
        .sidebar a.active { background: #f59e0b; color: white; }
        .sidebar a i { width: 20px; text-align: center; }
        .main-content { margin-left: 260px; padding: 24px 32px; }
        .form-box { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); max-width: 600px; }
        .form-input { width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; transition: 0.3s; }
        .form-input:focus { outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.15); }
        .btn-gold { background: #f59e0b; color: white; padding: 12px 32px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; }
        .btn-gold:hover { background: #d97706; transform: translateY(-2px); }
        .btn-logout { color: #94a3b8 !important; margin-top: 20px; border-top: 1px solid #1e293b; padding-top: 16px; }
        .btn-logout:hover { color: #ef4444 !important; }
        .hamburger { display: none; background: none; border: none; color: #0f172a; font-size: 24px; cursor: pointer; }
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; }
        .alert-success { background: #d1fae5; color: #065f46; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 16px; }
            .hamburger { display: block !important; }
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="logo">🥚 Telur<span>Pedia</span></div>
    <div class="menu-label">Menu</div>
    <a href="dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
    <a href="products.php"><i class="fas fa-box"></i> Products</a>
    <a href="orders.php"><i class="fas fa-shopping-bag"></i> Orders</a>
    <a href="users.php"><i class="fas fa-users"></i> Users</a>
    <div class="menu-label" style="margin-top:16px;">Settings</div>
    <a href="settings.php" class="active"><i class="fas fa-cog"></i> Settings</a>
    <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <button class="hamburger" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-2xl font-bold text-gray-800">Settings</h1>
            <p class="text-sm text-gray-500">Manage store settings</p>
        </div>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $msg ?></div>
    <?php endif; ?>

    <div class="form-box">
        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Toko *</label>
                <input type="text" name="store_name" class="form-input" value="<?= $settings['store_name'] ?? 'Telur Pedia' ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="store_phone" class="form-input" value="<?= $settings['store_phone'] ?? '0812-3456-7890' ?>" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="store_email" class="form-input" value="<?= $settings['store_email'] ?? 'info@telurpedia.com' ?>" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                <textarea name="store_address" class="form-input" rows="2"><?= $settings['store_address'] ?? 'Tangerang, Indonesia' ?></textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp (untuk pesanan) *</label>
                <input type="text" name="whatsapp_number" class="form-input" value="<?= $settings['whatsapp_number'] ?? '6281234567890' ?>" required />
                <p class="text-xs text-gray-500 mt-1">Gunakan format: 6281234567890 (tanpa + dan spasi)</p>
            </div>
            <button type="submit" class="btn-gold"><i class="fas fa-save"></i> Simpan Settings</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.querySelector('.hamburger');
        if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
            if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
</script>
</body>
</html>
