<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h2 class="mb-3">Pengelolaan Nilai</h2>
<form method="post" action="<?= site_url('nilai/simpan') ?>" class="card card-body mb-4">
<?= csrf_field() ?><div class="row g-2">
<div class="col-md-4"><select class="form-select" name="mahasiswa_id" required><option value="">Pilih mahasiswa</option><?php foreach ($mahasiswa as $m): ?><option value="<?= $m['id'] ?>"><?= esc($m['nim'].' - '.$m['nama']) ?></option><?php endforeach ?></select></div>
<div class="col-md-4"><select class="form-select" name="mata_kuliah_id" required><option value="">Pilih mata kuliah</option><?php foreach ($mataKuliah as $m): ?><option value="<?= $m['id'] ?>"><?= esc($m['kode'].' - '.$m['nama']) ?></option><?php endforeach ?></select></div>
<div class="col-md-2"><input class="form-control" type="number" step="0.01" min="0" max="100" name="nilai_angka" placeholder="Nilai" required></div>
<div class="col-md-2"><button class="btn btn-primary w-100">Simpan Nilai</button></div></div></form>
<div class="card"><div class="table-responsive"><table class="table table-striped mb-0"><thead><tr><th>NIM</th><th>Mahasiswa</th><th>Mata Kuliah</th><th>Angka</th><th>Huruf</th></tr></thead><tbody>
<?php foreach ($data as $n): ?><tr><td><?= esc($n['nim']) ?></td><td><?= esc($n['nama_mahasiswa']) ?></td><td><?= esc($n['kode'].' - '.$n['nama_mk']) ?></td><td><?= esc($n['nilai_angka']) ?></td><td><?= esc($n['nilai_huruf']) ?></td></tr><?php endforeach ?>
<?php if (!$data): ?><tr><td colspan="5" class="text-center text-muted">Belum ada nilai.</td></tr><?php endif ?>
</tbody></table></div></div>
<?= $this->endSection() ?>
