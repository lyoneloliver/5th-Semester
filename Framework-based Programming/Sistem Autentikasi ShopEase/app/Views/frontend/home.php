<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ShopEase — Belanja Jadi Lebih Mudah</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--green:#176b4b;--ink:#17231f;--muted:#718078;--mint:#eaf4ed;--line:#e9eee9}
body{font-family:"DM Sans",sans-serif;color:var(--ink)}a{text-decoration:none}
.navbar{background:white;border-bottom:1px solid var(--line)}.brand{font-size:1.3rem;font-weight:800;color:var(--ink)}
.mark{background:var(--green);color:white;border-radius:11px;padding:6px 11px;margin-right:8px}
.nav-link{font-weight:600;color:#56645b}.nav-link:hover{color:var(--green)}
.btn-green{background:var(--green);color:white;border:0;border-radius:10px;padding:11px 18px;font-weight:700}.btn-green:hover{background:#10543a;color:white}
.btn-outline-green{border:1px solid #cbd9ce;color:var(--green);border-radius:10px;padding:10px 17px;font-weight:700}
.hero{background:#f8faf7;padding:68px 0}.tag{display:inline-block;background:#e7f2e9;color:var(--green);padding:7px 13px;border-radius:40px;font-size:.76rem;font-weight:800;text-transform:uppercase;letter-spacing:.7px}
h1{font-weight:800;font-size:clamp(2.6rem,5vw,4.4rem);letter-spacing:-2px;line-height:1.1;margin:20px 0}h1 span{color:var(--green)}
.muted{color:var(--muted);line-height:1.8}
.hero-visual{min-height:340px;border-radius:28px;background:linear-gradient(140deg,#dcecdf,#f3ead8);display:grid;place-items:center;position:relative;overflow:hidden}
.bag{width:170px;height:190px;background:var(--green);border-radius:18px 18px 30px 30px;display:grid;place-items:center;color:white;font-size:3rem;box-shadow:0 25px 45px #176b4b33;transform:rotate(-6deg)}
.bag:before{content:"";position:absolute;width:70px;height:45px;border:8px solid var(--green);border-bottom:0;border-radius:50px 50px 0 0;top:-33px}
.float{position:absolute;background:white;border-radius:13px;padding:12px 16px;box-shadow:0 10px 28px #20382a18;font-weight:700}.float small{display:block;color:var(--muted);font-weight:500}.f1{top:35px;left:20px}.f2{bottom:30px;right:18px}
.section{padding:70px 0}.kicker{font-size:.76rem;text-transform:uppercase;letter-spacing:1px;color:var(--green);font-weight:800}.section-title{font-size:2.25rem;font-weight:800;letter-spacing:-1px;margin:8px 0}
.category{border:1px solid var(--line);border-radius:15px;padding:16px;display:flex;gap:12px;align-items:center;color:var(--ink);height:100%;transition:.2s}.category:hover,.product:hover{transform:translateY(-3px);box-shadow:0 12px 28px #1737250c}
.cat-icon{background:var(--mint);color:var(--green);width:46px;height:46px;border-radius:13px;display:grid;place-items:center;font-size:1.25rem}
.product{border:1px solid var(--line);border-radius:16px;overflow:hidden;transition:.2s;height:100%}.product img,.placeholder{width:100%;height:190px;object-fit:cover;background:#f1f4f0}.placeholder{display:grid;place-items:center;color:#99a89e;font-size:2.4rem}.p-info{padding:15px}.p-name{font-weight:700;margin:6px 0}.price{font-weight:800;color:var(--green)}.small-muted{color:var(--muted);font-size:.8rem}
.features{background:var(--mint);border-radius:20px;padding:25px}.features p{color:#64746a;margin:5px 0 0}
footer{background:#14251d;color:#dce7df;padding:48px 0 22px}footer a,footer p{color:#afbeb4}footer a:hover{color:white}.foot-title{font-weight:700;color:white;margin-bottom:12px}
@media(max-width:767px){.hero{padding:45px 0}.hero-visual{margin-top:15px;min-height:280px}.section{padding:52px 0}h1{letter-spacing:-1.5px}}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
<div class="container py-2">
<a class="navbar-brand brand" href="<?= site_url('/') ?>"><span class="mark">S</span>ShopEase</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav mx-auto gap-lg-3"><li><a class="nav-link" href="#home">Beranda</a></li><li><a class="nav-link" href="#categories">Kategori</a></li><li><a class="nav-link" href="#products">Produk</a></li><li><a class="nav-link" href="#about">Tentang</a></li></ul>
<div class="d-flex gap-2 mt-3 mt-lg-0"><a href="<?= site_url('login') ?>" class="btn btn-outline-green">Masuk</a><a href="<?= site_url('register') ?>" class="btn btn-green">Daftar</a><a href="<?= site_url('cart') ?>" class="btn btn-outline-green">🛒</a></div>
</div></div></nav>
<section class="hero" id="home"><div class="container"><div class="row align-items-center g-5">
<div class="col-lg-6"><span class="tag">Belanja lebih mudah</span><h1>Temukan yang kamu suka, <span>tanpa ribet.</span></h1><p class="muted fs-5">Semua kebutuhan favoritmu ada di satu tempat. Jelajahi berbagai pilihan produk dan nikmati pengalaman belanja praktis bersama ShopEase.</p><div class="d-flex gap-3 flex-wrap mt-4"><a href="#products" class="btn btn-green">Mulai Belanja →</a><a href="#categories" class="btn btn-outline-green">Jelajahi Kategori</a></div><div class="d-flex gap-4 mt-5"><div><b class="fs-4">Mudah</b><div class="small-muted">Cari produk</div></div><div><b class="fs-4">Aman</b><div class="small-muted">Pesanan tercatat</div></div><div><b class="fs-4">Praktis</b><div class="small-muted">Pantau pesanan</div></div></div></div>
<div class="col-lg-6"><div class="hero-visual"><div class="float f1">Pilihan terbaik<small>Produk untukmu</small></div><div class="bag">S</div><div class="float f2">Happy shopping ✨<small>Mulai dari ShopEase</small></div></div></div>
</div></div></section>
<section class="section" id="categories"><div class="container"><div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4"><div><div class="kicker">Jelajahi pilihan</div><h2 class="section-title">Belanja berdasarkan kategori</h2><p class="muted mb-0">Temukan produk sesuai kebutuhanmu.</p></div><a href="<?= site_url('products') ?>" class="btn btn-outline-green">Semua produk →</a></div>
<div class="row g-3">
<?php $icons=['✦','⌚','♧','▣','◈','✿']; ?>
<?php if(!empty($categories)): foreach($categories as $i=>$category): ?>
<div class="col-6 col-md-4 col-lg-2"><a class="category" href="<?= site_url('products') ?>"><span class="cat-icon"><?= $icons[$i%count($icons)] ?></span><span><b><?= esc($category['name']) ?></b><small class="small-muted d-block">Lihat produk</small></span></a></div>
<?php endforeach; else: foreach(['Elektronik','Fashion','Rumah Tangga','Aksesoris','Kesehatan','Lainnya'] as $i=>$name): ?>
<div class="col-6 col-md-4 col-lg-2"><a class="category" href="<?= site_url('products') ?>"><span class="cat-icon"><?= $icons[$i] ?></span><span><b><?= esc($name) ?></b><small class="small-muted d-block">Kategori</small></span></a></div>
<?php endforeach; endif; ?>
</div></div></section>
<section class="section pt-0" id="products"><div class="container"><div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4"><div><div class="kicker">Pilihan untukmu</div><h2 class="section-title">Produk unggulan</h2><p class="muted mb-0">Produk pilihan yang siap menemani aktivitasmu.</p></div><form action="<?= site_url('products') ?>" method="get" class="d-flex gap-2"><input name="q" class="form-control" placeholder="Cari produk..."><button class="btn btn-green">Cari</button></form></div>
<div class="row g-4">
<?php if(!empty($products)): foreach($products as $product): ?>
<div class="col-6 col-md-4 col-lg-3"><article class="product">
<?php if(!empty($product['image'])): ?><img src="<?= base_url('uploads/products/'. $product['image']) ?>" alt="<?= esc($product['name']) ?>" loading="lazy"><?php else: ?><div class="placeholder">▧</div><?php endif; ?>
<div class="p-info"><div class="small-muted">ShopEase Collection</div><h3 class="p-name fs-6"><?= esc($product['name']) ?></h3><div class="price">Rp<?= number_format((float)$product['price'],0,',','.') ?></div><div class="d-flex justify-content-between align-items-center mt-2"><span class="small-muted">Stok <?= esc($product['stock']) ?></span><a class="btn btn-sm btn-outline-green" href="<?= site_url('products/'. $product['slug']) ?>">Detail</a></div></div>
</article></div>
<?php endforeach; else: ?>
<div class="col-12"><div class="alert alert-light text-center py-5">Produk belum tersedia. Admin dapat menambahkan produk melalui database pada tahap pengembangan berikutnya.</div></div>
<?php endif; ?>
</div></div></section>
<section class="container pb-5" id="about"><div class="features"><div class="row g-4"><div class="col-md-4"><b>✓ Belanja praktis</b><p>Jelajahi katalog dari satu halaman.</p></div><div class="col-md-4"><b>▤ Pesanan tercatat</b><p>Pantau proses pesanan melalui akunmu.</p></div><div class="col-md-4"><b>♡ Pengalaman nyaman</b><p>Tampilan sederhana dan mudah digunakan.</p></div></div></div></section>
<footer><div class="container"><div class="row g-4"><div class="col-lg-5"><a class="brand text-white" href="<?= site_url('/') ?>"><span class="mark">S</span>ShopEase</a><p class="mt-3">Tempat belanja online yang membuat pengalaman menemukan produk favorit jadi lebih mudah.</p></div><div class="col-6 col-lg-2"><div class="foot-title">Navigasi</div><div class="d-flex flex-column gap-2"><a href="#home">Beranda</a><a href="#categories">Kategori</a><a href="#products">Produk</a></div></div><div class="col-6 col-lg-2"><div class="foot-title">Akun</div><div class="d-flex flex-column gap-2"><a href="<?= site_url('login') ?>">Masuk</a><a href="<?= site_url('register') ?>">Daftar</a></div></div><div class="col-lg-3"><div class="foot-title">ShopEase</div><p>Belanja mudah, pilihan tepat.</p></div></div><hr class="border-secondary my-4"><div class="d-flex justify-content-between flex-wrap gap-2"><small>© <?= date('Y') ?> ShopEase</small><small>CodeIgniter 4 · Bootstrap 5</small></div></div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
