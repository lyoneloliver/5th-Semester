<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h2 class="mb-3"><?= esc($title) ?></h2>
<form method="post" action="<?= site_url($data ? 'mahasiswa/update/'.$data['id'] : 'mahasiswa/simpan') ?>" class="card card-body">
<?= csrf_field() ?>
<?php foreach (['nim'=>'NIM','nama'=>'Nama','email'=>'Email','jurusan'=>'Program Studi','angkatan'=>'Angkatan'] as $field=>$label): ?>
<div class="mb-3"><label class="form-label"><?= esc($label) ?></label>
<input class="form-control" name="<?= esc($field) ?>" value="<?= esc(old($field, $data[$field] ?? '')) ?>" <?= $field === 'angkatan' ? 'type="number"' : ($field === 'email' ? 'type="email"' : 'type="text"') ?> required></div>
<?php endforeach ?>
<div><button class="btn btn-primary">Simpan</button> <a class="btn btn-secondary" href="<?= site_url('mahasiswa') ?>">Kembali</a></div>
</form>
<?= $this->endSection() ?>
