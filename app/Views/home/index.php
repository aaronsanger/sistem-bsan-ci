<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section id="beranda" class="hero"
    style="background-image: url('https://cerdasberkarakter.kemendikdasmen.go.id/wp-content/uploads/2026/01/bg-lamanbsan1a.png')">
    <div class="container">
        <div class="hero__grid">
            <div>
                <h1 class="hero__title">
                    Mari Bersama Wujudkan
                    <span>Budaya Sekolah Aman Nasional</span>
                </h1>
                <p class="hero__subtitle">
                    Mewujudkan Budaya Sekolah Aman dan Nyaman sebagai keseluruhan tata nilai, sikap, kebiasaan, dan
                    perilaku yang dibangun di lingkungan sekolah untuk menjamin pemenuhan kebutuhan spiritual,
                    pelindungan fisik, kesejahteraan psikologis dan keamanan sosiokultural, serta keadaban dan
                    keamanan digital.
                </p>
                <div class="hero__buttons">
                    <a href="https://s.id/permendikdasmen6tahun2026" target="_blank" rel="noopener noreferrer"
                        class="btn btn--primary">
                        Unduh Permendikdasmen
                    </a>
                    <a href="https://s.id/paparan-permendikdasmen6tahun2026" target="_blank"
                        rel="noopener noreferrer" class="btn btn--outline">
                        Lihat Paparan
                    </a>
                </div>
            </div>
            <div>
                <div class="youtube-embed">
                    <iframe src="https://www.youtube-nocookie.com/embed/alT-Qr9ldzQ" title="Lagu Rukun Sama Teman"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Urgensi Section -->
<section id="urgensi" class="section section--white">
    <div class="container">
        <h2 class="section__title">Urgensi</h2>
        <p class="section__subtitle">
            Regulasi ini merupakan perluasan dari upaya pencegahan dan penanganan kekerasan menuju pelindungan
            menyeluruh
        </p>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="card">
                <div class="card__icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <h3 class="card__title">Pergeseran Paradigma</h3>
                <p class="card__text">
                    Mengubah cara pandang terhadap keselamatan dan kesejahteraan di lingkungan sekolah.
                </p>
                <button class="card__link" onclick="BSAN.openModal('modal-paradigma')">
                    Baca lebih lanjut
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Card 2 -->
            <div class="card">
                <div class="card__icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                </div>
                <h3 class="card__title">Kerangka Hukum</h3>
                <p class="card__text">
                    Dasar hukum yang kuat untuk menjamin perlindungan bagi seluruh warga sekolah.
                </p>
                <button class="card__link" onclick="BSAN.openModal('modal-hukum')">
                    Baca lebih lanjut
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Card 3 -->
            <div class="card">
                <div class="card__icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="card__title">Partisipasi Aktif</h3>
                <p class="card__text">
                    Keterlibatan seluruh pemangku kepentingan dalam menciptakan budaya aman.
                </p>
                <button class="card__link" onclick="BSAN.openModal('modal-partisipasi')">
                    Baca lebih lanjut
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Sekilas Video Section -->
<section class="section section--slate">
    <div class="container" style="max-width: 56rem">
        <h2 class="section__title">Sekilas Tentang Budaya Sekolah Aman dan Nyaman</h2>
        <p class="section__subtitle">Penjelasan singkat tentang program Budaya Sekolah Aman dan Nyaman</p>
        <div class="youtube-embed">
            <iframe src="https://www.youtube-nocookie.com/embed/GOVbEEkrqyU" title="Sekilas BSAN"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
    </div>
</section>

<!-- Tabs Section -->
<section id="sekilas" class="section section--gray">
    <div class="container">
        <h2 class="section__title">Sekilas Permendikdasmen No. 6 Tahun 2026</h2>

        <!-- Tab Navigation -->
        <div class="tabs">
            <button class="tab-btn active" data-tab="asas">Asas</button>
            <button class="tab-btn" data-tab="tujuan">Tujuan dan Sasaran</button>
            <button class="tab-btn" data-tab="peran">Peran Warga Sekolah</button>
            <button class="tab-btn" data-tab="catur">Peran Catur Pusat Pendidikan</button>
            <button class="tab-btn" data-tab="penyelenggaraan">Penyelenggaraan BSAN</button>
            <button class="tab-btn" data-tab="pokja">Pembentukan Pokja</button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <div id="tab-asas" class="tab-panel active"></div>
            <div id="tab-tujuan" class="tab-panel"></div>
            <div id="tab-peran" class="tab-panel"></div>
            <div id="tab-catur" class="tab-panel"></div>
            <div id="tab-penyelenggaraan" class="tab-panel"></div>
            <div id="tab-pokja" class="tab-panel"></div>

            <p style="margin-top: var(--spacing-6); font-size: 0.875rem; color: var(--color-text-muted)">
                *Baca lebih lanjut pada Permendikdasmen Nomor 6 Tahun 2026 tentang Budaya Sekolah Aman dan Nyaman
                <a href="https://s.id/permendikdasmen6tahun2026" target="_blank" rel="noopener noreferrer"
                    style="color: var(--color-primary)">unduh di sini</a>
            </p>
        </div>
    </div>
</section>

<!-- Kata Pemangku Kepentingan Section -->
<section class="section section--slate">
    <div class="container">
        <h2 class="section__title">Kata Para Pemangku Kepentingan</h2>
        <p class="section__subtitle">Dukungan dari berbagai pihak untuk Budaya Sekolah Aman dan Nyaman</p>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="youtube-embed">
                <iframe src="https://www.youtube-nocookie.com/embed/VGVXT23SY-s" title="Pemangku Kepentingan 1"
                    allowfullscreen></iframe>
            </div>
            <div class="youtube-embed">
                <iframe src="https://www.youtube-nocookie.com/embed/bxsnaOBe_70" title="Pemangku Kepentingan 2"
                    allowfullscreen></iframe>
            </div>
            <div class="youtube-embed">
                <iframe src="https://www.youtube-nocookie.com/embed/qGuhVBII69I" title="Pemangku Kepentingan 3"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>

<!-- Peluncuran Section -->
<section class="section section--white">
    <div class="container" style="max-width: 56rem">
        <h2 class="section__title">Peluncuran Permendikdasmen Nomor 6 Tahun 2026</h2>
        <p class="section__subtitle">Momen bersejarah peluncuran regulasi Budaya Sekolah Aman dan Nyaman</p>
        <div class="youtube-embed">
            <iframe src="https://www.youtube-nocookie.com/embed/B9sz2h26qzI" title="Peluncuran Permendikdasmen"
                allowfullscreen></iframe>
        </div>
    </div>
</section>

<!-- Lagu Section -->
<section id="lagu" class="section" style="background: #facc15">
    <div class="container" style="max-width: 56rem">
        <h2
            style="font-size: 1.875rem; font-weight: 700; text-align: center; color: #1e3a8a; margin-bottom: var(--spacing-4)">
            Lagu Rukun Sama Teman</h2>
        <p style="color: #1e40af; text-align: center; margin-bottom: var(--spacing-8)">
            Dengarkan dan sebarkan lagu kampanye Budaya Sekolah Aman dan Nyaman
        </p>

        <div style="margin-bottom: var(--spacing-8)">
            <div class="youtube-embed">
                <iframe src="https://www.youtube-nocookie.com/embed/alT-Qr9ldzQ" title="Lagu Rukun Sama Teman"
                    allowfullscreen></iframe>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="https://s.id/videolirik-lagurukunsamateman" target="_blank" rel="noopener noreferrer"
                class="btn" style="background: #1e40af; color: white">
                Unduh Video Lirik
            </a>
            <a href="https://s.id/videominusone-lagurukunsamateman" target="_blank" rel="noopener noreferrer"
                class="btn" style="background: white; color: #1e40af">
                Unduh Minus One
            </a>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="section section--white">
    <div class="container" style="max-width: 48rem">
        <h2 class="section__title">Soal Sering Ditanya</h2>
        <div id="faq-list"></div>
        <div style="text-align: center; margin-top: var(--spacing-8)">
            <a href="/faq" class="btn btn--blue">
                Baca Selengkapnya
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="margin-left: var(--spacing-2)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
