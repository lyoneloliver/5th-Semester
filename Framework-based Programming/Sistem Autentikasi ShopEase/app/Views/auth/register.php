<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card mx-auto p-4" style="max-width: 440px">
            <a href="<?= site_url('/') ?>">← ShopEase</a>

            <h2 class="mt-3">Buat akun</h2>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <?= esc($error) ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('daftar') ?>">
                <?= csrf_field() ?>

                <label class="form-label">Nama</label>
                <input
                    name="name"
                    type="text"
                    class="form-control mb-3"
                    value="<?= esc(old('name')) ?>"
                    required
                >

                <label class="form-label">Email</label>
                <input
                    name="email"
                    type="email"
                    class="form-control mb-3"
                    value="<?= esc(old('email')) ?>"
                    required
                >

                <label class="form-label">Nomor Telepon</label>
                <input
                    name="phone"
                    type="tel"
                    class="form-control mb-3"
                    placeholder="Contoh: 081234567890"
                    value="<?= esc(old('phone')) ?>"
                    required
                >

                <label class="form-label">Password</label>
                <input
                    name="password"
                    type="password"
                    class="form-control mb-3"
                    minlength="8"
                    required
                >
                <div class="form-text mb-3">
                    Minimal 8 karakter, harus mengandung huruf dan angka.
                </div>

                <label class="form-label">Konfirmasi Password</label>
                <input
                    name="password_confirm"
                    type="password"
                    class="form-control mb-3"
                    required
                >

                <div class="form-check mb-3">
                    <input
                        name="terms"
                        type="checkbox"
                        class="form-check-input"
                        id="terms"
                        value="1"
                        required
                    >
                    <label class="form-check-label" for="terms">
                        Saya menyetujui syarat dan ketentuan ShopEase.
                    </label>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Daftar
                </button>
            </form>

            <p class="mt-3 mb-0">
                Sudah punya akun?
                <a href="<?= site_url('masuk') ?>">Masuk</a>
            </p>
        </div>
    </div>
</body>
</html>
