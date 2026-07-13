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
        $newProduct = [
            'id' => count($data['products']) + 1,
            'name' => $_POST['name'],
            'price' => intval($_POST['price']),
            'stock' => intval($_POST['stock']),
            'weight' => $_POST['weight'],
            'badge' => $_POST['badge'],
            'desc' => $_POST['desc'] ?? '',
            'tag' => $_POST['tag'] ?? 'Ayam'
        ];
        $data['products'][] = $newProduct;
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        header('Location: products.php?msg=added');
        exit;
    } elseif ($action == 'edit' && $id) {
        foreach ($data['products'] as &$p) {
            if ($p['id'] == $id) {
                $p['name'] = $_POST['name'];
                $p['price'] = intval($_POST['price']);
                $p['stock'] = intval($_POST['stock']);
                $p['weight'] = $_POST['weight'];
                $p['badge'] = $_POST['badge'];
                $p['desc'] = $_POST['desc'] ?? '';
                $p['tag'] = $_POST['tag'] ?? 'Ayam';
                break;
            }
        }
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        header('Location: products.php?msg=updated');
        exit;
    } elseif ($action == 'delete' && $id) {
        $data['products'] = array_filter($data['products'], fn($p) => $p['id'] != $id);
        $data['products'] = array_values($data['products']);
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        header('Location: products.php?msg=deleted');
        exit;
    }
}

$product = null;
if ($action == 'edit' && $id) {
    foreach ($data['products'] as $p) {
        if ($p['id'] == $id) { $product = $p; break; }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $action == 'add' ? 'Add' : ($action == 'edit' ? 'Edit' : 'Delete') ?> Product</title>
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
        <?= $action == 'add' ? '➕ Add Product' : ($action == 'edit' ? '✏️ Edit Product' : '🗑️ Delete Product') ?>
    </h2>
    <p class="text-sm text-gray-500 mb-6"><?= $action == 'add' ? 'Masukkan data produk baru' : ($action == 'edit' ? 'Ubah data produk' : 'Konfirmasi hapus produk') ?></p>
    
    <?php if ($action == 'delete'): ?>
        <p class="text-red-600 mb-4">Yakin hapus <strong><?= $product['name'] ?></strong>?</p>
        <form method="POST">
            <div class="flex gap-3">
                <button type="submit" class="btn-gold" style="background:#dc2626;">Ya, Hapus</button>
                <a href="products.php" class="btn-gray">Batal</a>
            </div>
        </form>
    <?php else: ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk *</label>
                <input type="text" name="name" class="form-input" value="<?= $product['name'] ?? '' ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp) *</label>
                <input type="number" name="price" class="form-input" value="<?= $product['price'] ?? '' ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Stok (kg) *</label>
                <input type="number" name="stock" class="form-input" value="<?= $product['stock'] ?? '' ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Berat *</label>
                <select name="weight" class="form-input">
                    <option value="1 kg" <?= ($product['weight'] ?? '') == '1 kg' ? 'selected' : '' ?>>1 kg</option>
                    <option value="500 gr" <?= ($product['weight'] ?? '') == '500 gr' ? 'selected' : '' ?>>500 gr</option>
                    <option value="250 gr" <?= ($product['weight'] ?? '') == '250 gr' ? 'selected' : '' ?>>250 gr</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Badge</label>
                <select name="badge" class="form-input">
                    <option value="Best Seller" <?= ($product['badge'] ?? '') == 'Best Seller' ? 'selected' : '' ?>>Best Seller</option>
                    <option value="Organik" <?= ($product['badge'] ?? '') == 'Organik' ? 'selected' : '' ?>>Organik</option>
                    <option value="Premium" <?= ($product['badge'] ?? '') == 'Premium' ? 'selected' : '' ?>>Premium</option>
                    <option value="New" <?= ($product['badge'] ?? '') == 'New' ? 'selected' : '' ?>>New</option>
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tag</label>
                <select name="tag" class="form-input">
                    <option value="Ayam" <?= ($product['tag'] ?? '') == 'Ayam' ? 'selected' : '' ?>>Ayam</option>
                    <option value="Puyuh" <?= ($product['tag'] ?? '') == 'Puyuh' ? 'selected' : '' ?>>Puyuh</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-gold"><?= $action == 'add' ? 'Tambah' : 'Update' ?></button>
                <a href="products.php" class="btn-gray">Batal</a>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
