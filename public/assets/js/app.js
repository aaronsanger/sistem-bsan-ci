/**
 * BSAN Application JavaScript
 * Main application functionality
 */

// ============================================
// CONSTANTS & DATA
// ============================================

const tabData = {
    asas: {
        title: "Penyelenggaraan Budaya Sekolah Aman dan Nyaman dilaksanakan berdasarkan 9 asas",
        items: [
            { name: "Humanis", desc: "Sekolah memanusiakan setiap Warga sekolah." },
            { name: "Komprehensif", desc: "Pendekatan yang menyeluruh dan terpadu" },
            { name: "Partisipatif", desc: "Pelibatan yang berkesadaran dan bermakna" },
            { name: "Kepentingan Terbaik Anak", desc: "Mengutamakan pemenuhan hak anak" },
            { name: "Nondiskriminatif", desc: "Perlakuan yang tidak membeda-bedakan suku, agama, golongan, etnis, budaya, bahasa, serta kondisi fisik, mental, dan intelektual." },
            { name: "Inklusif", desc: "Perlakuan yang mengakomodasi dan menjamin penyertaan penuh penyandang disabilitas" },
            { name: "Kesetaraan Gender", desc: "Relasi sejajar antara perempuan dan laki-laki" },
            { name: "Harmonis", desc: "Hubungan yang selaras, saling menghormati dan berkeadaban" },
            { name: "Berkelanjutan", desc: "Konsisten dan berkesinambungan" }
        ]
    },
    tujuan: {
        title: "Tujuan dan Sasaran",
        tujuan: [
            "Budaya Sekolah Aman dan Nyaman bertujuan untuk menciptakan dan menjaga lingkungan belajar yang kondusif bagi Warga Sekolah.",
            "Pemenuhan kebutuhan spiritual",
            "Pelindungan fisik",
            "Kesejahteraan psikologis dan keamanan sosiokultural",
            "Keadaban dan keamanan digital"
        ],
        sasaran: ["Murid", "Kepala Sekolah", "Guru", "Tenaga Kependidikan selain Pendidik"]
    },
    peran: {
        title: "Peran Warga Sekolah dalam mewujudkan Budaya Sekolah Aman dan Nyaman",
        roles: [
            { name: "Kepala Sekolah", desc: "Menetapkan kebijakan, memimpin implementasi, dan membangun kolaborasi" },
            { name: "Guru", desc: "Menciptakan pembelajaran aman dan nyaman, deteksi dini, pembinaan, dan keteladanan" },
            { name: "Tenaga Kependidikan", desc: "Mendukung pelaksanaan pembelajaran aman dan nyaman, deteksi dini, pembinaan, dan keteladanan" },
            { name: "Murid", desc: "Berpartisipasi aktif, saling menghormati, dan membangun budaya positif" }
        ]
    },
    catur: {
        title: "Partisipasi Catur Pusat Pendidikan",
        groups: [
            {
                name: "SEKOLAH",
                items: [
                    "Kepala Sekolah: Menetapkan kebijakan, memimpin implementasi, membangun kolaborasi, dan keteladanan.",
                    "Guru Kelas, Guru Wali, Guru BK, Guru Mapel, dan Tendik: Menciptakan pembelajaran aman dan nyaman, deteksi dini, pembinaan, dan keteladanan.",
                    "Murid: Berpartisipasi aktif, saling menghormati, dan menjadi penggerak budaya positif."
                ]
            },
            {
                name: "MASYARAKAT",
                items: [
                    "Menjaga lingkungan sekitar sekolah tetap aman dan kondusif.",
                    "Mendukung dan bekerja sama dengan sekolah.",
                    "Berperan dalam deteksi dini dan pelaporan yang bertanggung jawab."
                ]
            },
            {
                name: "ORANG TUA/WALI",
                items: [
                    "Menyelaraskan nilai dan pola pengasuhan dengan sekolah.",
                    "Berkomunikasi aktif dengan pihak sekolah.",
                    "Mendampingi dan memantau perkembangan murid, termasuk di ruang digital."
                ]
            },
            {
                name: "MEDIA",
                items: [
                    "Menyebarluaskan informasi dan praktik baik budaya sekolah aman dan nyaman.",
                    "Menyajikan konten edukatif yang berpihak pada pelindungan dan kesehatan mental murid.",
                    "Menerapkan etika jurnalistik dengan mengutamakan pelindungan identitas murid."
                ]
            }
        ]
    },
    penyelenggaraan: {
        title: "Penyelenggaraan Budaya Sekolah Aman dan Nyaman meliputi:",
        items: [
            "Penguatan tata kelola",
            "Edukasi Warga Sekolah",
            "Penguatan peran Warga Sekolah",
            "Respons dan penanganan pelanggaran",
            "Tanggung jawab Kementerian dan Pemerintah Daerah",
            "Peran pemangku kepentingan"
        ]
    },
    pokja: {
        title: "Pembentukan dan Kedudukan Kelompok Kerja (Pokja) Budaya Sekolah Aman dan Nyaman"
    }
};

const faqData = [
    {
        q: "Apa Itu Budaya Sekolah Aman Dan Nyaman?",
        a: "Budaya Sekolah Aman dan Nyaman adalah keseluruhan tata nilai, sikap, kebiasaan, dan perilaku yang dibangun di lingkungan Sekolah untuk menjamin pemenuhan kebutuhan spiritual, pelindungan fisik, kesejahteraan psikologis dan keamanan sosiokultural, serta keadaban dan keamanan digital demi menciptakan dan menjaga lingkungan belajar yang kondusif bagi Warga Sekolah."
    },
    {
        q: "Mengapa Sekolah Harus Aman Dan Nyaman?",
        a: "Sekolah harus aman dan nyaman karena sekolah adalah tempat belajar, bertumbuh, berkembang dan membentuk karakter. Oleh karena itu, Sekolah yang aman dan nyaman menjadi jaminan Warga Sekolah untuk dapat belajar, bekerja, berinteraksi dalam suasana yang tenang, menghargai martabat manusia, mendukung perkembangan bersama, serta aman dari risiko yang mengganggu keselamatan."
    },
    {
        q: "Apakah TPPK Masih Berlaku?",
        a: "Berdasarkan Permendikdasmen Nomor 6 Tahun 2026, TPPK dinyatakan tidak lagi berlaku di sekolah. Penyelenggaraan Budaya Sekolah Aman dan Nyaman di Sekolah menjadi tanggung jawab kepala sekolah melibatkan guru, tenaga kependidikan, dan murid serta partisipasi orang tua, masyarakat, dan media."
    },
    {
        q: "Apakah Satgas Masih Berlaku?",
        a: "Satgas dinyatakan tidak lagi berlaku. Penyelenggaraan Budaya Sekolah Aman dan Nyaman di pemerintah daerah menjadi tanggung jawab kepala daerah melalui Kelompok Kerja (Pokja) yang terdiri dari lintas perangkat daerah."
    }
];

// ============================================
// THEME MANAGEMENT
// ============================================

function initTheme() {
    const saved = localStorage.getItem('bsan-theme');
    if (saved) {
        document.documentElement.setAttribute('data-theme', saved);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
    updateThemeIcon();
}

function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme') || 'light';
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('bsan-theme', next);
    updateThemeIcon();
}

function updateThemeIcon() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const sunIcon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><circle cx="12" cy="12" r="5"/><g stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></g></svg>';
    const moonIcon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
    const icon = isDark ? sunIcon : moonIcon;
    const btn = document.getElementById('theme-toggle');
    if (btn) btn.innerHTML = icon;
    const btnMobile = document.getElementById('theme-toggle-mobile');
    if (btnMobile) btnMobile.innerHTML = icon;
}

// ============================================
// MOBILE MENU
// ============================================

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.toggle('active');
    }
}

function closeMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.remove('active');
    }
}

// ============================================
// TABS
// ============================================

function initTabs() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.dataset.tab;

            // Update active button
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Update active panel
            document.querySelectorAll('.tab-panel').forEach(panel => {
                panel.classList.remove('active');
            });
            document.getElementById(`tab-${tabId}`)?.classList.add('active');
        });
    });
}

// ============================================
// MODALS
// ============================================

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

function initModals() {
    // Close on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                modal.classList.remove('active');
            });
            document.body.style.overflow = '';
        }
    });
}

// ============================================
// YOUTUBE EMBED HELPER
// ============================================

function createYouTubeEmbed(videoId, title = 'YouTube video') {
    return `
        <div class="youtube-embed">
            <iframe 
                src="https://www.youtube-nocookie.com/embed/${videoId}"
                title="${title}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
            ></iframe>
        </div>
    `;
}

// ============================================
// RENDER FUNCTIONS
// ============================================

function renderTabContent(tabId) {
    const data = tabData[tabId];
    if (!data) return '';

    switch (tabId) {
        case 'asas':
            return `
                <h3 class="card__title" style="margin-bottom: var(--spacing-6)">${data.title}</h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    ${data.items.map(item => `
                        <div class="tab-item">
                            <h4 class="tab-item__title">${item.name}</h4>
                            <p class="tab-item__text">${item.desc}</p>
                        </div>
                    `).join('')}
                </div>
            `;

        case 'tujuan':
            return `
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="card__title" style="margin-bottom: var(--spacing-4)">Tujuan</h3>
                        <ul style="list-style: none">
                            ${data.tujuan.map(item => `
                                <li style="display: flex; align-items: flex-start; gap: var(--spacing-3); margin-bottom: var(--spacing-3)">
                                    <span style="color: var(--color-success)">✓</span>
                                    <span style="color: var(--color-text-muted)">${item}</span>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                    <div>
                        <h3 class="card__title" style="margin-bottom: var(--spacing-4)">Sasaran</h3>
                        <ul style="list-style: none">
                            ${data.sasaran.map((item, i) => `
                                <li style="display: flex; align-items: center; gap: var(--spacing-3); margin-bottom: var(--spacing-3)">
                                    <span style="width: 32px; height: 32px; background: rgba(59, 130, 246, 0.1); color: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem">${i + 1}</span>
                                    <span style="color: var(--color-text-muted)">${item}</span>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                </div>
            `;

        case 'peran':
            return `
                <h3 class="card__title" style="margin-bottom: var(--spacing-6)">${data.title}</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    ${data.roles.map(role => `
                        <div class="tab-item">
                            <h4 class="tab-item__title">${role.name}</h4>
                            <p class="tab-item__text">${role.desc}</p>
                        </div>
                    `).join('')}
                </div>
            `;

        case 'catur':
            return `
                <h3 class="card__title" style="margin-bottom: var(--spacing-6)">${data.title}</h3>
                <div class="grid sm:grid-cols-2 gap-6">
                    ${data.groups.map(group => `
                        <div style="border: 1px solid var(--color-border); border-radius: var(--radius-xl); overflow: hidden">
                            <div style="background: var(--color-primary); color: white; padding: var(--spacing-3); font-weight: 700">${group.name}</div>
                            <ul style="padding: var(--spacing-4); list-style: none">
                                ${group.items.map(item => `
                                    <li style="font-size: 0.875rem; color: var(--color-text-muted); display: flex; align-items: flex-start; gap: var(--spacing-2); margin-bottom: var(--spacing-2)">
                                        <span style="color: var(--color-primary)">•</span>
                                        ${item}
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    `).join('')}
                </div>
            `;

        case 'penyelenggaraan':
            return `
                <h3 class="card__title" style="margin-bottom: var(--spacing-6)">${data.title}</h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    ${data.items.map((item, i) => `
                        <div class="tab-item" style="display: flex; align-items: center; gap: var(--spacing-3)">
                            <span style="width: 32px; height: 32px; background: var(--color-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0">${i + 1}</span>
                            <span style="color: var(--color-text)">${item}</span>
                        </div>
                    `).join('')}
                </div>
            `;

        case 'pokja':
            return `
                <h3 class="card__title" style="margin-bottom: var(--spacing-6)">Pembentukan dan Kedudukan Kelompok Kerja (Pokja) Budaya Sekolah Aman dan Nyaman</h3>
                
                <!-- Table -->
                <div style="overflow-x: auto; margin-bottom: var(--spacing-8)">
                    <table style="width: 100%; border-collapse: collapse; background: var(--color-bg-alt); border-radius: var(--radius-lg); overflow: hidden">
                        <thead>
                            <tr style="background: var(--color-primary); color: white">
                                <th style="padding: var(--spacing-3); text-align: left">Aspek</th>
                                <th style="padding: var(--spacing-3); text-align: left">Kabupaten/Kota</th>
                                <th style="padding: var(--spacing-3); text-align: left">Provinsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid var(--color-border)">
                                <td style="padding: var(--spacing-3); font-weight: 500; color: var(--color-text)">Pembentuk</td>
                                <td style="padding: var(--spacing-3); color: var(--color-text-muted)">Bupati/Wali Kota</td>
                                <td style="padding: var(--spacing-3); color: var(--color-text-muted)">Gubernur</td>
                            </tr>
                            <tr style="background: var(--color-bg-section); border-bottom: 1px solid var(--color-border)">
                                <td style="padding: var(--spacing-3); font-weight: 500; color: var(--color-text)">Lingkup</td>
                                <td style="padding: var(--spacing-3); color: var(--color-text-muted)">PAUD, SD, SMP</td>
                                <td style="padding: var(--spacing-3); color: var(--color-text-muted)">SMA, SMK, SLB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Org Chart -->
                <h4 style="font-weight: 700; margin-bottom: var(--spacing-4); color: var(--color-text)">Susunan Pokja</h4>
                <div style="display: flex; flex-direction: column; align-items: center; gap: var(--spacing-2)">
                    <div style="background: #1e40af; color: white; padding: var(--spacing-3) var(--spacing-6); border-radius: var(--radius-lg); font-weight: 700">Ketua: Sekretaris Daerah</div>
                    <div style="width: 2px; height: 16px; background: #93c5fd"></div>
                    <div style="background: var(--color-primary); color: white; padding: var(--spacing-3) var(--spacing-6); border-radius: var(--radius-lg); font-weight: 700">Wakil Ketua: Kepala Bappeda</div>
                    <div style="width: 2px; height: 16px; background: #93c5fd"></div>
                    <div style="background: var(--color-primary-light); color: white; padding: var(--spacing-3) var(--spacing-6); border-radius: var(--radius-lg); font-weight: 700">Koordinator: Kepala Dinas Pendidikan</div>
                    <div style="width: 2px; height: 16px; background: #93c5fd"></div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        ${["Bidang Pendidikan", "Bidang PPPA", "Bidang Sosial", "Bidang Kesehatan", "Bidang Dukbangga", "Bidang Kominfo"].map(b => `
                            <div style="background: rgba(59, 130, 246, 0.1); color: var(--color-primary); padding: var(--spacing-2) var(--spacing-4); border-radius: var(--radius-lg); font-size: 0.875rem; text-align: center">${b}</div>
                        `).join('')}
                    </div>
                </div>
                <p style="margin-top: var(--spacing-6); font-size: 0.875rem; color: var(--color-text-muted); text-align: center">Masa Tugas Pokja: 4 tahun dan dapat diperpanjang</p>
            `;

        default:
            return '';
    }
}

function renderFAQ() {
    const container = document.getElementById('faq-list');
    if (!container) return;

    container.innerHTML = faqData.map(faq => `
        <details class="faq-item">
            <summary>${faq.q}</summary>
            <div class="faq-item__content">${faq.a}</div>
        </details>
    `).join('');
}

// ============================================
// INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initTabs();
    initModals();
    renderFAQ();

    // Render initial tab content
    const tabPanels = document.querySelectorAll('.tab-panel');
    tabPanels.forEach(panel => {
        const tabId = panel.id.replace('tab-', '');
        panel.innerHTML = renderTabContent(tabId);
    });
});

// Export for use in other files
if (typeof window !== 'undefined') {
    window.BSAN = {
        toggleTheme,
        toggleMobileMenu,
        closeMobileMenu,
        openModal,
        closeModal,
        createYouTubeEmbed,
        tabData,
        faqData
    };
}
