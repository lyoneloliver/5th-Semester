<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3"><h2>Data Mahasiswa</h2><a class="btn btn-primary" href="<?= site_url('mahasiswa/tambah') ?>">Tambah Mahasiswa</a></div>
<div class="card"><div class="table-responsive"><table class="table table-striped mb-0">
<thead><tr><th>NIM</th><th>Nama</th><th>Email</th><th>Jurusan</th><th>Angkatan</th><th>Aksi</th></tr></thead><tbody>
<?php foreach ($mahasiswa as $m): ?><tr>
<td><?= esc($m['nim']) ?></td><td><?= esc($m['nama']) ?></td><td><?= esc($m['email']) ?></td><td><?= esc($m['jurusan']) ?></td><td><?= esc($m['angkatan']) ?></td>
<td><a class="btn btn-sm btn-warning" href="<?= site_url('mahasiswa/edit/'.$m['id']) ?>">Edit</a>
<a class="btn btn-sm btn-danger" href="<?= site_url('mahasiswa/hapus/'.$m['id']) ?>" onclick="return confirm('Hapus data ini?')">Hapus</a></td>
</tr><?php endforeach ?>
<?php if (!$mahasiswa): ?><tr><td colspan="6" class="text-center text-muted">Belum ada data mahasiswa.</td></tr><?php endif ?>
</tbody></table></div></div>
<?= $this->endSection() ?>
