<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h2 class="mb-3">Mata Kuliah</h2>
<form method="post" action="<?= site_url('mata-kuliah/simpan') ?>" class="card card-body mb-4">
<?= csrf_field() ?><div class="row g-2">
<div class="col-md-2"><input class="form-control" name="kode" placeholder="Kode" required></div>
<div class="col-md-5"><input class="form-control" name="nama" placeholder="Nama mata kuliah" required></div>
<div class="col-md-2"><input class="form-control" type="number" name="sks" placeholder="SKS" min="1" max="6" required></div>
<div class="col-md-2"><input class="form-control" type="number" name="semester" placeholder="Semester" min="1" max="14" required></div>
<div class="col-md-1"><button class="btn btn-primary w-100">+</button></div></div></form>
<div class="card"><div class="table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Semester</th></tr></thead><tbody>
<?php foreach ($data as $m): ?><tr><td><?= esc($m['kode']) ?></td><td><?= esc($m['nama']) ?></td><td><?= esc($m['sks']) ?></td><td><?= esc($m['semester']) ?></td></tr><?php endforeach ?>
<?php if (!$data): ?><tr><td colspan="4" class="text-center text-muted">Belum ada mata kuliah.</td></tr><?php endif ?>
</tbody></table></div></div>
<?= $this->endSection() ?>
