<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="mb-1">Belanja lebih mudah</h1><p class="text-muted mb-0">Temukan produk pilihan di TokoKita.</p></div></div>
<div class="row g-3">
<?php foreach ($produk as $p): ?><div class="col-sm-6 col-lg-4"><div class="card h-100 shadow-sm">
<?php if ($p['gambar']): ?><img src="<?= esc($p['gambar']) ?>" class="card-img-top" style="height:190px;object-fit:cover" alt="<?= esc($p['nama']) ?>"><?php else: ?><div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="height:190px">Tidak ada gambar</div><?php endif ?>
<div class="card-body d-flex flex-column"><small class="text-muted"><?= esc($p['nama_kategori'] ?? 'Produk') ?></small><h5><?= esc($p['nama']) ?></h5><p class="text-muted small flex-grow-1"><?= esc($p['deskripsi']) ?></p><strong class="fs-5">Rp<?= number_format($p['harga'], 0, ',', '.') ?></strong><div class="d-flex gap-2 mt-3"><a class="btn btn-outline-dark flex-fill" href="<?= site_url('produk/'.$p['id']) ?>">Detail</a><form method="post" action="<?= site_url('keranjang/tambah/'.$p['id']) ?>"><?= csrf_field() ?><button class="btn btn-primary">+ Keranjang</button></form></div></div></div></div><?php endforeach ?>
<?php if (!$produk): ?><div class="col-12"><div class="alert alert-info">Belum ada produk. Tambahkan produk melalui halaman Admin.</div></div><?php endif ?>
</div><?= $this->endSection() ?>
