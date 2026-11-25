<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="row g-4"><div class="col-md-5"><?php if ($produk['gambar']): ?><img class="img-fluid rounded" src="<?= esc($produk['gambar']) ?>" alt="<?= esc($produk['nama']) ?>"><?php else: ?><div class="bg-secondary-subtle rounded p-5 text-center">Tidak ada gambar</div><?php endif ?></div>
<div class="col-md-7"><h2><?= esc($produk['nama']) ?></h2><p><?= esc($produk['deskripsi']) ?></p><h3>Rp<?= number_format($produk['harga'], 0, ',', '.') ?></h3><p>Stok: <?= esc($produk['stok']) ?></p>
<form method="post" action="<?= site_url('keranjang/tambah/'.$produk['id']) ?>"><?= csrf_field() ?><button class="btn btn-primary">Tambah ke Keranjang</button> <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary">Kembali</a></form></div></div>
<?= $this->endSection() ?>
