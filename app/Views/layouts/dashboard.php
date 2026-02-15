<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - Sistem BSAN</title>

    <script src="https://cdn.jsdelivr.net/npm/jquery@4.0.0/dist/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-dt@2.3.6/css/dataTables.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.6/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2/dist/umd/supabase.min.js"></script>
    <link href="/assets/css/app.css" rel="stylesheet">
    <link href="/assets/css/dashboard.css" rel="stylesheet">
    <script src="/assets/js/utils/statusConfig.js"></script>
    <script src="/assets/js/wilayah-data.js"></script>
    <?= $extra_head ?? '' ?>
</head>

<body class="dashboard">
    <div class="dashboard__wrapper">

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar__brand">
                <div class="sidebar__brand-inner">
                    <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Hitam.png" alt="Logo" id="logo-light" class="sidebar__logo">
                    <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Putih.png" alt="Logo" id="logo-dark" class="sidebar__logo" style="display:none">
                    <h2 class="sidebar__title">Sistem BSAN</h2>
                    <p class="sidebar__subtitle" id="sidebar-role-label">Dashboard</p>
                </div>
            </div>

            <nav class="sidebar__nav" id="sidebar-nav">
                <!-- Populated by JS based on role -->
            </nav>
        </aside>

        <!-- Sidebar Overlay (mobile) -->
        <div id="sidebar-overlay" class="sidebar__overlay" onclick="toggleSidebar()"></div>

        <!-- Main Content -->
        <div class="dashboard__main">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar__inner">
                    <div class="topbar__left">
                        <button onclick="toggleSidebar()" class="topbar__toggle">
                            <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="topbar__title"><?= $pageTitle ?? 'Dashboard' ?></h1>
                    </div>
                    <div class="topbar__right">
                        <button id="theme-toggle" class="topbar__icon-btn">
                            <!-- Sun icon (shown in dark mode → click to go light) -->
                            <svg id="theme-icon-sun" class="icon-md" style="display:none" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/></svg>
                            <!-- Moon icon (shown in light mode → click to go dark) -->
                            <svg id="theme-icon-moon" class="icon-md" style="display:none" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                        </button>
                        <!-- Profile Dropdown -->
                        <div class="profile-dropdown">
                            <button onclick="toggleProfileDropdown()" class="profile-dropdown__trigger" id="profile-btn">
                                <div class="profile-dropdown__avatar" id="user-avatar">A</div>
                                <div class="profile-dropdown__info">
                                    <p class="profile-dropdown__name" id="user-name">Admin Demo</p>
                                    <p class="profile-dropdown__role" id="user-role-label">Admin Kementerian</p>
                                </div>
                                <svg class="profile-dropdown__chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="profile-dropdown" class="profile-dropdown__menu">
                                <?php $sessionRole = session()->get('user_role') ?? 'admin'; ?>
                                <?php if (in_array($sessionRole, ['admin', 'koordinator'])): ?>
                                <!-- Admin/Koordinator: show role switcher -->
                                <div class="profile-dropdown__section">
                                    <p class="profile-dropdown__section-title">Ganti Peran Demo</p>
                                    <button onclick="switchRole('kementerian')" class="role-btn" data-role="kementerian">
                                        <span class="role-btn__avatar role-btn__avatar--red">K</span>
                                        <div>
                                            <p class="role-btn__title">Admin Kementerian Pusat</p>
                                            <p class="role-btn__desc">Approval & monitoring</p>
                                        </div>
                                    </button>
                                    <button onclick="switchRole('dinas_prov')" class="role-btn" data-role="dinas_prov">
                                        <span class="role-btn__avatar role-btn__avatar--blue">P</span>
                                        <div>
                                            <p class="role-btn__title">Admin Dinas Provinsi</p>
                                            <p class="role-btn__desc">Kelola Pokja provinsi</p>
                                        </div>
                                    </button>
                                    <button onclick="switchRole('dinas_kab')" class="role-btn" data-role="dinas_kab">
                                        <span class="role-btn__avatar role-btn__avatar--green">D</span>
                                        <div>
                                            <p class="role-btn__title">Admin Dinas Kab/Kota</p>
                                            <p class="role-btn__desc">Kelola Pokja kabupaten/kota</p>
                                        </div>
                                    </button>
                                </div>
                                <?php else: ?>
                                <!-- Dinas roles: show locked role info -->
                                <div class="profile-dropdown__section">
                                    <p class="profile-dropdown__section-title">Peran Anda</p>
                                    <div class="d-flex d-flex--gap-3" style="padding: 0.5rem 0.75rem;">
                                        <span class="role-btn__avatar <?= $sessionRole === 'dinas_prov' ? 'role-btn__avatar--blue' : 'role-btn__avatar--green' ?>"><?= $sessionRole === 'dinas_prov' ? 'P' : 'D' ?></span>
                                        <div>
                                            <p class="role-btn__title" style="font-size:0.875rem"><?= session()->get('user_name') ?></p>
                                            <p class="role-btn__desc">
                                                <?= session()->get('wilayah_kabupaten') ?? session()->get('wilayah_provinsi') ?? '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="profile-dropdown__section">
                                    <?php if (in_array($sessionRole, ['admin', 'koordinator'])): ?>
                                    <button onclick="resetDemoData()" class="dropdown-action dropdown-action--warning">
                                        <svg class="dropdown-action__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Reset Data Demo
                                    </button>
                                    <?php endif; ?>
                                    <a href="/auth/logout" class="dropdown-action dropdown-action--danger">
                                        <svg class="dropdown-action__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="dashboard__content">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Wilayah Selection Modal -->
    <div id="wilayah-modal" class="modal">
        <div class="modal__overlay" onclick="closeWilayahModal()"></div>
        <div class="modal__container">
            <div class="modal__header">
                <div>
                    <h3 class="modal__title" id="wilayah-modal-title">Pilih Wilayah</h3>
                    <p class="modal__desc" id="wilayah-modal-desc">Pilih provinsi untuk melanjutkan</p>
                </div>
                <button onclick="closeWilayahModal()" class="modal__close">
                    <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal__body">
                <!-- Search -->
                <div style="margin-bottom: 1rem;">
                    <input type="text" id="wilayah-search" placeholder="Cari wilayah..." class="form-input" oninput="filterWilayahList()">
                </div>
                <!-- Provinsi Step -->
                <div id="wilayah-step-prov">
                    <label class="form-label">Provinsi <span class="form-label__required">*</span></label>
                    <div id="wilayah-prov-list" class="space-y-1"></div>
                </div>
                <!-- Kabupaten Step (hidden initially) -->
                <div id="wilayah-step-kab" style="display:none">
                    <button onclick="backToProvStep()" class="link-primary d-flex d-flex--gap-1" style="margin-bottom:0.75rem">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali ke Provinsi
                    </button>
                    <div style="margin-bottom:0.5rem">
                        <span style="font-size:0.75rem;font-weight:500;color:var(--dash-text-muted)">Provinsi:</span>
                        <span id="selected-prov-label" style="font-size:0.875rem;font-weight:600;color:var(--dash-text);margin-left:0.25rem"></span>
                    </div>
                    <label class="form-label">Kabupaten/Kota <span class="form-label__required">*</span></label>
                    <div id="wilayah-kab-list" class="space-y-1"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/app.js"></script>
    <script>
        // ---- Theme Toggle ----
        const THEME_KEY = 'bsan_theme';
        function applyTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-theme', 'light');
            }
            // Toggle icon visibility
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            if (sunIcon) sunIcon.style.display = isDark ? 'block' : 'none';
            if (moonIcon) moonIcon.style.display = isDark ? 'none' : 'block';
            // Toggle logo
            const logoLight = document.getElementById('logo-light');
            const logoDark = document.getElementById('logo-dark');
            if (logoLight) logoLight.style.display = isDark ? 'none' : 'block';
            if (logoDark) logoDark.style.display = isDark ? 'block' : 'none';
        }
        function initTheme() {
            const saved = localStorage.getItem(THEME_KEY);
            const isDark = saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches);
            applyTheme(isDark);
        }
        initTheme();
        document.getElementById('theme-toggle')?.addEventListener('click', () => {
            const isDark = !document.documentElement.classList.contains('dark');
            applyTheme(isDark);
            localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
        });

        // ---- Role System ----
        const ROLE_KEY = 'bsan_demo_role';
        const WILAYAH_PROV_KEY = 'bsan_wilayah_prov';
        const WILAYAH_KAB_KEY = 'bsan_wilayah_kab';

        function getWilayahLabel() {
            const prov = localStorage.getItem(WILAYAH_PROV_KEY);
            const kab = localStorage.getItem(WILAYAH_KAB_KEY);
            if (kab) return kab;
            if (prov) return prov;
            return '';
        }

        const ROLE_CONFIG = {
            kementerian: {
                label: 'Admin Kementerian Pusat',
                avatar: 'K',
                colorClass: 'role-btn__avatar--red',
                sidebarLabel: 'Kementerian Pusat'
            },
            dinas_prov: {
                get label() { const w = localStorage.getItem(WILAYAH_PROV_KEY); return w ? `Admin Dinas Prov. ${w}` : 'Admin Dinas Provinsi'; },
                avatar: 'P',
                colorClass: 'role-btn__avatar--blue',
                get sidebarLabel() { const w = localStorage.getItem(WILAYAH_PROV_KEY); return w ? `Dinas Prov. ${w}` : 'Dinas Provinsi'; }
            },
            dinas_kab: {
                get label() { const w = localStorage.getItem(WILAYAH_KAB_KEY); return w ? `Admin Dinas ${w}` : 'Admin Dinas Kab/Kota'; },
                avatar: 'D',
                colorClass: 'role-btn__avatar--green',
                get sidebarLabel() { const w = localStorage.getItem(WILAYAH_KAB_KEY); return w ? `Dinas ${w}` : 'Dinas Kab/Kota'; }
            }
        };

        function getActiveRole() {
            return localStorage.getItem(ROLE_KEY) || 'kementerian';
        }

        // ---- Wilayah Modal System ----
        let pendingRole = null;

        function switchRole(role) {
            if (role === 'dinas_prov') {
                pendingRole = role;
                openWilayahModal('prov');
            } else if (role === 'dinas_kab') {
                pendingRole = role;
                openWilayahModal('kab');
            } else {
                // Kementerian - no modal needed
                localStorage.removeItem(WILAYAH_PROV_KEY);
                localStorage.removeItem(WILAYAH_KAB_KEY);
                localStorage.setItem(ROLE_KEY, role);
                location.href = '/dashboard';
            }
        }

        function openWilayahModal(mode) {
            const modal = document.getElementById('wilayah-modal');
            const title = document.getElementById('wilayah-modal-title');
            const desc = document.getElementById('wilayah-modal-desc');
            const stepProv = document.getElementById('wilayah-step-prov');
            const stepKab = document.getElementById('wilayah-step-kab');
            const search = document.getElementById('wilayah-search');

            modal.dataset.mode = mode;
            search.value = '';

            if (mode === 'prov') {
                title.textContent = 'Pilih Provinsi';
                desc.textContent = 'Pilih provinsi untuk Admin Dinas Provinsi';
            } else {
                title.textContent = 'Pilih Wilayah';
                desc.textContent = 'Pilih provinsi terlebih dahulu, lalu pilih kabupaten/kota';
            }

            stepProv.style.display = '';
            stepKab.style.display = 'none';

            renderProvList();
            modal.classList.add('modal--open');
            search.focus();
        }

        function closeWilayahModal() {
            document.getElementById('wilayah-modal').classList.remove('modal--open');
            pendingRole = null;
        }

        function renderProvList(filter = '') {
            const list = document.getElementById('wilayah-prov-list');
            const provinces = Object.keys(WILAYAH_DATA).sort();
            const filtered = filter ? provinces.filter(p => p.toLowerCase().includes(filter.toLowerCase())) : provinces;

            if (filtered.length === 0) {
                list.innerHTML = '<p style="font-size:0.875rem;color:var(--dash-text-muted);padding:0.75rem;text-align:center">Tidak ditemukan</p>';
                return;
            }

            list.innerHTML = filtered.map(p => `
                <button onclick="selectProvinsi('${p.replace(/'/g, "\\'")}')"
                    class="sidebar__link" style="justify-content:space-between">
                    <span>${p}</span>
                    <svg class="icon-sm" style="color:var(--dash-text-light)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            `).join('');
        }

        function selectProvinsi(prov) {
            const modal = document.getElementById('wilayah-modal');
            const mode = modal.dataset.mode;

            if (mode === 'prov') {
                // Dinas Provinsi - just pick province and go
                localStorage.setItem(WILAYAH_PROV_KEY, prov);
                localStorage.removeItem(WILAYAH_KAB_KEY);
                localStorage.setItem(ROLE_KEY, pendingRole);
                closeWilayahModal();
                location.href = '/dashboard';
            } else {
                // Dinas Kab/Kota - show kabupaten list
                localStorage.setItem(WILAYAH_PROV_KEY, prov);
                document.getElementById('selected-prov-label').textContent = prov;
                document.getElementById('wilayah-step-prov').style.display = 'none';
                document.getElementById('wilayah-step-kab').style.display = '';
                document.getElementById('wilayah-search').value = '';
                document.getElementById('wilayah-modal-title').textContent = 'Pilih Kabupaten/Kota';
                renderKabList(prov);
            }
        }

        function renderKabList(prov, filter = '') {
            const list = document.getElementById('wilayah-kab-list');
            const kabList = (WILAYAH_DATA[prov] || []).sort();
            const filtered = filter ? kabList.filter(k => k.toLowerCase().includes(filter.toLowerCase())) : kabList;

            if (filtered.length === 0) {
                list.innerHTML = '<p style="font-size:0.875rem;color:var(--dash-text-muted);padding:0.75rem;text-align:center">Tidak ditemukan</p>';
                return;
            }

            list.innerHTML = filtered.map(k => `
                <button onclick="selectKabupaten('${k.replace(/'/g, "\\'")}')"
                    class="sidebar__link" style="justify-content:space-between">
                    <span>${k}</span>
                    <svg class="icon-sm" style="color:var(--dash-text-light)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </button>
            `).join('');
        }

        // Search kabupaten across ALL provinces (for typing "Kota Surakarta" etc)
        function searchKabAcrossProvinces(filter) {
            const list = document.getElementById('wilayah-kab-list');
            const results = [];
            for (const [prov, kabs] of Object.entries(WILAYAH_DATA)) {
                for (const k of kabs) {
                    if (k.toLowerCase().includes(filter.toLowerCase())) {
                        results.push({ prov, kab: k });
                    }
                }
            }
            results.sort((a, b) => a.kab.localeCompare(b.kab));

            if (results.length === 0) {
                list.innerHTML = '<p style="font-size:0.875rem;color:var(--dash-text-muted);padding:0.75rem;text-align:center">Tidak ditemukan</p>';
                return;
            }

            list.innerHTML = results.slice(0, 50).map(r => `
                <button onclick="selectKabFromSearch('${r.prov.replace(/'/g, "\\'")}', '${r.kab.replace(/'/g, "\\'")}')" 
                    class="sidebar__link" style="flex-direction:column;align-items:flex-start">
                    <span>${r.kab}</span>
                    <span style="font-size:0.75rem;color:var(--dash-text-muted)">${r.prov}</span>
                </button>
            `).join('');
        }

        function selectKabFromSearch(prov, kab) {
            localStorage.setItem(WILAYAH_PROV_KEY, prov);
            localStorage.setItem(WILAYAH_KAB_KEY, kab);
            localStorage.setItem(ROLE_KEY, pendingRole);
            closeWilayahModal();
            location.href = '/dashboard';
        }

        function selectKabupaten(kab) {
            localStorage.setItem(WILAYAH_KAB_KEY, kab);
            localStorage.setItem(ROLE_KEY, pendingRole);
            closeWilayahModal();
            location.href = '/dashboard';
        }

        function backToProvStep() {
            document.getElementById('wilayah-step-prov').style.display = '';
            document.getElementById('wilayah-step-kab').style.display = 'none';
            document.getElementById('wilayah-search').value = '';
            document.getElementById('wilayah-modal-title').textContent = 'Pilih Wilayah';
            renderProvList();
        }

        function filterWilayahList() {
            const search = document.getElementById('wilayah-search').value;
            const modal = document.getElementById('wilayah-modal');
            const mode = modal.dataset.mode;
            const stepKab = document.getElementById('wilayah-step-kab');
            const stepProv = document.getElementById('wilayah-step-prov');

            if (mode === 'kab' && stepProv.style.display !== 'none' && search.length >= 2) {
                stepProv.style.display = 'none';
                stepKab.style.display = '';
                document.getElementById('wilayah-modal-title').textContent = 'Hasil Pencarian';
                document.getElementById('selected-prov-label').textContent = 'Semua Provinsi';
                searchKabAcrossProvinces(search);
            } else if (stepKab.style.display === 'none') {
                renderProvList(search);
            } else if (mode === 'kab' && document.getElementById('selected-prov-label').textContent === 'Semua Provinsi') {
                if (search.length < 2) {
                    stepProv.style.display = '';
                    stepKab.style.display = 'none';
                    document.getElementById('wilayah-modal-title').textContent = 'Pilih Wilayah';
                    renderProvList(search);
                } else {
                    searchKabAcrossProvinces(search);
                }
            } else {
                const prov = localStorage.getItem(WILAYAH_PROV_KEY);
                renderKabList(prov, search);
            }
        }

        function resetDemoData() {
            if (!confirm('Reset semua data demo? Semua data Pokja, Pelaporan, dan Sumber Rujukan akan dihapus.')) return;
            const keys = Object.keys(localStorage).filter(k => k.startsWith('bsan_'));
            keys.forEach(k => { if (k !== ROLE_KEY) localStorage.removeItem(k); });
            location.reload();
        }

        function toggleProfileDropdown() {
            document.getElementById('profile-dropdown').classList.toggle('show');
        }

        // Close dropdown on outside click
        document.addEventListener('click', function(e) {
            const btn = document.getElementById('profile-btn');
            const dd = document.getElementById('profile-dropdown');
            if (!btn.contains(e.target) && !dd.contains(e.target)) {
                dd.classList.remove('show');
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('sidebar--open');
            overlay.style.display = sidebar.classList.contains('sidebar--open') ? 'block' : 'none';
        }

        // ---- Sidebar Builder ----
        function buildSidebar() {
            const role = getActiveRole();
            const cfg = ROLE_CONFIG[role];
            const currentPath = window.location.pathname.replace('/index.php', '');

            // Update header
            document.getElementById('user-avatar').textContent = cfg.avatar;
            document.getElementById('user-avatar').className = `profile-dropdown__avatar ${cfg.colorClass}`.replace('role-btn__avatar', 'profile-dropdown__avatar');
            // Apply avatar color via inline style based on role
            const avatarColors = { 'role-btn__avatar--red': '#dc2626', 'role-btn__avatar--blue': '#2563eb', 'role-btn__avatar--green': '#16a34a' };
            document.getElementById('user-avatar').style.background = avatarColors[cfg.colorClass] || '#2563eb';
            document.getElementById('user-role-label').textContent = cfg.label;
            document.getElementById('sidebar-role-label').textContent = cfg.sidebarLabel;

            // Highlight active role button
            document.querySelectorAll('.role-btn').forEach(btn => {
                const r = btn.getAttribute('data-role');
                if (r === role) {
                    btn.style.background = 'var(--dash-primary-light)';
                    btn.style.outline = '1px solid var(--dash-primary-text)';
                    btn.style.outlineOffset = '-1px';
                }
            });

            let items = [];
            if (role === 'kementerian') {
                items = [
                    { url: '/dashboard', label: 'Dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
                    { url: '/dashboard/sumber-rujukan', label: 'Sumber Rujukan', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
                    { url: '/dashboard/log-aktivitas', label: 'Log Aktivitas', icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01' },
                ];
            } else {
                items = [
                    { url: '/dashboard', label: 'Dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
                    { url: '/dashboard/pokja', label: 'Pokja', icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' },
                    { url: '/dashboard/pelaporan', label: 'Pelaporan', icon: 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
                    { url: '/dashboard/sumber-rujukan', label: 'Sumber Rujukan', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
                ];
            }

            const nav = document.getElementById('sidebar-nav');
            let html = '';
            items.forEach(item => {
                const isActive = (item.url === '/dashboard')
                    ? (currentPath === '/dashboard' || currentPath === '/dashboard/')
                    : currentPath.startsWith(item.url);
                const cls = isActive ? 'sidebar__link sidebar__link--active' : 'sidebar__link';
                html += `<a href="${item.url}" class="${cls}">
                    <svg class="sidebar__link-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${item.icon}" /></svg>
                    ${item.label}
                </a>`;
            });

            // Logout
            html += `<div style="padding-top:1rem;margin-top:1rem;border-top:1px solid var(--dash-border)">
                <a href="/auth/logout" class="sidebar__link dropdown-action--danger">
                    <svg class="sidebar__link-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Keluar
                </a>
            </div>`;

            nav.innerHTML = html;
        }

        // ---- Session User Info ----
        <?php if (session()->get('user_name')): ?>
            document.getElementById('user-name').textContent = '<?= session()->get('user_name') ?>';
        <?php endif; ?>

        // ---- Auto-set role & wilayah from PHP session ----
        <?php if (session()->get('user_role')): ?>
        (function() {
            const sessionRole = '<?= session()->get('user_role') ?>';
            const roleMap = {
                'admin': 'kementerian',
                'koordinator': 'kementerian',
                'dinas_prov': 'dinas_prov',
                'dinas_kab': 'dinas_kab'
            };
            const mappedRole = roleMap[sessionRole] || 'kementerian';

            // Store the base session role so JS knows the account type
            localStorage.setItem('bsan_session_role', sessionRole);

            // Admin/kementerian can switch roles freely — only set default on first visit
            if (sessionRole === 'admin' || sessionRole === 'koordinator') {
                // Don't override if user already picked a role via switchRole()
                if (!localStorage.getItem(ROLE_KEY)) {
                    localStorage.setItem(ROLE_KEY, mappedRole);
                }
            } else {
                // Dinas users are locked to their role
                localStorage.setItem(ROLE_KEY, mappedRole);
            }

            // Set wilayah from PHP session (for dinas users)
            <?php if (session()->get('wilayah_provinsi')): ?>
            // Only override wilayah for dinas users, not admin who may have switched
            if (sessionRole !== 'admin') {
                localStorage.setItem(WILAYAH_PROV_KEY, '<?= session()->get('wilayah_provinsi') ?>');
            }
            <?php endif; ?>
            <?php if (session()->get('wilayah_kabupaten')): ?>
            if (sessionRole !== 'admin') {
                localStorage.setItem(WILAYAH_KAB_KEY, '<?= session()->get('wilayah_kabupaten') ?>');
            }
            <?php else: ?>
            if (sessionRole !== 'admin') {
                localStorage.removeItem(WILAYAH_KAB_KEY);
            }
            <?php endif; ?>
        })();
        <?php endif; ?>

        // Init
        buildSidebar();
    </script>
    <?= $this->renderSection('scripts') ?>

    <!-- Admin Map Component -->
    <script src="/assets/js/admin-map.js"></script>
</body>

</html>
