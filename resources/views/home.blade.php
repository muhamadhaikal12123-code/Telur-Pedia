<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Telur Pedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        body { background: #f8f6f0; transition: background 0.5s ease; }
        .dark body { background: #0f0f0f; color: #f0f0f0; }
        
        /* ===== TRANSISI DARK MODE ===== */
        .dark .bg-white { background: #1a1a1a; }
        .dark .bg-gray-50 { background: #0f0f0f; }
        .dark .bg-gray-100 { background: #1a1a1a; }
        .dark .border { border-color: #2a2a2a; }
        .dark .text-gray-800 { color: #f0f0f0; }
        .dark .text-gray-600 { color: #9ca3af; }
        .dark .text-gray-500 { color: #9ca3af; }
        .dark .text-gray-400 { color: #6b7280; }
        .dark .shadow { box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .dark .hover\:shadow-xl:hover { box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        
        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(16px);
            padding: 14px 32px;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 50;
            transition: all 0.3s ease;
        }
        .dark .navbar { background: rgba(15,15,15,0.92); border-bottom: 1px solid rgba(255,255,255,0.04); }
        .navbar a { color: #1a1a1a; font-weight: 500; transition: 0.3s; padding: 8px 18px; border-radius: 10px; font-size: 14px; }
        .dark .navbar a { color: #e5e7eb; }
        .navbar a:hover { color: #f59e0b; background: rgba(245,158,11,0.06); }
        .navbar .logo { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; transition: 0.3s; }
        .navbar .logo span { color: #f59e0b; }
        
        /* ===== SLIDE CAROUSEL ===== */
        .slide-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            height: 300px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        }
        .dark .slide-container { background: #1a1a1a; }
        .slide-wrapper {
            display: flex;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }
        .slide-item {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 20px;
            text-align: center;
        }
        .slide-item .emoji { font-size: 64px; display: block; margin-bottom: 12px; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .slide-item h3 { font-size: 24px; font-weight: 800; color: #1a1a1a; }
        .dark .slide-item h3 { color: #ffffff; }
        .slide-item p { color: #6b7280; font-size: 14px; margin-top: 4px; }
        .dark .slide-item p { color: #9ca3af; }
        
        .slide-dots {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }
        .slide-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #d1d5db;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        .slide-dot.active { background: #f59e0b; transform: scale(1.3); }
        .dark .slide-dot { background: #4b5563; }
        .dark .slide-dot.active { background: #f59e0b; }
        
        .slide-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.9);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            font-size: 14px;
            color: #1a1a1a;
        }
        .dark .slide-btn { background: rgba(40,40,40,0.9); color: #e5e7eb; }
        .slide-btn:hover { background: #f59e0b; color: #ffffff; transform: translateY(-50%) scale(1.05); }
        .slide-btn.prev { left: 8px; }
        .slide-btn.next { right: 8px; }
        
        /* ===== HERO ===== */
        .hero {
            background: #ffffff;
            padding: 60px 0 40px;
            border-bottom: 1px solid #f0ebe6;
            transition: background 0.5s ease;
        }
        .dark .hero { background: #121212; border-bottom: 1px solid #2a2a2a; }
        .hero h1 { font-size: 48px; font-weight: 900; color: #1a1a1a; line-height: 1.05; letter-spacing: -1.5px; }
        .dark .hero h1 { color: #ffffff; }
        .hero h1 span { color: #f59e0b; }
        .hero p { color: #4b5563; font-size: 18px; line-height: 1.7; }
        .dark .hero p { color: #9ca3af; }
        
        /* ===== BUTTONS ===== */
        .btn-primary {
            background: #f59e0b;
            color: #ffffff;
            padding: 14px 44px;
            border-radius: 60px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            box-shadow: 0 4px 20px rgba(245,158,11,0.25);
        }
        .btn-primary:hover { background: #d97706; transform: translateY(-2px) scale(1.02); box-shadow: 0 8px 30px rgba(245,158,11,0.35); }
        
        .btn-gold {
            background: #f59e0b;
            color: #ffffff;
            padding: 16px 48px;
            border-radius: 60px;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            box-shadow: 0 4px 24px rgba(245,158,11,0.25);
        }
        .btn-gold:hover { background: #d97706; transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 32px rgba(245,158,11,0.35); }
        
        /* ===== CARDS ===== */
        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 28px;
            border: 1px solid #f0ebe6;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(0,0,0,0.03);
        }
        .dark .card { background: #1a1a1a; border: 1px solid #2a2a2a; }
        .card:hover { transform: translateY(-8px) scale(1.01); border-color: #f59e0b; box-shadow: 0 12px 40px rgba(245,158,11,0.08); }
        .card h3 { color: #1a1a1a; font-weight: 700; font-size: 18px; transition: color 0.3s; }
        .dark .card h3 { color: #ffffff; }
        .card p { color: #4b5563; font-size: 14px; line-height: 1.6; }
        .dark .card p { color: #9ca3af; }
        
        .product-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #f0ebe6;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(0,0,0,0.03);
        }
        .dark .product-card { background: #1a1a1a; border: 1px solid #2a2a2a; }
        .product-card:hover { transform: translateY(-8px) scale(1.01); border-color: #f59e0b; box-shadow: 0 20px 40px rgba(245,158,11,0.08); }
        .product-card h3 { color: #1a1a1a; font-weight: 700; }
        .dark .product-card h3 { color: #ffffff; }
        .product-card p { color: #4b5563; }
        .dark .product-card p { color: #9ca3af; }
        
        /* ===== BADGE ===== */
        .badge-gold { background: #f59e0b; color: #ffffff; padding: 4px 16px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        .badge-green { background: #22c55e; color: #ffffff; padding: 4px 16px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        .badge-purple { background: #8b5cf6; color: #ffffff; padding: 4px 16px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        
        .price { font-size: 24px; font-weight: 800; color: #1a1a1a; transition: color 0.3s; }
        .dark .price { color: #f0e0b8; }
        
        /* ===== STOCK BAR ===== */
        .stock-bar { height: 4px; background: #e5e7eb; border-radius: 4px; overflow: hidden; }
        .dark .stock-bar { background: #2a2a2a; }
        .stock-bar .fill { height: 100%; background: #f59e0b; border-radius: 4px; transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* ===== SCROLL ANIMATION ===== */
        .scroll-animate {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .scroll-animate.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* ===== COUNTER ===== */
        .counter-number {
            font-size: 44px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -1px;
        }
        
        /* ===== FAQ ===== */
        .faq-item {
            border: 1px solid #f0ebe6;
            border-radius: 16px;
            padding: 16px 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .dark .faq-item { border-color: #2a2a2a; }
        .faq-item:hover { border-color: #f59e0b; box-shadow: 0 4px 16px rgba(245,158,11,0.04); }
        .faq-item .q { font-weight: 700; color: #1a1a1a; }
        .dark .faq-item .q { color: #ffffff; }
        .faq-item .a { color: #4b5563; font-size: 14px; line-height: 1.7; }
        .dark .faq-item .a { color: #9ca3af; }
        
        /* ===== PROMO BANNER ===== */
        .promo-banner {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 20px;
            padding: 48px 32px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(245,158,11,0.15);
            transition: transform 0.3s ease;
        }
        .promo-banner:hover { transform: scale(1.01); }
        
        /* ===== WHATSAPP ===== */
        .wa-float {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 999;
        }
        .wa-float a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            background: #25D366;
            border-radius: 50%;
            color: white;
            font-size: 28px;
            box-shadow: 0 8px 32px rgba(37,211,102,0.3);
            transition: all 0.3s ease;
        }
        .wa-float a:hover { transform: scale(1.08) rotate(-5deg); }
        
        /* ===== FOOTER ===== */
        .footer {
            background: #ffffff;
            padding: 48px 32px;
            border-top: 1px solid #f0ebe6;
            transition: background 0.5s ease;
        }
        .dark .footer { background: #121212; border-top: 1px solid #2a2a2a; }
        .footer a { color: #4b5563; transition: 0.3s; font-size: 14px; }
        .dark .footer a { color: #9ca3af; }
        .footer a:hover { color: #f59e0b; }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero h1 { font-size: 32px; }
            .navbar { padding: 12px 16px; }
            .navbar a { font-size: 12px; padding: 6px 10px; }
            .slide-container { height: 220px; }
            .slide-item .emoji { font-size: 44px; }
            .slide-item h3 { font-size: 18px; }
            .counter-number { font-size: 32px; }
            .promo-banner { padding: 32px 20px; }
            .btn-gold { padding: 14px 32px; font-size: 16px; }
        }
    </style>
</head>
<body>

<!-- WHATSAPP -->
<div class="wa-float">
    <a href="https://wa.me/6281234567890" target="_blank"><i class="fab fa-whatsapp"></i></a>
</div>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <a href="/" class="logo flex items-center gap-2">
            <span class="text-2xl">🥚</span>
            Telur<span>Pedia</span>
        </a>
        <div class="hidden md:flex gap-1">
            <a href="/">Beranda</a>
            <a href="#products">Produk</a>
            <a href="#blog">Blog</a>
            <a href="#testimonials">Testimoni</a>
            <a href="#faq">FAQ</a>
        </div>
        <div class="flex items-center gap-3">
            <a href="/admin" class="text-sm bg-[#f59e0b] text-white px-4 py-2 rounded-full font-bold hover:bg-[#d97706] transition">Admin</a>
            <button onclick="document.documentElement.classList.toggle('dark')" class="text-xl text-gray-600 dark:text-white p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:block text-yellow-400"></i>
            </button>
        </div>
    </div>
</nav>

<!-- ===== HERO WITH SLIDE ===== -->
<section class="hero">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div class="scroll-animate">
                <span class="bg-[#f59e0b] text-white px-4 py-1.5 rounded-full text-sm font-bold inline-block">✦ Telur Segar</span>
                <h1 class="mt-4">Telur Segar<br><span>Langsung dari Peternak</span></h1>
                <p class="mt-4">Dapatkan telur berkualitas premium dengan harga terbaik. Stok selalu terupdate real-time.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#products" class="btn-primary"><i class="fas fa-store"></i> Lihat Produk</a>
                    <a href="/checkout.php" class="border-2 border-[#f59e0b] text-[#f59e0b] px-6 py-3 rounded-full font-semibold hover:bg-[#f59e0b] hover:text-white transition">Pesan</a>
                </div>
                <div class="mt-6 flex flex-wrap gap-6 text-sm text-gray-500 dark:text-gray-400">
                    <span><i class="fas fa-check-circle text-[#f59e0b]"></i> 500+ Pelanggan</span>
                    <span><i class="fas fa-check-circle text-[#f59e0b]"></i> Stok Akurat</span>
                    <span><i class="fas fa-check-circle text-[#f59e0b]"></i> Pengiriman Cepat</span>
                </div>
            </div>
            <div class="scroll-animate">
                <div class="slide-container">
                    <div class="slide-wrapper" id="slideWrapper">
                        <div class="slide-item">
                            <span class="emoji">🥚</span>
                            <h3>Telur Segar Setiap Hari</h3>
                            <p>Dari peternak ke meja Anda</p>
                        </div>
                        <div class="slide-item">
                            <span class="emoji">🌟</span>
                            <h3>Kualitas Premium</h3>
                            <p>Nutrisi lengkap untuk keluarga</p>
                        </div>
                        <div class="slide-item">
                            <span class="emoji">🎉</span>
                            <h3>Promo Spesial!</h3>
                            <p>Diskon hingga 20%</p>
                        </div>
                    </div>
                    <button class="slide-btn prev" onclick="prevSlide()"><i class="fas fa-chevron-left"></i></button>
                    <button class="slide-btn next" onclick="nextSlide()"><i class="fas fa-chevron-right"></i></button>
                    <div class="slide-dots" id="slideDots">
                        <button class="slide-dot active" onclick="goToSlide(0)"></button>
                        <button class="slide-dot" onclick="goToSlide(1)"></button>
                        <button class="slide-dot" onclick="goToSlide(2)"></button>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <div class="inline-block bg-white dark:bg-gray-800 shadow-lg rounded-xl px-6 py-3 border-2 border-[#f59e0b]">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mulai</p>
                        <p class="text-2xl font-bold text-[#f59e0b]">Rp 28.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== KEUNGGULAN ===== -->
<section class="py-16 max-w-6xl mx-auto px-6">
    <div class="text-center mb-12">
        <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">✨ Keunggulan</span>
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">Kenapa <span class="text-[#f59e0b]">Telur Pedia?</span></h2>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Solusi terbaik untuk kebutuhan telur Anda</p>
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

<!-- ===== COUNTER ===== -->
<section class="py-12 bg-[#f59e0b]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 text-center">
            <div class="scroll-animate">
                <div class="counter-number" id="counter1" data-target="500">0</div>
                <p class="text-white/80 font-medium mt-1">Pelanggan Puas</p>
            </div>
            <div class="scroll-animate">
                <div class="counter-number" id="counter2" data-target="100">0</div>
                <p class="text-white/80 font-medium mt-1">% Stok Akurat</p>
            </div>
            <div class="scroll-animate">
                <div class="counter-number" id="counter3" data-target="24">0</div>
                <p class="text-white/80 font-medium mt-1">Jam Layanan</p>
            </div>
            <div class="scroll-animate">
                <div class="counter-number" id="counter4" data-target="6">0</div>
                <p class="text-white/80 font-medium mt-1">Varian Telur</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== PROMO ===== -->
<section class="max-w-6xl mx-auto px-6 py-8">
    <div class="promo-banner scroll-animate">
        <div class="text-6xl mb-3">🎉</div>
        <h2 class="text-3xl font-bold text-white">Promo Spesial!</h2>
        <p class="text-white/90 mt-2 text-lg">Beli 5 kg telur dapatkan 1 kg gratis + merchandise</p>
        <a href="#products" class="inline-block mt-4 bg-white text-[#f59e0b] px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition transform hover:scale-105">
            <i class="fas fa-gift"></i> Klaim Promo
        </a>
    </div>
</section>

<!-- ===== PRODUK ===== -->
<section id="products" class="py-16 bg-gray-50 dark:bg-[#0a0a0a]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">🥚 Katalog</span>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">Pilihan <span class="text-[#f59e0b]">Telur Terbaik</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Stok real-time, pesan sekarang!</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $products = [
                ['name' => 'Telur Ayam Negeri', 'price' => 28000, 'stock' => 150, 'desc' => 'Grade A, fresh from farm', 'badge' => 'Best Seller', 'tag' => 'Ayam', 'badgeClass' => 'badge-gold'],
                ['name' => 'Telur Ayam Kampung', 'price' => 35000, 'stock' => 75, 'desc' => 'Organik, premium quality', 'badge' => 'Organik', 'tag' => 'Ayam', 'badgeClass' => 'badge-green'],
                ['name' => 'Telur Puyuh', 'price' => 38000, 'stock' => 60, 'desc' => 'Mini, gurih, kaya protein', 'badge' => 'Premium', 'tag' => 'Puyuh', 'badgeClass' => 'badge-purple'],
            ];
            foreach ($products as $p):
                $stockPercent = min(($p['stock'] / 200) * 100, 100);
            ?>
            <div class="product-card scroll-animate">
                <div class="flex justify-between items-start mb-2">
                    <span class="<?= $p['badgeClass'] ?>"><?= $p['badge'] ?></span>
                    <span class="text-sm text-gray-400">⭐ 4.9</span>
                </div>
                <div class="text-6xl">🥚</div>
                <h3 class="text-xl mt-2"><?= $p['name'] ?></h3>
                <p><?= $p['desc'] ?></p>
                <div class="mt-3 flex gap-2">
                    <span class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-xs text-gray-700 dark:text-gray-300"><?= $p['tag'] ?></span>
                    <span class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-xs text-gray-700 dark:text-gray-300">1 kg</span>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <span class="price">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
                    <span class="text-sm text-gray-400">Stok: <?= $p['stock'] ?> kg</span>
                </div>
                <div class="stock-bar mt-2"><div class="fill" style="width: <?= $stockPercent ?>%"></div></div>
                <button class="mt-4 w-full bg-[#f59e0b] text-white py-3 rounded-full font-bold hover:bg-[#d97706] transition transform hover:scale-102" onclick="alert('Pesan: <?= $p['name'] ?>')">
                    <i class="fas fa-bolt"></i> Pesan Sekarang
                </button>
            </div>
            <?php endforeach; ?>
        </div>
        <!-- Tombol Checkout -->
        <div class="text-center mt-12">
            <a href="/checkout.php" class="btn-gold">
                <i class="fas fa-shopping-bag"></i> Sudah Tahu Mau Yang Mana? Pesan Sekarang!
            </a>
            <p class="text-sm text-gray-400 mt-3">Kamu akan diarahkan ke halaman checkout</p>
        </div>
    </div>
</section>

<!-- ===== BLOG ===== -->
<section id="blog" class="py-16 max-w-6xl mx-auto px-6">
    <div class="text-center mb-12">
        <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">📝 Blog</span>
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">Artikel <span class="text-[#f59e0b]">Seputar Telur</span></h2>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Informasi bermanfaat untuk kesehatan dan kuliner</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="card scroll-animate">
            <div class="flex justify-between items-center">
                <span class="text-4xl">💪</span>
                <span class="bg-[#f59e0b]/10 text-[#f59e0b] px-3 py-1 rounded-full text-xs font-semibold">Kesehatan</span>
            </div>
            <h3 class="text-lg mt-3">5 Manfaat Telur untuk Kesehatan</h3>
            <p>Telur sumber protein tinggi dengan berbagai nutrisi penting.</p>
            <div class="mt-3 flex justify-between text-xs text-gray-400">
                <span><i class="far fa-calendar"></i> 10 Jun 2026</span>
                <span><i class="far fa-clock"></i> 3 min</span>
            </div>
            <a href="#" class="text-[#f59e0b] font-semibold text-sm mt-3 inline-block hover:underline">Baca →</a>
        </div>
        <div class="card scroll-animate">
            <div class="flex justify-between items-center">
                <span class="text-4xl">🔍</span>
                <span class="bg-[#f59e0b]/10 text-[#f59e0b] px-3 py-1 rounded-full text-xs font-semibold">Tips</span>
            </div>
            <h3 class="text-lg mt-3">Cara Memilih Telur Segar</h3>
            <p>Tips memilih telur segar dari cangkang hingga uji apung.</p>
            <div class="mt-3 flex justify-between text-xs text-gray-400">
                <span><i class="far fa-calendar"></i> 8 Jun 2026</span>
                <span><i class="far fa-clock"></i> 4 min</span>
            </div>
            <a href="#" class="text-[#f59e0b] font-semibold text-sm mt-3 inline-block hover:underline">Baca →</a>
        </div>
        <div class="card scroll-animate">
            <div class="flex justify-between items-center">
                <span class="text-4xl">🍳</span>
                <span class="bg-[#f59e0b]/10 text-[#f59e0b] px-3 py-1 rounded-full text-xs font-semibold">Resep</span>
            </div>
            <h3 class="text-lg mt-3">Resep Olahan Telur Lezat</h3>
            <p>Resep telur sederhana hingga spesial untuk sehari-hari.</p>
            <div class="mt-3 flex justify-between text-xs text-gray-400">
                <span><i class="far fa-calendar"></i> 5 Jun 2026</span>
                <span><i class="far fa-clock"></i> 5 min</span>
            </div>
            <a href="#" class="text-[#f59e0b] font-semibold text-sm mt-3 inline-block hover:underline">Baca →</a>
        </div>
    </div>
</section>

<!-- ===== TESTIMONI ===== -->
<section id="testimonials" class="py-16 bg-gray-50 dark:bg-[#0a0a0a]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">⭐ Testimoni</span>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">Apa Kata <span class="text-[#f59e0b]">Pelanggan</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="card scroll-animate">
                <div class="text-[#f59e0b] text-lg">⭐⭐⭐⭐⭐</div>
                <p class="text-sm italic mt-3">"Telurnya segar sekali! Pengiriman cepat dan stok selalu akurat."</p>
                <p class="font-bold mt-3">Budi Santoso</p>
                <p class="text-xs text-gray-400">Jakarta</p>
            </div>
            <div class="card scroll-animate">
                <div class="text-[#f59e0b] text-lg">⭐⭐⭐⭐⭐</div>
                <p class="text-sm italic mt-3">"Kualitas telur sangat baik. Sistem stok real-time sangat membantu."</p>
                <p class="font-bold mt-3">Siti Rahayu</p>
                <p class="text-xs text-gray-400">Tangerang</p>
            </div>
            <div class="card scroll-animate">
                <div class="text-[#f59e0b] text-lg">⭐⭐⭐⭐</div>
                <p class="text-sm italic mt-3">"Harga bersahabat dan pelayanan ramah. Pilihan utama untuk kebutuhan telur."</p>
                <p class="font-bold mt-3">Andi Wijaya</p>
                <p class="text-xs text-gray-400">Bekasi</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section id="faq" class="py-16 max-w-4xl mx-auto px-6">
    <div class="text-center mb-12">
        <span class="text-[#f59e0b] font-semibold text-sm uppercase tracking-wider">❓ FAQ</span>
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">Pertanyaan <span class="text-[#f59e0b]">Umum</span></h2>
    </div>
    <div class="space-y-4">
        <div class="faq-item scroll-animate">
            <button class="faq-toggle w-full text-left flex justify-between items-center">
                <span class="q">Bagaimana cara memesan telur?</span>
                <i class="fas fa-chevron-down text-[#f59e0b] transition-transform"></i>
            </button>
            <div class="a mt-2 hidden">Pilih produk, klik "Pesan Sekarang", isi data di checkout, konfirmasi.</div>
        </div>
        <div class="faq-item scroll-animate">
            <button class="faq-toggle w-full text-left flex justify-between items-center">
                <span class="q">Apakah telur yang dijual fresh?</span>
                <i class="fas fa-chevron-down text-[#f59e0b] transition-transform"></i>
            </button>
            <div class="a mt-2 hidden">Ya, fresh langsung dari peternak terpercaya.</div>
        </div>
        <div class="faq-item scroll-animate">
            <button class="faq-toggle w-full text-left flex justify-between items-center">
                <span class="q">Bagaimana sistem stok real-time?</span>
                <i class="fas fa-chevron-down text-[#f59e0b] transition-transform"></i>
            </button>
            <div class="a mt-2 hidden">Stok otomatis berkurang setiap transaksi.</div>
        </div>
        <div class="faq-item scroll-animate">
            <button class="faq-toggle w-full text-left flex justify-between items-center">
                <span class="q">Ada garansi jika telur rusak?</span>
                <i class="fas fa-chevron-down text-[#f59e0b] transition-transform"></i>
            </button>
            <div class="a mt-2 hidden">Ya, garansi 100% uang kembali.</div>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-10">
        <div>
            <h4 class="text-xl font-bold text-gray-800 dark:text-white">🥚 Telur Pedia</h4>
            <p class="text-sm mt-2 text-gray-500 dark:text-gray-400">Sistem Inventori & Penjualan Telur Premium</p>
            <div class="flex gap-4 mt-4">
                <a href="#" class="text-gray-400 hover:text-[#f59e0b] transition text-lg"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-gray-400 hover:text-[#f59e0b] transition text-lg"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-gray-400 hover:text-[#f59e0b] transition text-lg"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div>
            <h5 class="font-semibold text-gray-800 dark:text-white mb-4">Produk</h5>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-[#f59e0b] transition">Telur Ayam Negeri</a></li>
                <li><a href="#" class="hover:text-[#f59e0b] transition">Telur Ayam Kampung</a></li>
                <li><a href="#" class="hover:text-[#f59e0b] transition">Telur Puyuh</a></li>
            </ul>
        </div>
        <div>
            <h5 class="font-semibold text-gray-800 dark:text-white mb-4">Informasi</h5>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-[#f59e0b] transition">Tentang Kami</a></li>
                <li><a href="/admin" class="hover:text-[#f59e0b] transition">Admin</a></li>
            </ul>
        </div>
        <div>
            <h5 class="font-semibold text-gray-800 dark:text-white mb-4">Kontak</h5>
            <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                <li><i class="fas fa-phone w-5"></i> 0812-3456-7890</li>
                <li><i class="fas fa-envelope w-5"></i> info@telurpedia.com</li>
                <li><i class="fas fa-map-marker-alt w-5"></i> Tangerang, Indonesia</li>
            </ul>
        </div>
    </div>
    <div class="max-w-6xl mx-auto mt-10 pt-6 border-t border-gray-200 dark:border-gray-800 text-center text-sm text-gray-400">
        © 2026 Telur Pedia. All rights reserved.
    </div>
</footer>

<script>
// ============================================================
// SLIDE CAROUSEL
// ============================================================
let currentSlide = 0;
const totalSlides = 3;

function goToSlide(index) {
    currentSlide = index;
    document.getElementById('slideWrapper').style.transform = `translateX(-${currentSlide * 100}%)`;
    document.querySelectorAll('.slide-dot').forEach((dot, i) => {
        dot.classList.toggle('active', i === currentSlide);
    });
}

function nextSlide() { goToSlide((currentSlide + 1) % totalSlides); }
function prevSlide() { goToSlide((currentSlide - 1 + totalSlides) % totalSlides); }

// Auto slide (berjalan terus)
let autoSlide = setInterval(nextSlide, 4000);

// Pause on hover
const slideContainer = document.querySelector('.slide-container');
slideContainer.addEventListener('mouseenter', () => clearInterval(autoSlide));
slideContainer.addEventListener('mouseleave', () => {
    autoSlide = setInterval(nextSlide, 4000);
});

// ============================================================
// SCROLL ANIMATION + COUNTER
// ============================================================
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            
            // Counter animation
            const counter = entry.target.querySelector('.counter-number');
            if (counter && !counter.dataset.animated) {
                counter.dataset.animated = true;
                const target = parseInt(counter.dataset.target) || parseInt(counter.textContent);
                let current = 0;
                const duration = 2000;
                const step = target / (duration / 16);
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 16);
            }
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.scroll-animate').forEach(el => observer.observe(el));

// ============================================================
// FAQ TOGGLE
// ============================================================
document.querySelectorAll('.faq-toggle').forEach(btn => {
    btn.addEventListener('click', function() {
        const answer = this.nextElementSibling;
        answer.classList.toggle('hidden');
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-chevron-down');
        icon.classList.toggle('fa-chevron-up');
    });
});

// ============================================================
// DARK MODE PREFERENCE
// ============================================================
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.classList.add('dark');
}
</script>
</body>
</html>
