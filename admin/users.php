<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$dataFile = __DIR__ . '/../data.json';
$data = json_decode(file_get_contents($dataFile), true);
$users = $data['users'] ?? [];
$msg = $_GET['msg'] ?? '';

if (isset($_GET['delete']) && $_GET['delete'] != $_SESSION['user']['id']) {
    $id = intval($_GET['delete']);
    $data['users'] = array_filter($data['users'], fn($u) => $u['id'] != $id);
    $data['users'] = array_values($data['users']);
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
    header('Location: users.php?msg=deleted');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Users - Telur Pedia Admin</title>
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
        .table-wrap { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow-x: auto; }
        .table-wrap table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .table-wrap th { text-align: left; padding: 12px 12px; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0; }
        .table-wrap td { padding: 12px 12px; border-bottom: 1px solid #e2e8f0; }
        .btn-add { background: #f59e0b; color: white; padding: 10px 24px; border-radius: 10px; border: none; font-weight: 600; cursor: pointer; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-add:hover { background: #d97706; transform: translateY(-2px); }
        .btn-delete { background: #fee2e2; color: #dc2626; padding: 4px 12px; border-radius: 6px; border: none; font-size: 12px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-delete:hover { background: #fecaca; }
        .btn-logout { color: #94a3b8 !important; margin-top: 20px; border-top: 1px solid #1e293b; padding-top: 16px; }
        .btn-logout:hover { color: #ef4444 !important; }
        .hamburger { display: none; background: none; border: none; color: #0f172a; font-size: 24px; cursor: pointer; }
        .role-badge { padding: 2px 10px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        .role-admin { background: #fef3c7; color: #b45309; }
        .role-staff { background: #dbeafe; color: #1d4ed8; }
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
    <a href="users.php" class="active"><i class="fas fa-users"></i> Users</a>
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
            <h1 class="text-2xl font-bold text-gray-800">Users</h1>
            <p class="text-sm text-gray-500">Manage admin users</p>
        </div>
        <a href="user_crud.php?action=add" class="btn-add">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>

    <?php if ($msg == 'added'): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> User berhasil ditambahkan!</div>
    <?php elseif ($msg == 'updated'): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> User berhasil diupdate!</div>
    <?php elseif ($msg == 'deleted'): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> User berhasil dihapus!</div>
    <?php endif; ?>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr><td colspan="5" class="text-center text-gray-500 py-4">Belum ada user</td></tr>
                <?php else: ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><strong><?= $u['name'] ?></strong></td>
                    <td><?= $u['username'] ?></td>
                    <td>
                        <span class="role-badge role-<?= $u['role'] ?>">
                            <?= ucfirst($u['role']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="user_crud.php?action=edit&id=<?= $u['id'] ?>" class="btn-edit" style="background:#dbeafe; color:#1d4ed8; padding:4px 12px; border-radius:6px; text-decoration:none; font-size:12px; display:inline-block;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <?php if ($u['id'] != $_SESSION['user']['id']): ?>
                        <a href="users.php?delete=<?= $u['id'] ?>" class="btn-delete" onclick="return confirm('Hapus user ini?')">
                            <i class="fas fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
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
