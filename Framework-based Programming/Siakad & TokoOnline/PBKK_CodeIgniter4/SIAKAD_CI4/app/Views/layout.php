<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'SIAKAD') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary"><div class="container">
<a class="navbar-brand fw-bold" href="<?= site_url('dashboard') ?>">SIAKAD</a>
<div class="navbar-nav ms-auto">
<a class="nav-link" href="<?= site_url('mahasiswa') ?>">Mahasiswa</a>
<a class="nav-link" href="<?= site_url('mata-kuliah') ?>">Mata Kuliah</a>
<a class="nav-link" href="<?= site_url('nilai') ?>">Nilai</a>
</div></div></nav>
<main class="container py-4">
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif ?>
<?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif ?>
<?= $this->renderSection('content') ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
