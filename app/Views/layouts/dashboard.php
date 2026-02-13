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
            <div class="flex items-center gap-3 p-6 border-b border-gray-200 dark:border-[#3f4739]">
                <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Hitam.png" alt="Logo" class="h-10 w-auto block dark:hidden">
                <img src="/assets/icon/0 Logo Kemendikdasmen Puspeka Putih.png" alt="Logo" class="h-10 w-auto hidden dark:block">
                <div>
                    <h2 class="font-bold text-gray-900 dark:text-white text-sm">Sistem BSAN</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400" id="sidebar-role-label">Dashboard</p>
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

    <script src="/assets/js/app.js"></script>
    <script>
        // ---- Role System ----
        const ROLE_KEY = 'bsan_demo_role';
        const ROLE_CONFIG = {
            kementerian: {
                label: 'Admin Kementerian Pusat',
                avatar: 'K',
                color: 'bg-red-600',
                sidebarLabel: 'Kementerian Pusat'
            },
            dinas_prov: {
                label: 'Admin Dinas Provinsi',
                avatar: 'P',
                color: 'bg-blue-600',
                sidebarLabel: 'Dinas Provinsi'
            },
            dinas_kab: {
                label: 'Admin Dinas Kab/Kota',
                avatar: 'D',
                color: 'bg-green-600',
                sidebarLabel: 'Dinas Kab/Kota'
            }
        };

        function getActiveRole() {
            return localStorage.getItem(ROLE_KEY) || 'kementerian';
        }

        function switchRole(role) {
            localStorage.setItem(ROLE_KEY, role);
            location.href = '/dashboard';
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
