<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="dash-alert dash-alert--success" style="margin-bottom:1.5rem"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="dash-alert dash-alert--danger" style="margin-bottom:1.5rem"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="dash-card">
    <h2 class="dash-card__title" style="margin-bottom:1.5rem">Informasi Profil</h2>

    <form action="/dashboard/profile" method="POST" class="space-y-4">
        <div class="dash-grid--2">
            <div class="form-group">
                <label class="form-label">Nama Depan</label>
                <input type="text" name="nama_depan" value="<?= $profile['nama_depan'] ?? '' ?>" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Belakang</label>
                <input type="text" name="nama_belakang" value="<?= $profile['nama_belakang'] ?? '' ?>" class="form-input">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" value="<?= $profile['email'] ?? session()->get('user_email') ?>" disabled class="form-input" style="background:var(--dash-bg-card-alt);color:var(--dash-text-muted)">
        </div>
        <div class="dash-grid--2">
            <div class="form-group">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" value="<?= $profile['jabatan'] ?? '' ?>" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" value="<?= $profile['nip'] ?? '' ?>" class="form-input">
            </div>
        </div>
        <div class="dash-grid--2">
            <div class="form-group">
                <label class="form-label">Instansi</label>
                <input type="text" name="instansi" value="<?= $profile['instansi'] ?? '' ?>" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Satker</label>
                <input type="text" name="satker" value="<?= $profile['satker'] ?? '' ?>" class="form-input">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">No. WhatsApp</label>
            <input type="text" name="no_whatsapp" value="<?= $profile['no_whatsapp'] ?? '' ?>" class="form-input">
        </div>
        <div style="padding-top:1rem">
            <button type="submit" class="btn-dash btn-dash--primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
