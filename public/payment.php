<?php
session_start();

// Simulasi data pesanan (nanti ambil dari database)
$orderData = [
    'order_id' => 'ORDER-' . date('Ymd') . '-' . rand(100, 999),
    'amount' => 28000,
    'customer_name' => 'Budi Santoso',
    'customer_email' => 'budi@gmail.com',
    'customer_phone' => '081234567890',
    'product_name' => 'Telur Ayam Negeri'
];

// Konfigurasi Midtrans (Client Key bisa diisi nanti)
$clientKey = 'SB-Mid-client-xxxx'; // Ganti dengan client key dari Midtrans

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran - Telur Pedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; }
        .payment-box { background: white; border-radius: 20px; padding: 40px; max-width: 500px; margin: 40px auto; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .btn-pay { background: #f59e0b; color: white; padding: 14px 32px; border-radius: 12px; border: none; font-weight: 700; cursor: pointer; transition: 0.3s; width: 100%; font-size: 16px; }
        .btn-pay:hover { background: #d97706; transform: translateY(-2px); }
        .btn-pay:disabled { opacity: 0.5; cursor: not-allowed; }
        .method-card { display: flex; align-items: center; gap: 16px; padding: 16px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: 0.3s; }
        .method-card:hover { border-color: #f59e0b; }
        .method-card.selected { border-color: #f59e0b; background: #fef3c7; }
        .method-card .icon { font-size: 28px; width: 50px; text-align: center; }
        .method-card .name { font-weight: 600; }
        .method-card .desc { font-size: 12px; color: #64748b; }
        .dark .method-card { border-color: #334155; }
        .dark .method-card.selected { background: #1e293b; }
        .dark .method-card .desc { color: #94a3b8; }
    </style>
</head>
<body>

<div class="payment-box">
    <div class="text-center mb-6">
        <div class="text-5xl mb-2">💳</div>
        <h2 class="text-2xl font-bold text-gray-800">Pembayaran</h2>
        <p class="text-sm text-gray-500">Selesaikan pembayaran Anda</p>
    </div>

    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 mb-6">
        <div class="flex justify-between text-sm">
            <span class="text-gray-600 dark:text-gray-400">Pesanan</span>
            <span class="font-bold text-gray-800 dark:text-white"><?= $orderData['product_name'] ?></span>
        </div>
        <div class="flex justify-between text-sm mt-1">
            <span class="text-gray-600 dark:text-gray-400">Total</span>
            <span class="font-bold text-[#f59e0b] text-lg">Rp <?= number_format($orderData['amount'], 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Pilih Metode Pembayaran</label>
        <div class="space-y-2">
            <div class="method-card selected" onclick="selectMethod('bank_transfer')">
                <span class="icon">🏦</span>
                <div>
                    <div class="name">Transfer Bank</div>
                    <div class="desc">BCA / Mandiri / BNI / BRI</div>
                </div>
            </div>
            <div class="method-card" onclick="selectMethod('qris')">
                <span class="icon">📱</span>
                <div>
                    <div class="name">QRIS</div>
                    <div class="desc">Scan via Gopay / OVO / Dana</div>
                </div>
            </div>
            <div class="method-card" onclick="selectMethod('credit_card')">
                <span class="icon">💳</span>
                <div>
                    <div class="name">Kartu Kredit</div>
                    <div class="desc">Visa / Mastercard</div>
                </div>
            </div>
        </div>
    </div>

    <button class="btn-pay" id="payBtn" onclick="processPayment()">
        <i class="fas fa-lock"></i> Bayar Sekarang
    </button>

    <div class="text-center mt-4">
        <a href="/checkout.php" class="text-sm text-gray-500 hover:text-[#f59e0b]">
            <i class="fas fa-arrow-left"></i> Kembali ke Checkout
        </a>
    </div>

    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
        <p class="text-xs text-blue-700 dark:text-blue-300">
            <i class="fas fa-shield-alt"></i> Transaksi aman dengan Midtrans
        </p>
    </div>
</div>

<script>
    let selectedMethod = 'bank_transfer';

    function selectMethod(method) {
        selectedMethod = method;
        document.querySelectorAll('.method-card').forEach(el => el.classList.remove('selected'));
        document.querySelectorAll('.method-card').forEach(el => {
            if (el.textContent.includes(method.replace('_', ' ')) || 
                (method === 'bank_transfer' && el.textContent.includes('Transfer Bank')) ||
                (method === 'qris' && el.textContent.includes('QRIS')) ||
                (method === 'credit_card' && el.textContent.includes('Kartu Kredit'))) {
                el.classList.add('selected');
            }
        });
    }

    function processPayment() {
        const btn = document.getElementById('payBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

        // Simulasi redirect ke payment gateway
        setTimeout(() => {
            alert('✅ Pembayaran berhasil!\n\nMetode: ' + selectedMethod + 
                  '\nTotal: Rp <?= number_format($orderData['amount'], 0, ',', '.') ?>\n\nPesanan akan segera diproses.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock"></i> Bayar Sekarang';
            window.location.href = '/?payment=success';
        }, 2000);

        // Kalo mau integrasi Midtrans beneran, pake Snap API:
        // window.snap.pay(token, { onSuccess: function(result) { ... } });
    }
</script>

</body>
</html>
