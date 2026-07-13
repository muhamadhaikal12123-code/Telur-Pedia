<?php
$products = [
    ['name' => 'Telur Ayam Negeri', 'price' => 28000, 'stock' => 150, 'desc' => 'Grade A, fresh from farm', 'badge' => 'Best Seller', 'tag' => 'Ayam', 'weight' => '1 kg'],
    ['name' => 'Telur Ayam Kampung', 'price' => 35000, 'stock' => 75, 'desc' => 'Organik, premium quality', 'badge' => 'Organik', 'tag' => 'Ayam', 'weight' => '1 kg'],
    ['name' => 'Telur Puyuh', 'price' => 38000, 'stock' => 60, 'desc' => 'Mini, gurih, kaya protein', 'badge' => 'Premium', 'tag' => 'Puyuh', 'weight' => '500 gr'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Telur Pedia - Toko Telur Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        body { background: #f8fafc; color: #0f172a; transition: background 0.3s, color 0.3s; }
        .dark body { background: #0f172a; color: #f1f5f9; }
        
        /* NAVBAR */
        .navbar {
            background: #ffffff;
            padding: 12px 32px;
            border-bottom: 3px solid #f59e0b;
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            transition: background 0.3s;
        }
        .dark .navbar { background: #1e293b; border-bottom: 3px solid #f59e0b; }
        .navbar .logo { font-size: 22px; font-weight: 800; color: #0f172a !important; display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .dark .navbar .logo { color: #f1f5f9 !important; }
        .navbar .logo span { color: #f59e0b !important; }
        .nav-center { display: flex; gap: 4px; align-items: center; flex-wrap: wrap; }
        .nav-right { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
        .navbar a { color: #0f172a !important; font-weight: 600; padding: 8px 16px; font-size: 14px; transition: 0.3s; text-decoration: none; border-radius: 8px; }
        .dark .navbar a { color: #e2e8f0 !important; }
        .navbar a:hover { color: #f59e0b !important; background: rgba(245, 158, 11, 0.1); }
        .navbar .dark-toggle { background: none; border: none; font-size: 20px; cursor: pointer; padding: 8px 12px; border-radius: 8px; color: #0f172a; transition: 0.3s; }
        .dark .navbar .dark-toggle { color: #e2e8f0; }
        .navbar .dark-toggle:hover { background: rgba(245, 158, 11, 0.1); }
        
        .hero {
            background: linear-gradient(135deg, #ffffff 0%, #fef9e7 100%);
            padding: 60px 0 40px;
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.3s;
        }
        .dark .hero { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-bottom: 1px solid #334155; }
        .hero h1 { font-size: 48px; font-weight: 900; color: #0f172a !important; line-height: 1.1; }
        .dark .hero h1 { color: #f1f5f9 !important; }
        .hero h1 span { color: #f59e0b !important; }
        .hero p { color: #334155 !important; font-size: 18px; }
        .dark .hero p { color: #94a3b8 !important; }
        
        /* HERO PRICE - PUTIH DENGAN BACKGROUND PUTIH */
        .hero-price-box {
            background: #ffffff;
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 12px 28px;
            display: inline-block;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .dark .hero-price-box { background: #1e293b; }
        .hero-price-box .label { 
            color: #0f172a !important; 
            font-size: 14px; 
            font-weight: 600;
        }
        .dark .hero-price-box .label { color: #94a3b8 !important; }
        .hero-price-box .price { 
            color: #f59e0b !important; 
            font-size: 28px; 
            font-weight: 800;
        }
        .dark .hero-price-box .price { color: #fbbf24 !important; }
        
        .btn-primary { background: #f59e0b; color: #ffffff; padding: 14px 40px; border-radius: 50px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; text-decoration: none; transition: 0.3s; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3); }
        .btn-primary:hover { background: #d97706; transform: translateY(-2px); }
        .btn-outline { border: 2px solid #f59e0b; color: #f59e0b; padding: 12px 36px; border-radius: 50px; font-weight: 600; background: transparent; display: inline-flex; align-items: center; gap: 10px; text-decoration: none; transition: 0.3s; }
        .btn-outline:hover { background: #f59e0b; color: #ffffff; transform: translateY(-2px); }
        .btn-gold { background: #f59e0b; color: #ffffff; padding: 16px 48px; border-radius: 50px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 12px; font-size: 18px; text-decoration: none; transition: 0.3s; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3); }
        .btn-gold:hover { background: #d97706; transform: translateY(-2px); }
        
        .card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            transition: 0.4s;
        }
        .dark .card { background: #1e293b; border: 1px solid #334155; }
        .card:hover { transform: translateY(-6px); border-color: #f59e0b; box-shadow: 0 8px 24px rgba(245, 158, 11, 0.12); }
        .card h3 { color: #0f172a !important; font-weight: 700; font-size: 18px; }
        .dark .card h3 { color: #f1f5f9 !important; }
        .card p { color: #334155 !important; font-size: 14px; }
        .dark .card p { color: #94a3b8 !important; }
        .card .text-gray-500, .card .text-gray-600, .card .text-gray-700 { color: #334155 !important; }
        .dark .card .text-gray-500, .dark .card .text-gray-600, .dark .card .text-gray-700 { color: #94a3b8 !important; }
        
        .price-text { font-size: 26px; font-weight: 800; color: #0f172a !important; }
        .dark .price-text { color: #fbbf24 !important; }
        
        .badge-gold { background: #f59e0b; color: #fff; padding: 4px 14px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        .badge-green { background: #22c55e; color: #fff; padding: 4px 14px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        .badge-purple { background: #8b5cf6; color: #fff; padding: 4px 14px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        
        .stock-bar { height: 4px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
        .dark .stock-bar { background: #334155; }
        .stock-bar .fill { height: 100%; background: #f59e0b; border-radius: 4px; transition: width 1.5s; }
        
        .tag-ayam { background: #fef3c7; color: #92400e; padding: 4px 14px; border-radius: 50px; font-size: 12px; font-weight: 600; }
        .tag-puyuh { background: #ede9fe; color: #5b21b6; padding: 4px 14px; border-radius: 50px; font-size: 12px; font-weight: 600; }
        .dark .tag-ayam { background: #78350f; color: #fbbf24; }
        .dark .tag-puyuh { background: #4c1d95; color: #a78bfa; }
        
        .weight-badge { background: #e2e8f0; color: #0f172a !important; padding: 4px 14px; border-radius: 50px; font-size: 12px; font-weight: 600; }
        .dark .weight-badge { background: #334155; color: #94a3b8 !important; }
        
        .promo-banner { background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 16px; padding: 40px 32px; text-align: center; }
        .counter-number { font-size: 40px; font-weight: 900; color: #ffffff; }
        
        .footer { background: #ffffff; padding: 40px 32px; border-top: 1px solid #e2e8f0; }
        .dark .footer { background: #0f172a; border-top: 1px solid #334155; }
        .footer a { color: #334155 !important; transition: 0.3s; font-size: 14px; text-decoration: none; }
        .dark .footer a { color: #94a3b8 !important; }
        .footer a:hover { color: #f59e0b !important; }
        .footer h4, .footer h5 { color: #0f172a !important; }
        .dark .footer h4, .dark .footer h5 { color: #f1f5f9 !important; }
        
        .wa-float { position: fixed; bottom: 28px; right: 28px; z-index: 999; }
        .wa-float a { display: flex; align-items: center; justify-content: center; width: 58px; height: 58px; background: #25D366; border-radius: 50%; color: white; font-size: 28px; transition: 0.3s; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.4); }
        .wa-float a:hover { transform: scale(1.1); }
        
        .faq-item { border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; transition: 0.3s; cursor: pointer; }
        .dark .faq-item { border-color: #334155; }
        .faq-item:hover { border-color: #f59e0b; }
        .faq-item .q { font-weight: 700; color: #0f172a !important; }
        .dark .faq-item .q { color: #f1f5f9 !important; }
        .faq-item .a { color: #334155 !important; font-size: 14px; }
        .dark .faq-item .a { color: #94a3b8 !important; }
        
        .contact-item { display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; transition: 0.4s; }
        .dark .contact-item { background: #1e293b; border: 1px solid #334155; }
        .contact-item:hover { background: #fef3c7; border-color: #f59e0b; transform: translateY(-4px); }
        .dark .contact-item:hover { background: #334155; }
        .contact-item .icon { font-size: 28px; color: #f59e0b; width: 48px; text-align: center; }
        .contact-item .label { color: #0f172a !important; font-weight: 600; }
        .dark .contact-item .label { color: #f1f5f9 !important; }
        .contact-item .value { color: #334155 !important; }
        .dark .contact-item .value { color: #94a3b8 !important; }
        
        .section-gray { background: #f8fafc; transition: background 0.3s; }
        .dark .section-gray { background: #0f172a; }
        .section-white { background: #ffffff; transition: background 0.3s; }
        .dark .section-white { background: #0f172a; }
        
        .scroll-animate { opacity: 0; transform: translateY(30px); transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1); }
        .scroll-animate.visible { opacity: 1; transform: translateY(0); }
        .animate-bounce { animation: bounce 2s infinite; }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        
        /* SECTION TITLE - GELAP DI LIGHT MODE */
        .section-title {
            color: #0f172a !important;
        }
        .dark .section-title {
            color: #f1f5f9 !important;
        }
        .section-subtitle {
            color: #334155 !important;
        }
        .dark .section-subtitle {
            color: #94a3b8 !important;
        }
        
        /* CONTACT INFO - PUTIH DENGAN BACKGROUND GELAP */
        .contact-info {
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 9999px;
            padding: 12px 24px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .dark .contact-info { background: #1e293b; }
        .contact-info .text { color: #ffffff !important; font-size: 14px; font-weight: 500; }
        
        .text-gray-800.dark\:text-white { color: #0f172a !important; }
        .dark .text-gray-800.dark\:text-white { color: #f1f5f9 !important; }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 32px; }
            .navbar { padding: 12px 16px; flex-direction: column; justify-content: center; }
            .nav-center { justify-content: center; }
            .nav-right { justify-content: center; }
            .navbar a { font-size: 12px; padding: 6px 10px; }
            .hero-price-box .price { font-size: 22px; }
            .hero-price-box { padding: 8px 20px; }
            .contact-info { padding: 8px 16px; flex-wrap: wrap; justify-content: center; }
            .contact-info .text { font-size: 12px; }
        }
    </style>
</head>
<body>

<div class="wa-float">
    <a href="https://wa.me/6281234567890" target="_blank"><i class="fab fa-whatsapp"></i></a>
</div>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="/" class="logo">
        <span class="text-2xl">🥚</span>
        Telur<span>Pedia</span>
    </a>
    <div class="nav-center">
        <a href="/">Beranda</a>
        <a href="#products">Produk</a>
        <a href="#testimonials">Testimoni</a>
        <a href="#faq">FAQ</a>
        <a href="#contact">Kontak</a>
    </div>
    <div class="nav-right">
        <button class="dark-toggle" onclick="document.documentElement.classList.toggle('dark')">
            <i class="fas fa-moon dark:hidden"></i>
            <i class="fas fa-sun hidden dark:block text-yellow-400"></i>
        </button>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="scroll-animate">
                <span class="bg-[#f59e0b] text-white px-4 py-1.5 rounded-full text-sm font-bold inline-block">✦ Telur Segar</span>
                <h1 class="mt-4">Telur Segar<br><span>Langsung dari Peternak</span></h1>
                <p class="mt-4">Dapatkan telur berkualitas premium dengan harga terbaik. Stok real-time.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#products" class="btn-primary"><i class="fas fa-store"></i> Lihat Produk</a>
                    <a href="/checkout.php" class="btn-outline"><i class="fas fa-shopping-bag"></i> Pesan</a>
                </div>
                <div class="mt-6 flex flex-wrap gap-6 text-sm">
                    <span class="text-gray-700 dark:text-gray-300"><i class="fas fa-check-circle text-[#f59e0b]"></i> 500+ Pelanggan</span>
                    <span class="text-gray-700 dark:text-gray-300"><i class="fas fa-check-circle text-[#f59e0b]"></i> Stok Akurat</span>
                    <span class="text-gray-700 dark:text-gray-300"><i class="fas fa-check-circle text-[#f59e0b]"></i> Cepat</span>
                </div>
            </div>
            <div class="scroll-animate text-center">
                <div class="text-9xl animate-bounce" style="color:#ffffff; text-shadow: 0 0 30px rgba(255,255,255,0.8), 0 0 60px rgba(255,255,255,0.4);">🥚</div>
                <!-- HERO PRICE - BACKGROUND PUTIH -->
                <div class="hero-price-box mt-4">
                    <div class="label">Mulai</div>
                    <div class="price">Rp 28.000</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KEUNGGULAN -->
<section class="section-white py-16 max-w-6xl mx-auto px-6">
    <div class="text-center mb-12">
        <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">✨ Keunggulan</span>
        <h2 class="text-3xl font-bold section-title mt-2">Kenapa <span class="text-[#f59e0b]">Telur Pedia?</span></h2>
        <p class="section-subtitle mt-2">Solusi terbaik untuk kebutuhan telur Anda</p>
    </div>
    <div class="grid md:grid-cols-4 gap-6">
        <div class="card text-center scroll-animate">
            <div class="text-5xl mb-3">🥚</div>
            <h3>Telur Segar</h3>
            <p>Langsung dari peternak</p>
        </div>
        <div class="card text-center scroll-animate">
            <div class="text-5xl mb-3">📊</div>
            <h3>Stok Akurat</h3>
            <p>Update real-time</p>
        </div>
        <div class="card text-center scroll-animate">
            <div class="text-5xl mb-3">🚚</div>
            <h3>Pengiriman Cepat</h3>
            <p>Tracking GPS</p>
        </div>
        <div class="card text-center scroll-animate">
            <div class="text-5xl mb-3">💯</div>
            <h3>Garansi 100%</h3>
            <p>Uang kembali</p>
        </div>
    </div>
</section>

<!-- COUNTER -->
<section class="py-12 bg-[#f59e0b]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 text-center">
            <div class="scroll-animate">
                <div class="counter-number" data-target="500">0</div>
                <p class="text-white/90 font-medium mt-1">Pelanggan Puas</p>
            </div>
            <div class="scroll-animate">
                <div class="counter-number" data-target="100">0</div>
                <p class="text-white/90 font-medium mt-1">% Stok Akurat</p>
            </div>
            <div class="scroll-animate">
                <div class="counter-number" data-target="24">0</div>
                <p class="text-white/90 font-medium mt-1">Jam Layanan</p>
            </div>
            <div class="scroll-animate">
                <div class="counter-number" data-target="3">0</div>
                <p class="text-white/90 font-medium mt-1">Varian Telur</p>
            </div>
        </div>
    </div>
</section>

<!-- PROMO -->
<section class="max-w-6xl mx-auto px-6 py-8">
    <div class="promo-banner scroll-animate">
        <div class="text-5xl mb-3">🎉</div>
        <h2 class="text-2xl font-bold text-white">Promo Spesial!</h2>
        <p class="text-white/90 mt-2">Beli 5 kg telur dapatkan 1 kg gratis</p>
        <a href="#products" class="inline-block mt-4 bg-white text-[#f59e0b] px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition shadow-lg"><i class="fas fa-gift"></i> Klaim</a>
    </div>
</section>

<!-- PRODUK -->
<section id="products" class="section-gray py-16">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">🥚 Katalog</span>
            <h2 class="text-3xl font-bold section-title mt-2">Pilihan <span class="text-[#f59e0b]">Telur Terbaik</span></h2>
            <p class="section-subtitle mt-2">Stok real-time, pesan sekarang!</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($products as $index => $p): 
                $stockPercent = min(($p['stock'] / 200) * 100, 100);
                $badgeClass = $p['badge'] == 'Best Seller' ? 'badge-gold' : ($p['badge'] == 'Organik' ? 'badge-green' : 'badge-purple');
                $tagClass = $p['tag'] == 'Ayam' ? 'tag-ayam' : 'tag-puyuh';
            ?>
            <div class="card scroll-animate">
                <div class="flex justify-between items-start mb-2">
                    <span class="<?= $badgeClass ?>"><?= $p['badge'] ?></span>
                    <span class="text-gray-700 dark:text-gray-300">⭐ 4.9</span>
                </div>
                <div class="text-5xl">🥚</div>
                <h3 class="text-xl mt-2 font-bold"><?= $p['name'] ?></h3>
                <p><?= $p['desc'] ?></p>
                <div class="mt-3 flex gap-2">
                    <span class="<?= $tagClass ?>"><?= $p['tag'] ?></span>
                    <span class="weight-badge"><?= $p['weight'] ?></span>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <span class="price-text">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
                    <span class="text-sm text-gray-700 dark:text-gray-300">Stok: <?= $p['stock'] ?> kg</span>
                </div>
                <div class="stock-bar mt-2"><div class="fill" style="width: <?= $stockPercent ?>%"></div></div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-12">
            <a href="/checkout.php" class="btn-gold">
                <i class="fas fa-shopping-bag"></i> Pesan Sekarang
            </a>
            <p class="text-sm section-subtitle mt-3">Kamu akan diarahkan ke halaman checkout</p>
        </div>
    </div>
</section>

<!-- TESTIMONI -->
<section id="testimonials" class="section-gray py-16">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">⭐ Testimoni</span>
            <h2 class="text-3xl font-bold section-title mt-2">Apa Kata <span class="text-[#f59e0b]">Pelanggan</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="card scroll-animate">
                <div class="text-[#f59e0b] text-lg">⭐⭐⭐⭐⭐</div>
                <p class="text-sm italic mt-3 text-gray-700 dark:text-gray-300">"Telurnya segar sekali! Pengiriman cepat."</p>
                <p class="font-bold mt-3 text-gray-800 dark:text-white">Budi Santoso</p>
                <p class="text-xs text-gray-700 dark:text-gray-300">Jakarta</p>
            </div>
            <div class="card scroll-animate">
                <div class="text-[#f59e0b] text-lg">⭐⭐⭐⭐⭐</div>
                <p class="text-sm italic mt-3 text-gray-700 dark:text-gray-300">"Kualitas telur sangat baik. Stok real-time."</p>
                <p class="font-bold mt-3 text-gray-800 dark:text-white">Siti Rahayu</p>
                <p class="text-xs text-gray-700 dark:text-gray-300">Tangerang</p>
            </div>
            <div class="card scroll-animate">
                <div class="text-[#f59e0b] text-lg">⭐⭐⭐⭐</div>
                <p class="text-sm italic mt-3 text-gray-700 dark:text-gray-300">"Harga bersahabat dan pelayanan ramah."</p>
                <p class="font-bold mt-3 text-gray-800 dark:text-white">Andi Wijaya</p>
                <p class="text-xs text-gray-700 dark:text-gray-300">Bekasi</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="section-white py-16 max-w-4xl mx-auto px-6">
    <div class="text-center mb-12">
        <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">❓ FAQ</span>
        <h2 class="text-3xl font-bold section-title mt-2">Pertanyaan <span class="text-[#f59e0b]">Umum</span></h2>
    </div>
    <div class="space-y-4">
        <div class="faq-item scroll-animate">
            <button class="faq-toggle w-full text-left flex justify-between items-center">
                <span class="q">Bagaimana cara memesan?</span>
                <i class="fas fa-chevron-down text-[#f59e0b]"></i>
            </button>
            <div class="a mt-2 hidden">Klik tombol "Pesan Sekarang" di bawah produk, isi data di halaman checkout, lalu kirim via WhatsApp.</div>
        </div>
        <div class="faq-item scroll-animate">
            <button class="faq-toggle w-full text-left flex justify-between items-center">
                <span class="q">Apakah telurnya fresh?</span>
                <i class="fas fa-chevron-down text-[#f59e0b]"></i>
            </button>
            <div class="a mt-2 hidden">Ya, fresh langsung dari peternak setiap hari.</div>
        </div>
        <div class="faq-item scroll-animate">
            <button class="faq-toggle w-full text-left flex justify-between items-center">
                <span class="q">Bagaimana cara lacak pesanan?</span>
                <i class="fas fa-chevron-down text-[#f59e0b]"></i>
            </button>
        </div>
        <div class="faq-item scroll-animate">
            <button class="faq-toggle w-full text-left flex justify-between items-center">
                <span class="q">Ada garansi jika telur rusak?</span>
                <i class="fas fa-chevron-down text-[#f59e0b]"></i>
            </button>
            <div class="a mt-2 hidden">Ya, garansi 100% uang kembali jika telur rusak.</div>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section-gray py-16">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">📞 Hubungi Kami</span>
            <h2 class="text-3xl font-bold section-title mt-2"><span class="text-[#f59e0b]">Contact Us</span></h2>
            <p class="section-subtitle mt-2">Ada pertanyaan? Hubungi kami melalui kontak di bawah ini</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="contact-item scroll-animate">
                <div class="icon"><i class="fas fa-phone"></i></div>
                <div>
                    <p class="label">Telepon</p>
                    <p class="value text-sm">0812-3456-7890</p>
                </div>
            </div>
            <div class="contact-item scroll-animate">
                <div class="icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <p class="label">Email</p>
                    <p class="value text-sm">info@telurpedia.com</p>
                </div>
            </div>
            <div class="contact-item scroll-animate">
                <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <p class="label">Alamat</p>
                    <p class="value text-sm">Tangerang, Indonesia</p>
                </div>
            </div>
        </div>
        <div class="mt-6 text-center scroll-animate">
            <!-- CONTACT INFO - PUTIH -->
            <div class="contact-info">
                <i class="fas fa-clock text-[#f59e0b] text-xl"></i>
                <span class="text">Senin - Minggu: 08.00 - 20.00</span>
                <i class="fas fa-phone text-[#f59e0b] text-xl ml-2"></i>
                <span class="text">0812-3456-7890</span>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <h4 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <span>🥚</span> Telur<span class="text-[#f59e0b]">Pedia</span>
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Toko telur premium terpercaya. Kualitas terbaik, harga bersahabat.</p>
                <div class="mt-4 flex gap-4">
                    <a href="#" class="text-gray-400 hover:text-[#f59e0b] transition"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-[#f59e0b] transition"><i class="fab fa-facebook text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-[#f59e0b] transition"><i class="fab fa-youtube text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-[#f59e0b] transition"><i class="fab fa-tiktok text-xl"></i></a>
                </div>
            </div>
            <div>
                <h5 class="font-semibold mb-4 text-gray-800 dark:text-white">Menu</h5>
                <div class="space-y-2">
                    <a href="/">Beranda</a><br />
                    <a href="#products">Produk</a><br />
                    <a href="#contact">Kontak</a>
                </div>
            </div>
            <div>
                <h5 class="font-semibold mb-4 text-gray-800 dark:text-white">Informasi</h5>
                <div class="space-y-2">
                    <a href="#">Cara Pesan</a><br />
                    <a href="#">Pengiriman</a><br />
                    <a href="#">Garansi</a><br />
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
            <div>
                <h5 class="font-semibold mb-4 text-gray-800 dark:text-white">Kontak</h5>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <p><i class="fas fa-phone text-[#f59e0b] w-5"></i> 0812-3456-7890</p>
                    <p><i class="fas fa-envelope text-[#f59e0b] w-5"></i> info@telurpedia.com</p>
                    <p><i class="fas fa-map-marker-alt text-[#f59e0b] w-5"></i> Tangerang, Indonesia</p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-6 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>&copy; <?= date('Y') ?> TelurPedia. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.scroll-animate').forEach(el => observer.observe(el));
    
    const counters = document.querySelectorAll('.counter-number');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.dataset.target);
                let current = 0;
                const increment = Math.ceil(target / 60);
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        entry.target.textContent = target;
                        clearInterval(timer);
                    } else {
                        entry.target.textContent = current;
                    }
                }, 30);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    counters.forEach(counter => counterObserver.observe(counter));
    
    document.querySelectorAll('.faq-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            answer.classList.toggle('hidden');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        });
    });
</script>

</body>
</html>
