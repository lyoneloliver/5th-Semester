<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="card card-body text-center py-5"><h1 class="text-success">Pesanan berhasil dibuat!</h1><p>Terima kasih, <?= esc($pesanan['nama_pelanggan']) ?>.</p><p>Nomor pesanan: <strong>#<?= esc($pesanan['id']) ?></strong></p><p>Total: <strong>Rp<?= number_format($pesanan['total'],0,',','.') ?></strong></p><p>Status: <?= esc($pesanan['status']) ?></p><a class="btn btn-primary align-self-center" href="<?= site_url('/') ?>">Kembali belanja</a></div>
<?= $this->endSection() ?>
