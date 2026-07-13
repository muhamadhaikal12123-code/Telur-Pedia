<?php
// Load data
$dataFile = __DIR__ . '/data.json';
$data = [];
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
}
$products = $data['products'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout - Telur Pedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        * { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        body { background: #f1f5f9; color: #0f172a; }
        .dark body { background: #0f172a; color: #f1f5f9; }
        
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
        
        .product-select-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px;
            border: 2px solid #e2e8f0;
            transition: 0.3s;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dark .product-select-card { background: #1e293b; border: 2px solid #334155; }
        .product-select-card:hover { border-color: #f59e0b; }
        .product-select-card.selected { border-color: #f59e0b; background: #fef3c7; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15); }
        .dark .product-select-card.selected { background: #1e293b; border-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2); }
        .product-select-card .emoji { font-size: 28px; flex-shrink: 0; }
        .product-select-card .info h4 { font-weight: 700; font-size: 14px; color: #0f172a; }
        .dark .product-select-card .info h4 { color: #f1f5f9; }
        .product-select-card .info p { font-size: 12px; color: #64748b; }
        .dark .product-select-card .info p { color: #94a3b8; }
        .product-select-card .qty-control { display: flex; align-items: center; gap: 8px; margin-left: auto; }
        .product-select-card .qty-control button {
            width: 28px; height: 28px; border-radius: 50%; border: 2px solid #e2e8f0;
            background: transparent; cursor: pointer; font-weight: 700; font-size: 14px;
            transition: 0.3s; display: flex; align-items: center; justify-content: center;
        }
        .product-select-card .qty-control button:hover { border-color: #f59e0b; background: #fef3c7; }
        .dark .product-select-card .qty-control button { border-color: #334155; color: #e2e8f0; }
        .dark .product-select-card .qty-control button:hover { border-color: #f59e0b; background: #1e293b; }
        .product-select-card .qty-control .qty-num { font-weight: 700; font-size: 16px; min-width: 24px; text-align: center; color: #0f172a; }
        .dark .product-select-card .qty-control .qty-num { color: #f1f5f9; }
        .product-select-card .price-tag { font-weight: 700; font-size: 14px; color: #f59e0b; margin-left: 8px; }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: 0.3s;
            background: #ffffff;
            color: #0f172a;
        }
        .dark .form-input { background: #0f172a; color: #f1f5f9; border-color: #334155; }
        .form-input:focus { outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15); }
        .form-input.error { border-color: #ef4444; }
        .form-input::placeholder { color: #94a3b8; }
        .dark .form-input::placeholder { color: #64748b; }
        
        .form-label { display: block; font-weight: 600; font-size: 13px; color: #0f172a !important; margin-bottom: 4px; }
        .dark .form-label { color: #f1f5f9 !important; }
        
        .btn-pay {
            background: #f59e0b;
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            text-decoration: none;
            transition: 0.3s;
            width: 100%;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
        }
        .btn-pay:hover { background: #d97706; transform: translateY(-2px); }
        .btn-pay:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
        
        .order-summary {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 16px 20px;
        }
        .dark .order-summary { background: #0f172a; }
        .order-summary .text-gray-600 { color: #475569 !important; }
        .dark .order-summary .text-gray-600 { color: #94a3b8 !important; }
        .order-summary .text-gray-800 { color: #0f172a !important; }
        .dark .order-summary .text-gray-800 { color: #f1f5f9 !important; }
        
        .error-msg { color: #ef4444; font-size: 12px; margin-top: 4px; display: none; }
        .error-msg.show { display: block; }
        
        .step-label { display: inline-flex; align-items: center; gap: 8px; font-weight: 700; font-size: 15px; color: #0f172a !important; margin-bottom: 12px; }
        .dark .step-label { color: #f1f5f9 !important; }
        .step-number { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #f59e0b; color: white; font-weight: 700; font-size: 12px; flex-shrink: 0; }
        
        .title-checkout { color: #0f172a !important; }
        .dark .title-checkout { color: #f1f5f9 !important; }
        .subtitle-checkout { color: #475569 !important; }
        .dark .subtitle-checkout { color: #94a3b8 !important; }
        
        .footer-simple { background: #ffffff; padding: 16px 32px; border-top: 1px solid #e2e8f0; margin-top: 30px; }
        .dark .footer-simple { background: #0f172a; border-top: 1px solid #334155; }
        .footer-simple p { color: #475569 !important; }
        .dark .footer-simple p { color: #94a3b8 !important; }
        
        #map { height: 200px; border-radius: 12px; border: 2px solid #e2e8f0; }
        .dark #map { border-color: #334155; }
        .map-container { position: relative; }
        .map-container .map-tip { position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.7); color: white; padding: 4px 16px; border-radius: 50px; font-size: 11px; white-space: nowrap; }
        .btn-location { background: #f59e0b; color: white; padding: 8px 16px; border-radius: 10px; border: none; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-location:hover { background: #d97706; transform: translateY(-2px); }
        
        .card {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            border: 2px solid #e2e8f0;
        }
        .dark .card { background: #1e293b; border: 2px solid #334155; }
        
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: white;
            border-radius: 20px;
            padding: 32px;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: popIn 0.3s ease;
        }
        .dark .modal-box { background: #1e293b; }
        @keyframes popIn {
            0% { transform: scale(0.8) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .modal-box .icon { font-size: 56px; margin-bottom: 8px; }
        .modal-box h2 { font-weight: 800; font-size: 22px; color: #0f172a; }
        .dark .modal-box h2 { color: #f1f5f9; }
        .modal-box p { color: #64748b; font-size: 14px; }
        .dark .modal-box p { color: #94a3b8; }
        .modal-box .total-bayar { font-size: 28px; font-weight: 800; color: #f59e0b; }
        
        .payment-method-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            background: white;
        }
        .dark .payment-method-btn { background: #0f172a; border-color: #334155; }
        .payment-method-btn:hover { border-color: #f59e0b; background: #fef3c7; }
        .dark .payment-method-btn:hover { background: #1e293b; }
        .payment-method-btn.selected { border-color: #f59e0b; background: #fef3c7; }
        .dark .payment-method-btn.selected { background: #1e293b; }
        .payment-method-btn .pm-icon { font-size: 28px; width: 40px; text-align: center; }
        .payment-method-btn .pm-name { font-weight: 600; font-size: 14px; color: #0f172a; }
        .dark .payment-method-btn .pm-name { color: #f1f5f9; }
        .payment-method-btn .pm-desc { font-size: 12px; color: #64748b; }
        .dark .payment-method-btn .pm-desc { color: #94a3b8; }
        
        .btn-modal-pay {
            background: #f59e0b;
            color: white;
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
            font-size: 16px;
        }
        .btn-modal-pay:hover { background: #d97706; }
        .btn-modal-pay:disabled { opacity: 0.5; cursor: not-allowed; }
        
        .summary-item { color: #0f172a !important; }
        .dark .summary-item { color: #e2e8f0 !important; }
        .summary-total { color: #0f172a !important; }
        .dark .summary-total { color: #f1f5f9 !important; }
        
        .tracking-id-box {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 12px;
        }
        .dark .tracking-id-box { background: #0f172a; border: 1px solid #334155; }
        .tracking-id-box .label { font-size: 12px; color: #64748b; }
        .dark .tracking-id-box .label { color: #94a3b8; }
        .tracking-id-box .id { font-weight: 700; font-size: 16px; color: #0f172a; letter-spacing: 1px; }
        .dark .tracking-id-box .id { color: #f1f5f9; }
        .tracking-id-box .copy-btn {
            background: none;
            border: none;
            color: #f59e0b;
            cursor: pointer;
            font-size: 18px;
            padding: 4px 8px;
            border-radius: 6px;
            transition: 0.3s;
        }
        .tracking-id-box .copy-btn:hover { background: rgba(245, 158, 11, 0.1); }
        
        @media (max-width: 768px) {
            .header-simple { padding: 12px 16px; flex-direction: column; }
            .product-select-card { flex-wrap: wrap; }
            .product-select-card .qty-control { margin-left: 0; width: 100%; justify-content: flex-end; }
            .btn-pay { font-size: 16px; padding: 14px 24px; }
            #map { height: 150px; }
            .modal-box { padding: 24px; }
            .tracking-id-box { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

<!-- MODAL PEMBAYARAN -->
<div class="modal-overlay" id="paymentModal">
    <div class="modal-box">
        <div class="text-center">
            <div class="icon">💳</div>
            <h2>Konfirmasi Pembayaran</h2>
            <p class="mt-1">Pilih metode pembayaran</p>
            <div class="total-bayar mt-2" id="modalTotal">Rp 0</div>
        </div>
        
        <div class="mt-4 space-y-2">
            <button class="payment-method-btn selected" onclick="selectPaymentMethod(this, 'Transfer Bank')">
                <span class="pm-icon">🏦</span>
                <div class="text-left">
                    <div class="pm-name">Transfer Bank</div>
                    <div class="pm-desc">BCA / Mandiri / BNI / BRI</div>
                </div>
            </button>
            <button class="payment-method-btn" onclick="selectPaymentMethod(this, 'QRIS')">
                <span class="pm-icon">📱</span>
                <div class="text-left">
                    <div class="pm-name">QRIS</div>
                    <div class="pm-desc">Scan via Gopay / OVO / Dana</div>
                </div>
            </button>
            <button class="payment-method-btn" onclick="selectPaymentMethod(this, 'COD')">
                <span class="pm-icon">💵</span>
                <div class="text-left">
                    <div class="pm-name">COD (Bayar di Tempat)</div>
                    <div class="pm-desc">Bayar saat pesanan sampai</div>
                </div>
            </button>
        </div>
        
        <div class="flex gap-3 mt-4">
            <button onclick="closePaymentModal()" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-3 rounded-xl font-semibold hover:bg-gray-300 transition">
                Batal
            </button>
            <button onclick="processPayment()" class="flex-1 btn-modal-pay" id="modalPayBtn">
                <i class="fas fa-check"></i> Bayar Sekarang
            </button>
        </div>
    </div>
</div>

<!-- MODAL SUKSES -->
<div class="modal-overlay" id="successModal">
    <div class="modal-box">
        <div class="text-center">
            <div class="icon">✅</div>
            <h2>Pembayaran Berhasil!</h2>
            <p class="mt-2">Terima kasih telah berbelanja di Telur Pedia.</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pesanan Anda akan segera diproses.</p>
            
            <div class="order-id-box">
                <div class="label">📋 Nomor Pesanan</div>
                <div class="id" id="orderIdDisplay">#ORD-20260712-001</div>
            </div>
            
            <div class="flex gap-2 mt-4">
                <a href="/" class="flex-1 bg-[#f59e0b] text-white px-4 py-2 rounded-full font-bold hover:bg-[#d97706] transition text-sm text-center">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
            <p class="text-xs text-gray-400 mt-3">Simpan nomor pesanan untuk konfirmasi ke admin</p>
        </div>
    </div>
</div>

<!-- HEADER -->
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

<!-- CHECKOUT -->
<section class="py-8 max-w-5xl mx-auto px-4">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold title-checkout">🛒 Checkout</h1>
        <p class="text-sm subtitle-checkout mt-1">Pilih produk, metode bayar, dan tentukan lokasi</p>
    </div>

    <div class="grid md:grid-cols-5 gap-6">
        <div class="md:col-span-3">
            <form id="checkoutForm" onsubmit="return handleSubmit(event)">
                <!-- Step 1: Pilih Produk -->
                <div class="mb-6">
                    <div class="step-label">
                        <span class="step-number">1</span> Pilih Produk
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        <i class="fas fa-info-circle"></i> Klik produk untuk pilih, atur jumlah dengan tombol +/-
                    </div>
                    <div class="space-y-3" id="productList">
                        <?php if (empty($products)): ?>
                        <div class="text-center text-gray-500 py-4">Belum ada produk</div>
                        <?php else: ?>
                        <?php foreach ($products as $p): ?>
                        <div class="product-select-card" data-id="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>" data-name="<?= $p['name'] ?>" data-weight="<?= $p['weight'] ?>">
                            <span class="emoji">🥚</span>
                            <div class="info flex-1">
                                <h4><?= $p['name'] ?></h4>
                                <p><?= $p['desc'] ?? '' ?> • <?= $p['weight'] ?></p>
                            </div>
                            <span class="price-tag">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
                            <div class="qty-control">
                                <button type="button" onclick="changeQty(<?= $p['id'] ?>, -1)">−</button>
                                <span class="qty-num" id="qty-<?= $p['id'] ?>">0</span>
                                <button type="button" onclick="changeQty(<?= $p['id'] ?>, 1)">+</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="error-msg" id="productError">Silakan pilih minimal 1 produk</div>
                </div>

                <!-- Step 2: Data Diri + Lokasi -->
                <div class="mb-4">
                    <div class="step-label">
                        <span class="step-number">2</span> Data Diri & Lokasi
                    </div>
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="name" class="form-input" placeholder="Budi Santoso" />
                            <div class="error-msg" id="nameError">Nama wajib diisi</div>
                        </div>
                        <div>
                            <label class="form-label">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="tel" id="phone" class="form-input" placeholder="0812-3456-7890" />
                            <div class="error-msg" id="phoneError">Nomor WhatsApp wajib diisi</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea id="address" class="form-input" rows="2" placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan, Kota"></textarea>
                        <div class="error-msg" id="addressError">Alamat wajib diisi</div>
                    </div>
                    
                    <div class="mt-3">
                        <label class="form-label">Tandai Lokasi di Peta <span class="text-gray-400 text-xs">(klik peta untuk tandai)</span></label>
                        <div class="map-container">
                            <div id="map"></div>
                            <div class="map-tip">📍 Klik peta untuk tandai lokasi</div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button type="button" class="btn-location" onclick="getCurrentLocation()">
                                <i class="fas fa-location-dot"></i> Pakai Lokasi Saya
                            </button>
                            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center" id="locationStatus">Belum pilih lokasi</span>
                        </div>
                        <input type="hidden" id="latitude" value="" />
                        <input type="hidden" id="longitude" value="" />
                        <div class="error-msg" id="locationError">Silakan tandai lokasi di peta</div>
                    </div>
                </div>

                <!-- Step 3: Catatan -->
                <div class="mb-4">
                    <div class="step-label">
                        <span class="step-number">3</span> Catatan (Opsional)
                    </div>
                    <textarea id="notes" class="form-input" rows="2" placeholder="Contoh: Tolong kirim pagi hari / Telur jangan sampai pecah"></textarea>
                </div>

                <button type="submit" class="btn-pay" id="submitBtn">
                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                </button>
                <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-2">
                    <i class="fas fa-lock"></i> Pembayaran aman via sistem kami
                </p>
            </form>
        </div>

        <!-- RINGKASAN -->
        <div class="md:col-span-2">
            <div class="card sticky top-24" style="cursor: default;">
                <h3 class="font-bold text-base text-gray-800 dark:text-white mb-3">📋 Ringkasan Pesanan</h3>
                <div id="orderSummary">
                    <div class="order-summary space-y-1 text-sm">
                        <div id="selectedProductsList">
                            <div class="text-gray-400 dark:text-gray-500 text-center py-2">Belum ada produk dipilih</div>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                        <div class="flex justify-between text-base">
                            <span class="font-bold summary-total">Total</span>
                            <span class="font-bold text-[#f59e0b] text-xl" id="summaryTotal">Rp 0</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3 p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <p class="text-xs text-green-700 dark:text-green-300">
                        <i class="fas fa-shield-alt"></i> Data Anda aman
                    </p>
                </div>
                <a href="/" class="block text-center text-xs text-gray-500 dark:text-gray-400 hover:text-[#f59e0b] mt-3">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>

<div class="footer-simple">
    <div class="max-w-5xl mx-auto text-center text-xs">
        <p>&copy; <?= date('Y') ?> TelurPedia</p>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const products = <?= json_encode($products) ?>;
    let selectedProducts = {};
    let map, marker;
    let locationSelected = false;
    let selectedPaymentMethod = 'Transfer Bank';
    let currentTotal = 0;

    function changeQty(productId, delta) {
        const card = document.querySelector(`.product-select-card[data-id="${productId}"]`);
        if (!card) return;
        const currentQty = selectedProducts[productId] || 0;
        const newQty = Math.max(0, currentQty + delta);
        if (newQty === 0) {
            delete selectedProducts[productId];
            card.classList.remove('selected');
        } else {
            selectedProducts[productId] = newQty;
            card.classList.add('selected');
        }
        document.getElementById(`qty-${productId}`).textContent = newQty;
        document.getElementById('productError').classList.remove('show');
        updateSummary();
    }

    function updateSummary() {
        const list = document.getElementById('selectedProductsList');
        const totalEl = document.getElementById('summaryTotal');
        let total = 0;
        let items = [];
        let hasProduct = false;
        
        for (const [id, qty] of Object.entries(selectedProducts)) {
            if (qty > 0) {
                hasProduct = true;
                const p = products.find(p => p.id == id);
                if (p) {
                    const subtotal = p.price * qty;
                    total += subtotal;
                    items.push(`${p.name} x${qty} = Rp ${subtotal.toLocaleString('id-ID')}`);
                }
            }
        }
        
        if (hasProduct) {
            list.innerHTML = items.map(item => 
                `<div class="flex justify-between summary-item text-sm py-1 border-b border-gray-100 dark:border-gray-700">
                    <span>${item}</span>
                </div>`
            ).join('');
        } else {
            list.innerHTML = '<div class="text-gray-400 dark:text-gray-500 text-center py-2">Belum ada produk dipilih</div>';
        }
        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        currentTotal = total;
    }

    function initMap(lat = -6.2, lng = 106.8) {
        if (map) { map.setView([lat, lng], 13); return; }
        map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
        marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        marker.on('dragend', function(e) {
            const pos = marker.getLatLng();
            updateLocation(pos.lat, pos.lng);
        });
        map.on('click', function(e) {
            const pos = e.latlng;
            if (marker) { marker.setLatLng(pos); } 
            else { marker = L.marker(pos, { draggable: true }).addTo(map);
            marker.on('dragend', function(e) {
                const p = marker.getLatLng();
                updateLocation(p.lat, p.lng);
            }); }
            updateLocation(pos.lat, pos.lng);
        });
        setTimeout(() => map.invalidateSize(), 300);
    }

    function updateLocation(lat, lng) {
        locationSelected = true;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('locationStatus').textContent = `📍 Lokasi dipilih (${lat.toFixed(4)}, ${lng.toFixed(4)})`;
        document.getElementById('locationStatus').className = 'text-xs text-green-600 dark:text-green-400 flex items-center';
        document.getElementById('locationError').classList.remove('show');
    }

    function getCurrentLocation() {
        if (navigator.geolocation) {
            document.getElementById('locationStatus').textContent = '⏳ Mendapatkan lokasi...';
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    const lat = pos.coords.latitude, lng = pos.coords.longitude;
                    if (map) { map.setView([lat, lng], 15); if (marker) { marker.setLatLng([lat, lng]); } else { marker = L.marker([lat, lng], { draggable: true }).addTo(map); } updateLocation(lat, lng); } 
                    else { initMap(lat, lng); setTimeout(() => updateLocation(lat, lng), 500); }
                }, function() {
                    document.getElementById('locationStatus').textContent = '❌ Gagal, klik peta untuk tandai';
                    document.getElementById('locationStatus').className = 'text-xs text-red-500 flex items-center';
                }
            );
        } else { alert('Browser tidak support GPS. Klik peta untuk tandai lokasi.'); }
    }

    function selectPaymentMethod(el, method) {
        document.querySelectorAll('.payment-method-btn').forEach(b => b.classList.remove('selected'));
        el.classList.add('selected');
        selectedPaymentMethod = method;
    }

    function openPaymentModal() {
        if (currentTotal === 0) {
            alert('Silakan pilih produk terlebih dahulu!');
            return;
        }
        document.getElementById('modalTotal').textContent = 'Rp ' + currentTotal.toLocaleString('id-ID');
        document.getElementById('paymentModal').classList.add('active');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.remove('active');
        document.getElementById('modalPayBtn').disabled = false;
        document.getElementById('modalPayBtn').innerHTML = '<i class="fas fa-check"></i> Bayar Sekarang';
    }

    function processPayment() {
        const btn = document.getElementById('modalPayBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        
        let productsList = [];
        let totalQty = 0;
        let totalPrice = 0;
        
        for (const [id, qty] of Object.entries(selectedProducts)) {
            if (qty > 0) {
                const p = products.find(p => p.id == id);
                if (p) {
                    const subtotal = p.price * qty;
                    productsList.push({
                        name: p.name,
                        qty: qty,
                        weight: p.weight,
                        price: p.price,
                        subtotal: subtotal
                    });
                    totalQty += qty;
                    totalPrice += subtotal;
                }
            }
        }
        
        if (productsList.length === 0) {
            alert('Silakan pilih produk terlebih dahulu!');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Bayar Sekarang';
            return;
        }
        
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        const orderId = 'ORD-' + new Date().toISOString().slice(0,10).replace(/-/g,'') + '-' + String(Math.floor(Math.random() * 900) + 100);
        
        fetch('save_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                order_id: orderId,
                customer: document.getElementById('name').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                products_list: productsList,
                products: productsList.map(p => p.name + ' x' + p.qty).join(', '),
                qty: totalQty,
                total: totalPrice,
                payment: selectedPaymentMethod,
                date: new Date().toISOString().split('T')[0],
                latitude: document.getElementById('latitude').value,
                longitude: document.getElementById('longitude').value,
                notes: document.getElementById('notes').value || ''
            })
        })
        .then(res => res.json())
        .then(data => {
            closePaymentModal();
            document.getElementById('orderIdDisplay').textContent = '#' + data.order_id;
            document.getElementById('successModal').classList.add('active');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Bayar Sekarang';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Bayar Sekarang';
        });
    }

    function validateForm() {
        document.querySelectorAll('.error-msg').forEach(el => el.classList.remove('show'));
        document.querySelectorAll('.form-input').forEach(el => el.classList.remove('error'));
        let valid = true;
        
        const hasProduct = Object.values(selectedProducts).some(q => q > 0);
        if (!hasProduct) {
            document.getElementById('productError').classList.add('show');
            valid = false;
        }
        
        const name = document.getElementById('name').value.trim();
        if (!name) {
            document.getElementById('nameError').classList.add('show');
            document.getElementById('name').classList.add('error');
            valid = false;
        }
        
        const phone = document.getElementById('phone').value.trim();
        if (!phone) {
            document.getElementById('phoneError').classList.add('show');
            document.getElementById('phone').classList.add('error');
            valid = false;
        }
        
        const address = document.getElementById('address').value.trim();
        if (!address) {
            document.getElementById('addressError').classList.add('show');
            document.getElementById('address').classList.add('error');
            valid = false;
        }
        
        if (!locationSelected) {
            document.getElementById('locationError').classList.add('show');
            valid = false;
        }
        
        return valid;
    }

    function handleSubmit(e) {
        e.preventDefault();
        if (!validateForm()) {
            const firstError = document.querySelector('.error-msg.show');
            if (firstError) firstError.closest('div').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        openPaymentModal();
        return false;
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateSummary();
        setTimeout(() => {
            initMap();
            setTimeout(() => {
                if (marker) {
                    const pos = marker.getLatLng();
                    updateLocation(pos.lat, pos.lng);
                }
            }, 500);
        }, 500);
    });
</script>

</body>
</html>
