<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - Sistem BSAN</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: ['class', '[data-theme="dark"]'],
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@4.0.0/dist/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-dt@2.3.6/css/dataTables.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.6/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2/dist/umd/supabase.min.js"></script>
    <link href="/assets/css/app.css" rel="stylesheet">
    <script src="/assets/js/wilayah-data.js"></script>
    <style>
        .dropdown-menu { display: none; }
        .dropdown-menu.show { display: block; }
    </style>
    <?= $extra_head ?? '' ?>
</head>

<body class="min-h-screen bg-gray-50 dark:bg-[#0F0A0A]">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-[#0F0A0A] border-r border-gray-200 dark:border-[#3f4739] transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-200">
            <div class="p-6 border-b border-gray-200 dark:border-[#3f4739]">
                <div class="flex items-center gap-3">
                    <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Hitam.png" alt="Logo" class="h-10 w-auto block dark:hidden">
                    <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Putih.png" alt="Logo" class="h-10 w-auto hidden dark:block">
                    <div>
                        <h2 class="font-bold text-gray-900 dark:text-white text-sm">Sistem BSAN</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400" id="sidebar-role-label">Dashboard</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1" id="sidebar-nav">
                <!-- Populated by JS based on role -->
            </nav>
        </aside>

        <!-- Sidebar Overlay (mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white dark:bg-[#0F0A0A] border-b border-gray-200 dark:border-[#3f4739] px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="text-lg font-semibold text-gray-900 dark:text-white"><?= $pageTitle ?? 'Dashboard' ?></h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="theme-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739] text-gray-600 dark:text-gray-300">
                            <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/></svg>
                            <svg class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                        </button>
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button onclick="toggleProfileDropdown()" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739] transition-colors" id="profile-btn">
                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold" id="user-avatar">A</div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300" id="user-name">Admin Demo</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400" id="user-role-label">Admin Kementerian</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="profile-dropdown" class="dropdown-menu absolute right-0 mt-2 w-72 bg-white dark:bg-[#1a1414] rounded-xl border border-gray-200 dark:border-[#3f4739] shadow-xl z-50">
                                <div class="p-3 border-b border-gray-100 dark:border-[#3f4739]">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Ganti Peran Demo</p>
                                    <button onclick="switchRole('kementerian')" class="role-btn w-full text-left px-3 py-2 rounded-lg text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors flex items-center gap-3 mb-1" data-role="kementerian">
                                        <span class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 text-xs font-bold">K</span>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">Admin Kementerian Pusat</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Approval & monitoring</p>
                                        </div>
                                    </button>
                                    <button onclick="switchRole('dinas_prov')" class="role-btn w-full text-left px-3 py-2 rounded-lg text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors flex items-center gap-3 mb-1" data-role="dinas_prov">
                                        <span class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 text-xs font-bold">P</span>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">Admin Dinas Provinsi</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Kelola Pokja provinsi</p>
                                        </div>
                                    </button>
                                    <button onclick="switchRole('dinas_kab')" class="role-btn w-full text-left px-3 py-2 rounded-lg text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors flex items-center gap-3" data-role="dinas_kab">
                                        <span class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 text-xs font-bold">D</span>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">Admin Dinas Kab/Kota</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Kelola Pokja kabupaten/kota</p>
                                        </div>
                                    </button>
                                </div>
                                <div class="p-2">
                                    <button onclick="resetDemoData()" class="w-full text-left px-3 py-2 rounded-lg text-sm text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Reset Data Demo
                                    </button>
                                    <a href="/auth/logout" class="w-full text-left px-3 py-2 rounded-lg text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Wilayah Selection Modal -->
    <div id="wilayah-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeWilayahModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-[#1a1414] rounded-2xl border border-gray-200 dark:border-[#3f4739] shadow-2xl w-full max-w-md max-h-[90vh] overflow-hidden">
                <div class="p-5 border-b border-gray-200 dark:border-[#3f4739]">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="wilayah-modal-title">Pilih Wilayah</h3>
                        <button onclick="closeWilayahModal()" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739] text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" id="wilayah-modal-desc">Pilih provinsi untuk melanjutkan</p>
                </div>
                <div class="p-5 space-y-4 overflow-y-auto" style="max-height: 60vh;">
                    <!-- Search -->
                    <div>
                        <input type="text" id="wilayah-search" placeholder="Cari wilayah..." class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#0F0A0A] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" oninput="filterWilayahList()">
                    </div>
                    <!-- Provinsi Step -->
                    <div id="wilayah-step-prov">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Provinsi <span class="text-red-500">*</span></label>
                        <div id="wilayah-prov-list" class="space-y-1"></div>
                    </div>
                    <!-- Kabupaten Step (hidden initially) -->
                    <div id="wilayah-step-kab" class="hidden">
                        <button onclick="backToProvStep()" class="flex items-center gap-1 text-sm text-blue-600 dark:text-blue-400 hover:underline mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Kembali ke Provinsi
                        </button>
                        <div class="mb-2">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Provinsi:</span>
                            <span id="selected-prov-label" class="text-sm font-semibold text-gray-900 dark:text-white ml-1"></span>
                        </div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kabupaten/Kota <span class="text-red-500">*</span></label>
                        <div id="wilayah-kab-list" class="space-y-1"></div>
                    </div>
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
                color: 'bg-red-600',
                sidebarLabel: 'Kementerian Pusat'
            },
            dinas_prov: {
                get label() { const w = localStorage.getItem(WILAYAH_PROV_KEY); return w ? `Admin Dinas Prov. ${w}` : 'Admin Dinas Provinsi'; },
                avatar: 'P',
                color: 'bg-blue-600',
                get sidebarLabel() { const w = localStorage.getItem(WILAYAH_PROV_KEY); return w ? `Dinas Prov. ${w}` : 'Dinas Provinsi'; }
            },
            dinas_kab: {
                get label() { const w = localStorage.getItem(WILAYAH_KAB_KEY); return w ? `Admin Dinas ${w}` : 'Admin Dinas Kab/Kota'; },
                avatar: 'D',
                color: 'bg-green-600',
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

            stepProv.classList.remove('hidden');
            stepKab.classList.add('hidden');

            renderProvList();
            modal.classList.remove('hidden');
            search.focus();
        }

        function closeWilayahModal() {
            document.getElementById('wilayah-modal').classList.add('hidden');
            pendingRole = null;
        }

        function renderProvList(filter = '') {
            const list = document.getElementById('wilayah-prov-list');
            const provinces = Object.keys(WILAYAH_DATA).sort();
            const filtered = filter ? provinces.filter(p => p.toLowerCase().includes(filter.toLowerCase())) : provinces;

            if (filtered.length === 0) {
                list.innerHTML = '<p class="text-sm text-gray-400 py-3 text-center">Tidak ditemukan</p>';
                return;
            }

            list.innerHTML = filtered.map(p => `
                <button onclick="selectProvinsi('${p.replace(/'/g, "\\'")}')"
                    class="w-full text-left px-4 py-2.5 rounded-lg text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors flex items-center justify-between group border border-transparent hover:border-blue-200 dark:hover:border-blue-800">
                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-700 dark:group-hover:text-blue-400">${p}</span>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
                document.getElementById('wilayah-step-prov').classList.add('hidden');
                document.getElementById('wilayah-step-kab').classList.remove('hidden');
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
                list.innerHTML = '<p class="text-sm text-gray-400 py-3 text-center">Tidak ditemukan</p>';
                return;
            }

            list.innerHTML = filtered.map(k => `
                <button onclick="selectKabupaten('${k.replace(/'/g, "\\'")}')"
                    class="w-full text-left px-4 py-2.5 rounded-lg text-sm hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors flex items-center justify-between group border border-transparent hover:border-green-200 dark:hover:border-green-800">
                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-green-700 dark:group-hover:text-green-400">${k}</span>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
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
                list.innerHTML = '<p class="text-sm text-gray-400 py-3 text-center">Tidak ditemukan</p>';
                return;
            }

            list.innerHTML = results.slice(0, 50).map(r => `
                <button onclick="selectKabFromSearch('${r.prov.replace(/'/g, "\\\'")}', '${r.kab.replace(/'/g, "\\\'")}')" 
                    class="w-full text-left px-4 py-2.5 rounded-lg text-sm hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors group border border-transparent hover:border-green-200 dark:hover:border-green-800">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-gray-300 group-hover:text-green-700 dark:group-hover:text-green-400">${r.kab}</span>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-xs text-gray-400">${r.prov}</span>
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
            document.getElementById('wilayah-step-prov').classList.remove('hidden');
            document.getElementById('wilayah-step-kab').classList.add('hidden');
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

            if (mode === 'kab' && stepProv.classList.contains('hidden') === false && search.length >= 2) {
                // In kab mode, still on prov step but user is typing — search kabupaten across all provinces
                stepProv.classList.add('hidden');
                stepKab.classList.remove('hidden');
                document.getElementById('wilayah-modal-title').textContent = 'Hasil Pencarian';
                document.getElementById('selected-prov-label').textContent = 'Semua Provinsi';
                searchKabAcrossProvinces(search);
            } else if (stepKab.classList.contains('hidden')) {
                // Filtering provinces
                renderProvList(search);
            } else if (mode === 'kab' && document.getElementById('selected-prov-label').textContent === 'Semua Provinsi') {
                // We were searching across all provinces
                if (search.length < 2) {
                    // Go back to prov list
                    stepProv.classList.remove('hidden');
                    stepKab.classList.add('hidden');
                    document.getElementById('wilayah-modal-title').textContent = 'Pilih Wilayah';
                    renderProvList(search);
                } else {
                    searchKabAcrossProvinces(search);
                }
            } else {
                // Filtering kabupaten within selected province
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
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // ---- Sidebar Builder ----
        function buildSidebar() {
            const role = getActiveRole();
            const cfg = ROLE_CONFIG[role];
            const currentPath = window.location.pathname.replace('/index.php', '');

            // Update header
            document.getElementById('user-avatar').textContent = cfg.avatar;
            document.getElementById('user-avatar').className = `w-8 h-8 rounded-full ${cfg.color} flex items-center justify-center text-white text-sm font-bold`;
            document.getElementById('user-role-label').textContent = cfg.label;
            document.getElementById('sidebar-role-label').textContent = cfg.sidebarLabel;

            // Highlight active role button
            document.querySelectorAll('.role-btn').forEach(btn => {
                const r = btn.getAttribute('data-role');
                if (r === role) {
                    btn.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'ring-1', 'ring-blue-300', 'dark:ring-blue-700');
                }
            });

            let items = [];
            if (role === 'kementerian') {
                items = [
                    { url: '/dashboard', label: 'Dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
                    { url: '/dashboard/sumber-rujukan', label: 'Sumber Rujukan', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
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
                const cls = isActive
                    ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-[#3f4739]';
                html += `<a href="${item.url}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors ${cls}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${item.icon}" /></svg>
                    ${item.label}
                </a>`;
            });

            // Logout
            html += `<div class="pt-4 border-t border-gray-200 dark:border-[#3f4739]">
                <a href="/auth/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Keluar
                </a>
            </div>`;

            nav.innerHTML = html;
        }

        // ---- Session User Info ----
        <?php if (session()->get('user_name')): ?>
            document.getElementById('user-name').textContent = '<?= session()->get('user_name') ?>';
        <?php endif; ?>

        // Init
        buildSidebar();
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
