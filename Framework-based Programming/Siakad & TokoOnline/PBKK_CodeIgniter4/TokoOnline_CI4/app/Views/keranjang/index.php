<?= $this->extend('layout') ?><?= $this->section('content') ?>
<h2 class="mb-3">Keranjang Belanja</h2>
<?php if (!$items): ?><div class="alert alert-info">Keranjang masih kosong. <a href="<?= site_url('/') ?>">Lihat produk</a>.</div><?php else: ?>
<form method="post" action="<?= site_url('keranjang/update') ?>" class="card card-body mb-4"><?= csrf_field() ?>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Produk</th><th>Harga</th><th style="width:130px">Jumlah</th><th>Subtotal</th><th></th></tr></thead><tbody>
<?php foreach ($items as $item): ?><tr><td><?= esc($item['produk']['nama']) ?></td><td>Rp<?= number_format($item['produk']['harga'],0,',','.') ?></td><td><input class="form-control" type="number" min="0" max="<?= esc($item['produk']['stok']) ?>" name="jumlah[<?= $item['produk']['id'] ?>]" value="<?= esc($item['jumlah']) ?>"></td><td>Rp<?= number_format($item['subtotal'],0,',','.') ?></td><td><a class="btn btn-sm btn-outline-danger" href="<?= site_url('keranjang/hapus/'.$item['produk']['id']) ?>">Hapus</a></td></tr><?php endforeach ?>
</tbody></table></div><button class="btn btn-outline-primary align-self-start">Perbarui Keranjang</button></form>
<div class="row"><div class="col-md-6 ms-auto"><div class="card card-body"><h4>Total: Rp<?= number_format($total,0,',','.') ?></h4>
<form method="post" action="<?= site_url('checkout') ?>"><?= csrf_field() ?>
<div class="mb-2"><input class="form-control" name="nama_pelanggan" placeholder="Nama lengkap" value="<?= old('nama_pelanggan') ?>" required></div>
<div class="mb-2"><input class="form-control" type="email" name="email" placeholder="Email" value="<?= old('email') ?>" required></div>
<div class="mb-3"><textarea class="form-control" name="alamat" placeholder="Alamat pengiriman" required><?= old('alamat') ?></textarea></div>
<button class="btn btn-primary w-100">Checkout</button></form></div></div></div>
<?php endif ?><?= $this->endSection() ?>
