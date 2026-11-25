<?= $this->extend('layout') ?><?= $this->section('content') ?>
<h2 class="mb-3">Admin - Kelola Produk</h2>
<form method="post" action="<?= site_url('admin/produk/simpan') ?>" class="card card-body mb-4"><?= csrf_field() ?>
<div class="row g-2"><div class="col-md-4"><input class="form-control" name="nama" placeholder="Nama produk" required></div>
<div class="col-md-3"><select class="form-select" name="kategori_id" required><option value="">Pilih kategori</option><?php foreach ($kategori as $k): ?><option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option><?php endforeach ?></select></div>
<div class="col-md-2"><input class="form-control" type="number" name="harga" min="1" placeholder="Harga" required></div>
<div class="col-md-1"><input class="form-control" type="number" name="stok" min="0" placeholder="Stok" required></div>
<div class="col-md-2"><input class="form-control" name="gambar" placeholder="URL gambar"></div>
<div class="col-12"><textarea class="form-control" name="deskripsi" placeholder="Deskripsi produk"></textarea></div>
<div class="col-12"><button class="btn btn-primary">Tambah Produk</button></div></div></form>
<div class="card"><div class="table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead><tbody>
<?php foreach ($produk as $p): ?><tr><td><?= esc($p['nama']) ?></td><td><?= esc($p['nama_kategori'] ?? '-') ?></td><td>Rp<?= number_format($p['harga'],0,',','.') ?></td><td><?= esc($p['stok']) ?></td><td><a class="btn btn-sm btn-danger" href="<?= site_url('admin/produk/hapus/'.$p['id']) ?>" onclick="return confirm('Hapus produk?')">Hapus</a></td></tr><?php endforeach ?>
<?php if (!$produk): ?><tr><td colspan="5" class="text-center text-muted">Belum ada produk.</td></tr><?php endif ?>
</tbody></table></div></div>
<?= $this->endSection() ?>
