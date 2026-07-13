<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$dataFile = __DIR__ . '/../data.json';
$data = json_decode(file_get_contents($dataFile), true);

$products = $data['products'] ?? [];
$orders = $data['orders'] ?? [];
$users = $data['users'] ?? [];

$totalOrders = count($orders);
$totalProducts = count($products);
$totalRevenue = array_sum(array_column($orders, 'total'));
$pendingOrders = count(array_filter($orders, fn($o) => $o['status'] == 'New' || $o['status'] == 'Process'));
$lowStock = count(array_filter($products, fn($p) => $p['stock'] < 20));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Telur Pedia Admin</title>
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
        .stat-card { background: white; border-radius: 16px; padding: 20px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .stat-card .number { font-size: 28px; font-weight: 800; color: #0f172a; }
        .stat-card .label { font-size: 14px; color: #64748b; }
        .stat-card .icon { font-size: 28px; }
        .btn-logout { color: #94a3b8 !important; margin-top: 20px; border-top: 1px solid #1e293b; padding-top: 16px; }
        .btn-logout:hover { color: #ef4444 !important; }
        .hamburger { display: none; background: none; border: none; color: #0f172a; font-size: 24px; cursor: pointer; }
        .table-wrap { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow-x: auto; }
        .table-wrap table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .table-wrap th { text-align: left; padding: 12px 12px; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0; }
        .table-wrap td { padding: 12px 12px; border-bottom: 1px solid #e2e8f0; }
        .status-badge { padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
        .status-new { background: #dbeafe; color: #1d4ed8; }
        .status-process { background: #fef3c7; color: #b45309; }
        .status-done { background: #d1fae5; color: #065f46; }
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
    <a href="dashboard.php" class="active"><i class="fas fa-th-large"></i> Dashboard</a>
    <a href="products.php"><i class="fas fa-box"></i> Products</a>
    <a href="orders.php"><i class="fas fa-shopping-bag"></i> Orders</a>
    <a href="users.php"><i class="fas fa-users"></i> Users</a>
    <div class="menu-label" style="margin-top:16px;">Settings</div>
    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <button class="hamburger" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-sm text-gray-500">Welcome back, Admin!</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-500"><?= date('d M Y H:i') ?></span>
            <a href="logout.php" class="text-sm text-red-500 hover:underline"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="grid md:grid-cols-5 gap-4 mb-6">
        <div class="stat-card">
            <div class="flex justify-between items-center">
                <div>
                    <div class="number"><?= $totalOrders ?></div>
                    <div class="label">Total Orders</div>
                </div>
                <div class="icon text-[#f59e0b]"><i class="fas fa-shopping-bag"></i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex justify-between items-center">
                <div>
                    <div class="number"><?= $totalProducts ?></div>
                    <div class="label">Total Products</div>
                </div>
                <div class="icon text-blue-500"><i class="fas fa-box"></i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex justify-between items-center">
                <div>
                    <div class="number">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></div>
                    <div class="label">Total Revenue</div>
                </div>
                <div class="icon text-green-500"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex justify-between items-center">
                <div>
                    <div class="number <?= $pendingOrders > 0 ? 'text-red-500' : '' ?>"><?= $pendingOrders ?></div>
                    <div class="label">Pending Orders</div>
                </div>
                <div class="icon text-red-500"><i class="fas fa-clock"></i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex justify-between items-center">
                <div>
                    <div class="number <?= $lowStock > 0 ? 'text-red-500' : '' ?>"><?= $lowStock ?></div>
                    <div class="label">Low Stock</div>
                </div>
                <div class="icon text-orange-500"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>

    <div class="table-wrap">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800">Recent Orders</h3>
            <a href="orders.php" class="text-[#f59e0b] text-sm hover:underline">View All</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                <tr><td colspan="7" class="text-center text-gray-500 py-4">Belum ada pesanan</td></tr>
                <?php else: ?>
                <?php foreach (array_slice($orders, -5, 5, true) as $o): ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><?= $o['customer'] ?></td>
                    <td><?= $o['product'] ?></td>
                    <td><?= $o['qty'] ?> kg</td>
                    <td>Rp <?= number_format($o['total'], 0, ',', '.') ?></td>
                    <td>
                        <span class="status-badge status-<?= strtolower($o['status']) ?>">
                            <?= $o['status'] ?>
                        </span>
                    </td>
                    <td><?= $o['date'] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
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
