<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h2 class="mb-4">Dashboard Sistem Informasi Akademik</h2>
<div class="row g-3">
<?php foreach ([['Mahasiswa', $jumlahMahasiswa, 'mahasiswa'], ['Mata Kuliah', $jumlahMataKuliah, 'mata-kuliah'], ['Data Nilai', $jumlahNilai, 'nilai']] as $item): ?>
<div class="col-md-4"><div class="card shadow-sm"><div class="card-body">
<div class="text-muted"><?= esc($item[0]) ?></div><div class="display-5 fw-bold"><?= esc($item[1]) ?></div>
<a href="<?= site_url($item[2]) ?>" class="btn btn-sm btn-outline-primary mt-2">Kelola data</a>
</div></div></div>
<?php endforeach ?>
</div>
<?= $this->endSection() ?>
