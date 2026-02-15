<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="<?= $description ?? 'Budaya Sekolah Aman dan Nyaman - Mewujudkan lingkungan belajar yang kondusif bagi seluruh warga sekolah' ?>">
    <title><?= $title ?? 'BSAN' ?> - Budaya Sekolah Aman dan Nyaman</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="icon" href="/assets/icon/favicon.ico">

    <?= $this->renderSection('head') ?>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container navbar__inner">
            <!-- Logo -->
            <a href="/" class="navbar__logo">
                <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Hitam.png" alt="Logo Kemendikdasmen" class="logo-light">
                <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Putih.png" alt="Logo Kemendikdasmen" class="logo-dark">
            </a>

            <!-- Desktop Menu -->
            <div class="navbar__menu">
                <a href="/#beranda" class="navbar__link">Beranda</a>
                <a href="/#urgensi" class="navbar__link">Urgensi</a>
                <a href="/data-publik" class="navbar__link">Data Publik</a>
                <a href="/#sekilas" class="navbar__link">Sekilas Permendikdasmen</a>
                <a href="/faq" class="navbar__link">FAQ</a>
                <a href="/auth/login" class="navbar__cta">Masuk</a>
                <button id="theme-toggle" class="theme-toggle" onclick="BSAN.toggleTheme()"></button>
            </div>

            <!-- Mobile Menu Button -->
            <button class="navbar__toggle" onclick="BSAN.toggleMobileMenu()">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="navbar__mobile container">
            <a href="/#beranda" onclick="BSAN.closeMobileMenu()">Beranda</a>
            <a href="/#urgensi" onclick="BSAN.closeMobileMenu()">Urgensi</a>
            <a href="/data-publik" onclick="BSAN.closeMobileMenu()">Data Publik</a>
            <a href="/#sekilas" onclick="BSAN.closeMobileMenu()">Sekilas Permendikdasmen</a>
            <a href="/faq" onclick="BSAN.closeMobileMenu()">FAQ</a>
            <a href="/auth/login" class="btn btn--blue btn--full" style="margin-top: var(--spacing-4)">Masuk</a>
            <div style="text-align: center; margin-top: var(--spacing-4)">
                <button id="theme-toggle-mobile" class="theme-toggle" onclick="BSAN.toggleTheme()"></button>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer class="footer"
        style="background-image: url('https://cerdasberkarakter.kemendikdasmen.go.id/wp-content/uploads/2026/01/bg-footer-bsan.png')">
        <div class="container">
            <div class="footer__tagline">
                <p>Kolaborasi dalam Partisipasi Semesta Mewujudkan Budaya Sekolah Aman dan Nyaman</p>
                <p>untuk Pendidikan Bermutu untuk Semua</p>
            </div>

            <div class="footer__logos">
                <img src="/assets/icon/G7KAIH Tulisan Hitam.png" alt="G7KAIH" class="logo-light">
                <img src="/assets/icon/G7KAIH Tulisan Putih.png" alt="G7KAIH" class="logo-dark">
                <img src="/assets/icon/Logo Cerdas Berkarakter Biru.png" alt="Cerdas Berkarakter" class="logo-light">
                <img src="/assets/icon/Logo Cerdas Berkarakter Putih.png" alt="Cerdas Berkarakter" class="logo-dark">
                <img src="/assets/icon/0. ramah-putih Hitam.png" alt="Ramah" class="logo-light">
                <img src="/assets/icon/0. ramah-putih.png" alt="Ramah" class="logo-dark">
            </div>

            <div class="footer__info">
                <h3>Pusat Penguatan Karakter</h3>
                <p>Sekretariat Jenderal, Kementerian Pendidikan Dasar dan Menengah</p>
                <p>Kompleks Kementerian Pendidikan Dasar dan Menengah, Gedung C<br>Jl. Sudirman, Senayan – Jakarta,
                    10270</p>
                <a href="mailto:puspeka@dikdasmen.go.id">puspeka@dikdasmen.go.id</a>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    <div id="modal-paradigma" class="modal-overlay">
        <div class="modal">
            <div class="modal__header">
                <h3 class="modal__title">Urgensi Budaya Sekolah Aman dan Nyaman</h3>
                <button class="modal__close" onclick="BSAN.closeModal('modal-paradigma')">&times;</button>
            </div>
            <div class="modal__body">
                <h4 style="font-weight: 700; margin-bottom: var(--spacing-2)">Pergeseran Paradigma Kebijakan</h4>
                <p style="color: var(--color-text-muted); margin-bottom: var(--spacing-4)">
                    Dari Reaktif Kuratif menjadi Promotif Preventif Kolaboratif: Sebagai wujud dari pendidikan bermutu
                    untuk semua perlu ada penyesuaian paradigma pencegahan dan penanganan kejadian pelanggaran keamanan
                    dan kenyamanan yang terjadi di sekolah ke arah pendekatan promotif preventif kolaboratif dengan
                    menjunjung tinggi hak anak dan hak asasi manusia.
                </p>
                <h4 style="font-weight: 700; margin-bottom: var(--spacing-2)">Dinamika Acuan Dasar Hukum</h4>
                <p style="color: var(--color-text-muted); margin-bottom: var(--spacing-4)">
                    Diperlukan peraturan menteri baru yang secara aktif mengacu dan selaras dengan berbagai regulasi
                    seperti: UU Perlindungan Anak, UU Tindak Pidana Kekerasan Seksual, PP Tunas dan ketentuan peraturan
                    perundang-undangan lainnya.
                </p>
                <h4 style="font-weight: 700; margin-bottom: var(--spacing-2)">Partisipasi dan Peran Serta</h4>
                <p style="color: var(--color-text-muted)">
                    Penyelenggaraan Budaya Sekolah Aman dan Nyaman dilaksanakan berdasarkan prinsip kemitraan dan gotong
                    royong melalui pelibatan aktif Murid, Guru, Kepala Sekolah, Tenaga Kependidikan, Orang Tua/Wali,
                    Masyarakat, dan Media.
                </p>
            </div>
        </div>
    </div>

    <div id="modal-hukum" class="modal-overlay">
        <div class="modal">
            <div class="modal__header">
                <h3 class="modal__title">Inti Pesan</h3>
                <button class="modal__close" onclick="BSAN.closeModal('modal-hukum')">&times;</button>
            </div>
            <div class="modal__body">
                <p style="color: var(--color-text-muted); margin-bottom: var(--spacing-4)">
                    Menjamin keamanan dan kenyamanan Warga Sekolah secara menyeluruh, mencakup aspek spiritual, fisik,
                    psikologis, sosiokultural, serta keadaban dan keamanan digital melalui sinergi Catur Pusat
                    Pendidikan.
                </p>
                <h4 style="font-weight: 700; margin-bottom: var(--spacing-2)">Partisipasi Semesta</h4>
                <p style="color: var(--color-text-muted)">
                    Pelibatan peran murid, kepala sekolah, guru, wali kelas, guru wali, guru BK, dan tenaga kependidikan
                    untuk mewujudkan budaya sekolah yang aman dan nyaman.
                </p>
            </div>
        </div>
    </div>

    <div id="modal-partisipasi" class="modal-overlay">
        <div class="modal">
            <div class="modal__header">
                <h3 class="modal__title">Mekanisme</h3>
                <button class="modal__close" onclick="BSAN.closeModal('modal-partisipasi')">&times;</button>
            </div>
            <div class="modal__body">
                <p style="color: var(--color-text-muted); margin-bottom: var(--spacing-4)">
                    Pendekatan promotif dan preventif dilaksanakan secara humanis, komprehensif, dan partisipatif
                    melalui penguatan tata kelola, edukasi Warga Sekolah, peran dan tanggung jawab setiap unsur, serta
                    respons dan penanganan yang adil.
                </p>
                <h4 style="font-weight: 700; margin-bottom: var(--spacing-2)">Penguatan Promotif–Preventif Budaya
                    Sekolah</h4>
                <p style="color: var(--color-text-muted)">
                    Melalui penguatan tata kelola dan deteksi dini; edukasi Warga Sekolah; penguatan peran kepala
                    sekolah, guru, tendik, dan murid; manajemen kelas; budaya positif di sekolah; serta pelibatan orang
                    tua/wali, komite sekolah, masyarakat, dan media.
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/assets/js/utils/statusConfig.js"></script>
    <script src="/assets/js/app.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
