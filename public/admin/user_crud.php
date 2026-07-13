<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$dataFile = __DIR__ . '/../data.json';
$data = json_decode(file_get_contents($dataFile), true);
$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'add') {
        $newUser = [
            'id' => count($data['users']) + 1,
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'role' => $_POST['role'],
            'name' => $_POST['name']
        ];
        $data['users'][] = $newUser;
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        header('Location: users.php?msg=added');
        exit;
    } elseif ($action == 'edit' && $id) {
        foreach ($data['users'] as &$u) {
            if ($u['id'] == $id) {
                $u['username'] = $_POST['username'];
                if (!empty($_POST['password'])) {
                    $u['password'] = $_POST['password'];
                }
                $u['role'] = $_POST['role'];
                $u['name'] = $_POST['name'];
                break;
            }
        }
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        header('Location: users.php?msg=updated');
        exit;
    }
}

$user = null;
if ($action == 'edit' && $id) {
    foreach ($data['users'] as $u) {
        if ($u['id'] == $id) { $user = $u; break; }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $action == 'add' ? 'Add' : 'Edit' ?> User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .form-box { background: white; border-radius: 20px; padding: 40px; width: 100%; max-width: 500px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .form-input { width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; transition: 0.3s; }
        .form-input:focus { outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.15); }
        .btn-gold { background: #f59e0b; color: white; padding: 12px 32px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; }
        .btn-gold:hover { background: #d97706; transform: translateY(-2px); }
        .btn-gray { background: #e2e8f0; color: #475569; padding: 12px 32px; border-radius: 12px; font-weight: 600; border: none; cursor: pointer; transition: 0.3s; text-decoration: none; }
        .btn-gray:hover { background: #cbd5e1; }
    </style>
</head>
<body>
<div class="form-box">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">
        <?= $action == 'add' ? '➕ Add User' : '✏️ Edit User' ?>
    </h2>
    <p class="text-sm text-gray-500 mb-6"><?= $action == 'add' ? 'Tambahkan user baru' : 'Ubah data user' ?></p>
    
    <form method="POST">
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
            <input type="text" name="name" class="form-input" value="<?= $user['name'] ?? '' ?>" required />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Username *</label>
            <input type="text" name="username" class="form-input" value="<?= $user['username'] ?? '' ?>" required />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password <?= $action == 'edit' ? '(kosongkan jika tidak diubah)' : '*' ?></label>
            <input type="password" name="password" class="form-input" <?= $action == 'add' ? 'required' : '' ?> />
        </div>
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Role *</label>
            <select name="role" class="form-input">
                <option value="admin" <?= ($user['role'] ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="staff" <?= ($user['role'] ?? '') == 'staff' ? 'selected' : '' ?>>Staff</option>
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-gold"><?= $action == 'add' ? 'Tambah' : 'Update' ?></button>
            <a href="users.php" class="btn-gray">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
