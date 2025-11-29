<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShoesFresh | Feel The Street</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --orange-soft: #ffeadd;
            --orange-strong: #ff8f3f;
            --orange-dark: #d2601a;
            --text-dark: #1f1f1f;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #fff7f2;
            color: var(--text-dark);
        }
        a { color: inherit; text-decoration: none; }
        img { width: 100%; display: block; border-radius: 18px; }
        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }
        header {
            background: #fff;
            border-radius: 28px;
            padding: 26px 32px 50px;
            box-shadow: 0 30px 80px rgba(255, 143, 63, 0.15);
            margin-bottom: 36px;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 36px;
        }
        nav ul {
            display: flex;
            gap: 28px;
            list-style: none;
            font-weight: 500;
        }
        .hero {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 32px;
            align-items: center;
        }
        .hero h1 {
            font-size: clamp(36px, 5vw, 58px);
            line-height: 1.1;
            margin-bottom: 18px;
        }
        .hero p {
            color: #5f5f5f;
            margin-bottom: 26px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 999px;
            font-weight: 600;
            border: none;
        }
        .btn-primary {
            background: var(--orange-dark);
            color: #fff;
            box-shadow: 0 15px 30px rgba(210, 96, 26, 0.25);
        }
        .btn-ghost {
            background: transparent;
            color: var(--orange-dark);
        }
        .badge-row {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 36px;
        }
        .badge {
            padding: 10px 18px;
            border-radius: 999px;
            background: #fff2e6;
            font-size: 14px;
            font-weight: 500;
        }
        .section-title {
            margin: 32px 0 16px;
            font-size: 26px;
            font-weight: 600;
        }
        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
        }
        .category-card {
            background: #fff;
            border-radius: 20px;
            padding: 18px;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.05);
        }
        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 22px;
            margin-top: 12px;
        }
        .product-card {
            background: #fff;
            border-radius: 24px;
            padding: 18px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.05);
        }
        .product-info {
            margin-top: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .collection-split {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 26px;
            margin-top: 42px;
        }
        .collection-card {
            background: var(--orange-soft);
            border-radius: 30px;
            padding: 26px;
        }
        .brand-strip {
            display: flex;
            gap: 36px;
            flex-wrap: wrap;
            justify-content: center;
            margin: 40px 0;
            color: #c9c6c1;
            font-size: 18px;
            letter-spacing: 0.2em;
        }
        .cta {
            background: linear-gradient(135deg, #ffedd2, #ffd5b8);
            border-radius: 32px;
            padding: 40px;
            text-align: center;
        }
        footer {
            text-align: center;
            color: #8d8d8d;
            font-size: 14px;
            margin: 40px 0 20px;
        }
    </style>
</head>
<body>
<div class="page">
    <header>
        <nav>
            <div style="font-weight:700;font-size:22px;display:flex;align-items:center;gap:6px;">
                Shoes<span style="color:var(--orange-dark);">Fresh</span>
            </div>
            <ul>
                <li><a href="#new">Hàng mới</a></li>
                <li><a href="#collections">Bộ sưu tập</a></li>
                <li><a href="#sale">Sale</a></li>
                <li><a href="#stories">Câu chuyện</a></li>
            </ul>
            <a href="/login" class="btn btn-primary" style="padding:10px 20px;">Đăng nhập</a>
        </nav>
        <div class="hero">
            <div>
                <p style="letter-spacing:0.3em;color:#c17a4b;font-size:12px;">BỘ SƯU TẬP 2025</p>
                <h1>Sự tinh tế mới cho tủ giày mỗi ngày</h1>
                <p>Chất liệu nhẹ, bảng màu trung tính pha cam nhạt giúp outfit tối giản vẫn thu hút. Lấy cảm hứng từ các cửa hàng thời trang đường phố Nhật Bản.</p>
                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    <button class="btn btn-primary">Mua ngay</button>
                    <button class="btn btn-ghost">Bộ sưu tập xuân</button>
                </div>
                <div class="badge-row">
                    <span class="badge">Miễn phí đổi size 7 ngày</span>
                    <span class="badge">Freeship đơn từ 1.000.000đ</span>
                    <span class="badge">100+ cửa hàng toàn quốc</span>
                </div>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80" alt="Hero Sneaker">
            </div>
        </div>
    </header>

    <section id="new">
        <h2 class="section-title">Danh mục nổi bật</h2>
        <div class="categories">
            <div class="category-card">
                <p style="color:#b46c3c;font-weight:600;">City Walk</p>
                <h3 style="font-size:20px;">Giày lười nữ</h3>
                <small>Mềm mại, mix office đơn giản.</small>
            </div>
            <div class="category-card">
                <p style="color:#b46c3c;font-weight:600;">Street Active</p>
                <h3 style="font-size:20px;">Sneaker unisex</h3>
                <small>Đế cao su EVA êm thoáng.</small>
            </div>
            <div class="category-card">
                <p style="color:#b46c3c;font-weight:600;">Gentleman</p>
                <h3 style="font-size:20px;">Giày da tối giản</h3>
                <small>Da thật phối gam trắng - cam.</small>
            </div>
            <div class="category-card">
                <p style="color:#b46c3c;font-weight:600;">Kids Club</p>
                <h3 style="font-size:20px;">Kid sneaker</h3>
                <small>Đệm bọt bảo vệ bàn chân bé.</small>
            </div>
        </div>
    </section>

    <section id="collections">
        <h2 class="section-title">Sản phẩm được yêu thích</h2>
        <div class="featured-grid">
            @foreach ([
                ['name' => 'Canvas Aura', 'price' => '1.290.000đ', 'img' => 'https://images.unsplash.com/photo-1475180098004-ca77a66827be?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Orange Pulse', 'price' => '1.590.000đ', 'img' => 'https://images.unsplash.com/photo-1528701800489-20be3c18f80c?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Muse Runner', 'price' => '1.450.000đ', 'img' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Retro Court', 'price' => '1.790.000đ', 'img' => 'https://images.unsplash.com/photo-1484519332611-516457305ff6?auto=format&fit=crop&w=800&q=80']
            ] as $product)
                <div class="product-card">
                    <img src="{{ $product['img'] }}" alt="{{ $product['name'] }}">
                    <div class="product-info">
                        <div>
                            <p style="font-weight:600;">{{ $product['name'] }}</p>
                            <small style="color:#a1a1a1;">Màu trắng kem, form chuẩn</small>
                        </div>
                        <strong style="color:var(--orange-dark);">{{ $product['price'] }}</strong>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="collection-split" id="sale">
        <div class="collection-card">
            <p style="letter-spacing:0.4em;color:#c17a4b;font-size:11px;">MID YEAR DEAL</p>
            <h3 style="font-size:32px;margin:14px 0;">Sale 30% cho bộ sưu tập Lithe</h3>
            <p style="color:#6b6b6b;margin-bottom:18px;">Trải nghiệm upper knit breathable, cùng bảng màu cam nhạt - be rất dễ phối đồ.</p>
            <button class="btn btn-primary">Đặt lịch đo size</button>
        </div>
        <div class="collection-card" style="background:#fff;">
            <img src="https://images.unsplash.com/photo-1514986888952-8cd320577b68?auto=format&fit=crop&w=1000&q=80" alt="Collection">
        </div>
    </section>

    <div class="brand-strip" id="stories">
        <span>JUNO STYLE</span>
        <span>SHOESFRESH</span>
        <span>TOKYO WALK</span>
        <span>URBAN SOFT</span>
    </div>

    <section class="cta">
        <h3 style="font-size:30px;margin-bottom:10px;">Nhận ưu đãi theo sở thích</h3>
        <p style="color:#5e5e5e;margin-bottom:22px;">Đăng ký để được tư vấn outfit + ưu đãi độc quyền từ ShoesFresh.</p>
        <form style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;">
            <input type="email" placeholder="Email của bạn" required style="padding:12px 18px;border-radius:999px;border:none;min-width:260px;">
            <button class="btn btn-primary" type="submit">Đăng ký</button>
        </form>
    </section>

    <footer>
        © {{ date('Y') }} ShoesFresh. Made for mọi outfit thanh lịch.
    </footer>
</div>
</body>
</html>
