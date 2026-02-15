<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<!-- Admin Kementerian Dashboard -->
<div id="view-kementerian" style="display:none" class="space-y-6">
    <!-- Header with Toggle -->
    <div class="d-flex d-flex--between" style="flex-wrap:wrap;gap:0.75rem">
        <div>
            <h2 class="dash-card__title" style="font-size:1.25rem">Dashboard Admin Kementerian Pusat</h2>
            <p class="dash-card__subtitle">Monitoring dan approval Pokja seluruh wilayah</p>
        </div>
        <div class="d-flex d-flex--gap-3" style="align-items:center">
            <label style="position:relative;display:inline-flex;align-items:center;cursor:pointer">
                <input type="checkbox" id="demo-data-toggle" style="position:absolute;opacity:0;width:0;height:0" onchange="toggleDataMode(this.checked)">
                <span class="toggle-track"></span>
            </label>
            <span style="font-size:0.875rem;font-weight:500;color:var(--dash-text-secondary)" id="data-mode-label">Entry Data</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stat-cards" style="grid-template-columns:repeat(2,1fr)">
        <style>@media(min-width:640px){.stat-cards--6{grid-template-columns:repeat(3,1fr)!important}}@media(min-width:1024px){.stat-cards--6{grid-template-columns:repeat(6,1fr)!important}}.toggle-track{width:2.75rem;height:1.5rem;background:var(--dash-border);border-radius:9999px;position:relative;transition:background 200ms}.toggle-track::after{content:'';position:absolute;top:2px;left:2px;width:1.25rem;height:1.25rem;background:#fff;border-radius:9999px;transition:transform 200ms}input:checked+.toggle-track{background:#2563eb}input:checked+.toggle-track::after{transform:translateX(1.25rem)}</style>
        <div class="stat-cards--6 stat-card">
            <div class="stat-card__icon stat-card__icon--blue" style="width:2rem;height:2rem"><svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <p class="stat-card__label">Wilayah</p>
            <p class="stat-card__value" id="stat-total">552</p>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--blue" style="width:2rem;height:2rem"><svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
            <p class="stat-card__label" style="color:#2563eb">Total Anggota</p>
            <p class="stat-card__value" style="color:#1d4ed8" id="stat-members">0</p>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon" style="width:2rem;height:2rem;background:#cffafe;color:#0891b2"><svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
            <p class="stat-card__label" style="color:#0891b2">Laki-laki</p>
            <p class="stat-card__value" style="color:#0e7490" id="stat-male">0</p>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon" style="width:2rem;height:2rem;background:#fce7f3;color:#db2777"><svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
            <p class="stat-card__label" style="color:#db2777">Perempuan</p>
            <p class="stat-card__value" style="color:#be185d" id="stat-female">0</p>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--amber" style="width:2rem;height:2rem"><svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <p class="stat-card__label" style="color:#d97706">Pending</p>
            <p class="stat-card__value" style="color:#b45309" id="stat-pending">0</p>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--green" style="width:2rem;height:2rem"><svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <p class="stat-card__label" style="color:#16a34a">Disetujui</p>
            <p class="stat-card__value" style="color:#15803d" id="stat-approved">0</p>
        </div>
    </div>

    <!-- Tooltip element -->
    <div id="admin-tooltip" style="position:fixed;z-index:9999;padding:8px 16px;border-radius:8px;font-size:0.875rem;color:#fff;pointer-events:none;display:none;white-space:nowrap;box-shadow:0 4px 12px rgba(0,0,0,0.15);font-weight:500;"></div>

    <!-- Donut Charts Row -->
    <style>
        .admin-donut-card { text-align: center; }
        .admin-donut-card h3 { font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
        .admin-donut-wrap { display: flex; justify-content: center; align-items: center; flex-direction: column; }
        .admin-donut-container { position: relative; width: 200px; height: 200px; margin: 0 auto; }
        .admin-donut-container svg circle[id] { cursor: pointer; transition: opacity 0.15s; }
        .admin-donut-container svg circle[id]:hover { opacity: 0.8; }
        .admin-donut-center { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none; }
        .admin-donut-center__label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.6; }
        .admin-donut-center__value { font-size: 26px; font-weight: 700; line-height: 1.2; }
        .admin-donut-center__pct { font-size: 13px; font-weight: 600; }
        .admin-donut-legend { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-top: 12px; font-size: 12px; }
        .admin-donut-legend span { display: flex; align-items: center; gap: 5px; }
        .admin-donut-legend i { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
    </style>
    <div class="dash-grid--3">
        <!-- Donut 1: Status Pengajuan -->
        <div class="dash-card admin-donut-card">
            <h3 class="text-gray-900 dark:text-white justify-center"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>Status Pengajuan Pokja</h3>
            <div class="admin-donut-wrap">
                <div class="admin-donut-container">
                    <svg width="200" height="200" viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="78" fill="none" stroke="#e5e7eb" stroke-width="22"></circle>
                        <circle id="donut-st-approved" cx="100" cy="100" r="78" fill="none" stroke="#10b981" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 490" transform="rotate(-90 100 100)"></circle>
                        <circle id="donut-st-pending" cx="100" cy="100" r="78" fill="none" stroke="#f59e0b" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 490" transform="rotate(-90 100 100)"></circle>
                        <circle id="donut-st-draft" cx="100" cy="100" r="78" fill="none" stroke="#6b7280" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 490" transform="rotate(-90 100 100)"></circle>
                        <circle id="donut-st-declined" cx="100" cy="100" r="78" fill="none" stroke="#ef4444" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 490" transform="rotate(-90 100 100)"></circle>
                    </svg>
                    <div class="admin-donut-center">
                        <span class="admin-donut-center__label text-gray-500 dark:text-gray-400">TOTAL</span>
                        <span class="admin-donut-center__value text-gray-900 dark:text-white" id="donut-st-value">0</span>
                        <span class="admin-donut-center__pct text-emerald-600" id="donut-st-pct">0%</span>
                    </div>
                </div>
                <div class="admin-donut-legend text-gray-600 dark:text-gray-400">
                    <span><i style="background:#10b981"></i>Disetujui (<b id="donut-st-a">0</b>)</span>
                    <span><i style="background:#f59e0b"></i>Pending (<b id="donut-st-p">0</b>)</span>
                    <span><i style="background:#6b7280"></i>Draft (<b id="donut-st-d">0</b>)</span>
                    <span><i style="background:#ef4444"></i>Ditolak (<b id="donut-st-r">0</b>)</span>
                </div>
            </div>
        </div>
        <!-- Donut 2: Persentase Pokja Provinsi -->
        <div class="dash-card admin-donut-card">
            <h3 class="text-gray-900 dark:text-white justify-center"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Persentase Pokja Provinsi</h3>
            <div class="admin-donut-wrap">
                <div class="admin-donut-container">
                    <svg width="200" height="200" viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="78" fill="none" stroke="#e5e7eb" stroke-width="22"></circle>
                        <circle id="donut-prov-red" cx="100" cy="100" r="78" fill="none" stroke="#ef4444" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 490" transform="rotate(-90 100 100)"></circle>
                        <circle id="donut-prov-green" cx="100" cy="100" r="78" fill="none" stroke="#22c55e" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 490" transform="rotate(-90 100 100)"></circle>
                    </svg>
                    <div class="admin-donut-center">
                        <span class="admin-donut-center__label text-gray-500 dark:text-gray-400">PROVINSI</span>
                        <span class="admin-donut-center__value text-gray-900 dark:text-white" id="donut-prov-value">0/38</span>
                        <span class="admin-donut-center__pct text-emerald-600" id="donut-prov-pct">0%</span>
                    </div>
                </div>
                <div class="admin-donut-legend text-gray-600 dark:text-gray-400">
                    <span><i style="background:#22c55e"></i>Terbentuk (<b id="donut-prov-yes">0</b>)</span>
                    <span><i style="background:#ef4444"></i>Belum (<b id="donut-prov-no">0</b>)</span>
                </div>
            </div>
        </div>
        <!-- Donut 3: Persentase Pokja Kab/Kota -->
        <div class="dash-card admin-donut-card">
            <h3 class="text-gray-900 dark:text-white justify-center"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Persentase Pokja Kab/Kota</h3>
            <div class="admin-donut-wrap">
                <div class="admin-donut-container">
                    <svg width="200" height="200" viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="78" fill="none" stroke="#e5e7eb" stroke-width="22"></circle>
                        <circle id="donut-kab-red" cx="100" cy="100" r="78" fill="none" stroke="#ef4444" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 490" transform="rotate(-90 100 100)"></circle>
                        <circle id="donut-kab-green" cx="100" cy="100" r="78" fill="none" stroke="#22c55e" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 490" transform="rotate(-90 100 100)"></circle>
                    </svg>
                    <div class="admin-donut-center">
                        <span class="admin-donut-center__label text-gray-500 dark:text-gray-400">KAB/KOTA</span>
                        <span class="admin-donut-center__value text-gray-900 dark:text-white" id="donut-kab-value">0/514</span>
                        <span class="admin-donut-center__pct text-emerald-600" id="donut-kab-pct">0%</span>
                    </div>
                </div>
                <div class="admin-donut-legend text-gray-600 dark:text-gray-400">
                    <span><i style="background:#22c55e"></i>Terbentuk (<b id="donut-kab-yes">0</b>)</span>
                    <span><i style="background:#ef4444"></i>Belum (<b id="donut-kab-no">0</b>)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Gender Chart -->
    <div class="dash-card">
        <h3 class="dash-card__title" style="font-size:0.875rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem"><svg class="icon-sm" style="color:#7c3aed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>Komposisi Gender per Jabatan</h3>
        <div style="position:relative;height:260px;"><canvas id="chart-gender"></canvas></div>
    </div>

    <!-- Admin Map -->
    <div class="dash-card">
        <h3 class="dash-card__title" style="font-size:0.875rem;display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem">
            <svg class="icon-sm" style="color:#16a34a" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Peta Sebaran Pokja
        </h3>
        <div id="admin-map-container" style="min-height:420px;"></div>
    </div>

    <div class="dash-card">
        <h3 class="dash-card__title" style="font-size:0.875rem;display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem"><svg class="icon-sm" style="color:#ea580c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>Log Pengajuan Pokja</h3>
        <!-- Search + Filter -->
        <div class="d-flex d-flex--between d-flex--wrap d-flex--gap-3" style="margin-bottom:1rem">
            <div class="d-flex d-flex--gap-2" style="align-items:center">
                <input id="log-search" type="text" placeholder="Cari wilayah..." oninput="logFilterChanged()" class="form-input" style="width:14rem;padding:0.375rem 0.75rem" />
                <select id="log-status-filter" onchange="logFilterChanged()" class="form-select" style="padding:0.375rem 0.75rem;width:auto">
                    <option value="">Semua Status</option>
                    <option value="approved">Disetujui</option>
                    <option value="pending">Pending</option>
                    <option value="draft">Draft</option>
                    <option value="declined">Ditolak</option>
                </select>
                <select id="log-jenis-filter" onchange="logFilterChanged()" class="form-select" style="padding:0.375rem 0.75rem;width:auto">
                    <option value="">Semua Jenis</option>
                    <option value="dinas_prov">Provinsi</option>
                    <option value="dinas_kab">Kab/Kota</option>
                </select>
            </div>
            <span id="log-count" style="font-size:0.75rem;color:var(--dash-text-muted)"></span>
        </div>
        <div class="dash-table__wrapper">
            <table class="dash-table">
                <thead><tr>
                    <th>Wilayah</th>
                    <th>Jenis</th>
                    <th>Anggota</th>
                    <th>L / P</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr></thead>
                <tbody id="log-tbody"></tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div id="log-pagination" class="d-flex d-flex--between" style="margin-top:1rem;font-size:0.875rem;color:var(--dash-text-muted)">
            <span id="log-page-info"></span>
            <div id="log-page-buttons" class="d-flex d-flex--gap-1"></div>
        </div>
        <div id="log-empty" style="display:none" class="dash-table__empty">Belum ada pengajuan Pokja.</div>
    </div>
</div>

<!-- Admin Dinas Dashboard -->
<div id="view-dinas" style="display:none" class="space-y-6">
    <div>
        <h2 class="dash-card__title" style="font-size:1.25rem" id="dinas-title">Dashboard</h2>
        <p class="dash-card__subtitle" id="dinas-subtitle">Kelola Pokja daerah Anda</p>
    </div>

    <!-- Decline Banner -->
    <div id="decline-banner" style="display:none" class="dash-alert dash-alert--danger" >
        <div style="display:flex;align-items:flex-start;gap:0.75rem">
            <svg style="width:1.25rem;height:1.25rem;color:#dc2626;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p style="font-weight:600">Pengajuan Ditolak</p>
                <p style="font-size:0.875rem;margin-top:0.25rem" id="decline-reason"></p>
            </div>
        </div>
    </div>

    <!-- Pending Banner -->
    <div id="pending-banner" style="display:none" class="dash-alert dash-alert--warning">
        <div style="display:flex;align-items:flex-start;gap:0.75rem">
            <svg style="width:1.25rem;height:1.25rem;color:#d97706;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p style="font-weight:600">⏳ Menunggu Approval</p>
                <p style="font-size:0.875rem;margin-top:0.25rem">Pengajuan Pokja sedang diproses oleh Admin Pusat.</p>
            </div>
        </div>
    </div>

    <!-- Approved Banner -->
    <div id="approved-banner" style="display:none" class="dash-alert dash-alert--success">
        <div style="display:flex;align-items:flex-start;gap:0.75rem">
            <svg style="width:1.25rem;height:1.25rem;color:#16a34a;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p style="font-weight:600">✅ Pokja Disetujui</p>
                <p style="font-size:0.875rem;margin-top:0.25rem">Pokja Anda telah disetujui oleh Admin Pusat.</p>
            </div>
        </div>
    </div>

    <!-- SK Card Spotlight -->
    <div style="background:linear-gradient(to right,#2563eb,#1e40af);border-radius:0.75rem;padding:1.5rem;color:#fff">
        <p style="font-size:0.875rem;opacity:0.8;margin-bottom:0.25rem">Nomor SK Pokja</p>
        <p style="font-size:1.5rem;font-weight:700" id="sk-nomor-display">-</p>
    </div>

    <!-- Status Cards -->
    <div class="dash-grid--3">
        <div class="stat-card">
            <p class="stat-card__label">Status Pokja</p>
            <p class="stat-card__value" id="status-pokja">Belum Ada</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__label">Masa Berlaku SK</p>
            <p class="stat-card__value" id="masa-berlaku">-</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__label">Status Pengajuan</p>
            <p class="stat-card__value" id="status-pengajuan">-</p>
        </div>
    </div>

    <!-- Bentuk Pokja Button -->
    <div id="bentuk-pokja-section" style="text-align:center;padding:1.5rem 0">
        <a href="/dashboard/pokja" class="btn-dash btn-dash--primary" style="display:inline-flex;align-items:center;gap:0.5rem;font-size:1.125rem;padding:0.75rem 1.5rem">
            <svg style="width:1.5rem;height:1.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Bentuk Pokja
        </a>
    </div>

    <!-- Quick Links (Dinas only) -->
    <div class="dash-card">
        <h2 class="dash-card__title" style="margin-bottom:1rem">Menu Cepat</h2>
        <div class="dash-grid--4">
            <a href="/dashboard" class="quick-link" style="display:flex;flex-direction:column;align-items:center;padding:1rem;border-radius:0.75rem;background:var(--dash-bg-card-alt);text-decoration:none;transition:opacity 0.15s">
                <svg style="width:2rem;height:2rem;color:var(--dash-text-secondary);margin-bottom:0.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <span style="font-size:0.875rem;font-weight:500;color:var(--dash-text-primary)">Dashboard</span>
            </a>
            <a href="/dashboard/pokja" class="quick-link" style="display:flex;flex-direction:column;align-items:center;padding:1rem;border-radius:0.75rem;background:var(--dash-bg-card-alt);text-decoration:none;transition:opacity 0.15s">
                <svg style="width:2rem;height:2rem;color:#2563eb;margin-bottom:0.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span style="font-size:0.875rem;font-weight:500;color:#2563eb">Pokja</span>
            </a>
            <a href="/dashboard/pelaporan" class="quick-link" style="display:flex;flex-direction:column;align-items:center;padding:1rem;border-radius:0.75rem;background:var(--dash-bg-card-alt);text-decoration:none;transition:opacity 0.15s">
                <svg style="width:2rem;height:2rem;color:#ea580c;margin-bottom:0.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <span style="font-size:0.875rem;font-weight:500;color:#ea580c">Pelaporan</span>
            </a>
            <a href="/dashboard/sumber-rujukan" class="quick-link" style="display:flex;flex-direction:column;align-items:center;padding:1rem;border-radius:0.75rem;background:var(--dash-bg-card-alt);text-decoration:none;transition:opacity 0.15s">
                <svg style="width:2rem;height:2rem;color:#0d9488;margin-bottom:0.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                <span style="font-size:0.875rem;font-weight:500;color:#0d9488">Sumber Rujukan</span>
            </a>
        </div>
    </div>
</div>

<!-- Kementerian: Detail Modal -->
<div id="detail-approval-modal" class="modal" style="display:none">
    <div class="modal__backdrop" onclick="closeApprovalModal()"></div>
    <div class="modal__container" style="max-width:42rem">
        <div class="modal__content">
            <div class="modal__header">
                <h3 class="modal__title">Detail Pengajuan Pokja</h3>
                <button onclick="closeApprovalModal()" class="modal__close">
                    <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="approval-detail-content" class="p-6 space-y-4"></div>
            <!-- PDF Preview Section -->
            <div id="pdf-preview-section" class="hidden px-6 pb-4">
                <div class="bg-gray-50 dark:bg-[#1a1414] border border-gray-200 dark:border-[#3f4739] rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            Preview Dokumen SK
                        </h4>
                        <button id="pdf-open-tab" onclick="openPdfInNewTab()" class="inline-flex items-center gap-1.5 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Buka di Tab Baru
                        </button>
                    </div>
                    <div id="pdf-preview-frame" class="rounded-lg overflow-hidden bg-white dark:bg-gray-900 border border-gray-200 dark:border-[#3f4739]" style="height: 400px;">
                        <div class="flex items-center justify-center h-full text-gray-400">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <p class="text-sm font-medium" id="pdf-filename">dokumen.pdf</p>
                                <p class="text-xs text-gray-400 mt-1">Preview PDF (mode demo)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Action History -->
            <div id="action-history-section" class="hidden px-6 pb-4">
                <div class="bg-gray-50 dark:bg-[#1a1414] border border-gray-200 dark:border-[#3f4739] rounded-xl p-4">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Riwayat Aksi</h4>
                    <div id="action-history-list" class="space-y-2 text-sm"></div>
                </div>
            </div>
            <div id="approval-actions" style="padding:0 1.5rem 1.5rem;display:flex;gap:0.75rem">
                <button onclick="showDeclineForm()" class="btn-dash btn-dash--outline" style="flex:1;border-color:#dc2626;color:#dc2626">Tolak</button>
                <button onclick="approvePokja()" class="btn-dash btn-dash--success" style="flex:1">Setujui</button>
            </div>
            <div id="decline-form" style="display:none;padding:0 1.5rem 1.5rem" class="space-y-3">
                <label class="form-label">Alasan Penolakan</label>
                <textarea id="decline-reason-input" rows="3" class="form-input" style="resize:none" placeholder="Jelaskan alasan penolakan..."></textarea>
                <div style="display:flex;gap:0.75rem">
                    <button onclick="cancelDecline()" class="btn-dash btn-dash--outline" style="flex:1">Batal</button>
                    <button onclick="declinePokja()" class="btn-dash btn-dash--danger" style="flex:1">Tolak Pengajuan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const POKJA_SUBMISSIONS_KEY = 'bsan_pokja_submissions';
    const POKJA_ACTION_LOG_KEY = 'bsan_pokja_action_log';
    let currentApprovalIdx = -1;
    let _cachedDemoData = null; // cache demo data to avoid re-generation
    let _activeSubs = [];       // current active submissions (for detail modal)
    let _logPage = 1;
    const _logPerPage = 25;

    function getSubmissions() { return JSON.parse(localStorage.getItem(POKJA_SUBMISSIONS_KEY) || '[]'); }
    function saveSubmissions(d) { localStorage.setItem(POKJA_SUBMISSIONS_KEY, JSON.stringify(d)); _cachedDemoData = null; }
    function getActionLog() { return JSON.parse(localStorage.getItem(POKJA_ACTION_LOG_KEY) || '[]'); }
    function saveActionLog(log) { localStorage.setItem(POKJA_ACTION_LOG_KEY, JSON.stringify(log)); }

    function addActionLogEntry(action, wilayah, reason) {
        const log = getActionLog();
        log.unshift({
            action,
            wilayah,
            reason: reason || '',
            admin: '<?= session()->get('user_name') ?? 'Admin Demo' ?>',
            timestamp: new Date().toISOString(),
        });
        saveActionLog(log);
    }

    function initDashboard() {
        const role = localStorage.getItem('bsan_demo_role') || 'kementerian';
        if (role === 'kementerian') {
            document.getElementById('view-kementerian').style.display = '';
            renderKementerianDashboard();
        } else {
            document.getElementById('view-dinas').style.display = '';
            renderDinasDashboard(role);
        }
    }

    let genderChart = null;
    const DEMO_DATA_KEY = 'bsan_demo_data_mode';

    function generateDemoData() {
        // Seeded random for deterministic demo data
        let _seed = 42;
        function srand() { _seed = (_seed * 16807 + 0) % 2147483647; return (_seed & 0x7fffffff) / 0x7fffffff; }

        const W = typeof WILAYAH_DATA !== 'undefined' ? WILAYAH_DATA : (typeof wilayahData !== 'undefined' ? wilayahData : {});
        const provNames = Object.keys(W);
        if (provNames.length === 0) return [];

        const statuses = ['approved', 'pending', 'draft', 'declined'];
        const statusWeights = [0.45, 0.25, 0.15, 0.15]; // realistic distribution
        const randomNames = ['Budi Santoso','Siti Aminah','Ahmad Fauzi','Dewi Lestari','Eko Prasetyo','Rina Marlina','Hendra Wijaya','Nurul Hidayah','Dian Sari','Agus Setiawan','Putri Wulandari','Bambang Hartono','Sri Mulyani','Roni Akbar','Yuni Rahayu','Wahyu Hidayat','Fitriani','Andi Saputra','Lina Susanti','Joko Widodo'];
        const randomEmails = (name) => name.toLowerCase().replace(/\s+/g, '.') + '@dinas.go.id';
        const genders = ['L','L','P','L','P','P','L','P','L'];

        function pickStatus() {
            const r = srand();
            let cum = 0;
            for (let i = 0; i < statuses.length; i++) { cum += statusWeights[i]; if (r <= cum) return statuses[i]; }
            return statuses[0];
        }

        function buildStruktur(seed) {
            const struktur = {};
            const roles = [
                { key: 'ketua', jabatan: 'Ketua Pokja' },
                { key: 'wakil', jabatan: 'Wakil Ketua' },
                { key: 'koordinator', jabatan: 'Koordinator' },
            ];
            roles.forEach((r, ri) => {
                const name = randomNames[(seed + ri) % randomNames.length];
                struktur[r.key] = { nama: name, email: randomEmails(name), jabatan: r.jabatan, jenisKelamin: genders[ri], noWa: '0812345678' + ri, nomorInstansi: '0211234567' + ri };
            });
            const anggotaBidang = ['Bidang Pendidikan','Bidang Kesehatan','Bidang Sosial','Bidang Hukum','Bidang Ekonomi','Bidang Lingkungan'];
            struktur.anggota = anggotaBidang.map((b, bi) => {
                const name = randomNames[(seed + 3 + bi) % randomNames.length];
                return { bidang: b, nama: name, email: randomEmails(name), jabatan: 'Anggota', jenisKelamin: genders[(3 + bi) % genders.length], noWa: '0813456789' + bi, nomorInstansi: '0212345678' + bi };
            });
            return struktur;
        }

        function buildEntry(wilayah, roleType, status, idx) {
            return {
                wilayah, roleType, status,
                namaPokja: 'Pokja BSAN ' + wilayah,
                nomorSK: status !== 'draft' ? `${100 + idx}/SK/${2025 + (idx % 2)}` : '',
                periodeMulai: '2025-01-01', periodeSelesai: '2029-12-31',
                callCenterPokja: '08001234567',
                struktur: buildStruktur(idx),
                createdAt: new Date(2025, idx % 12, 1 + (idx % 28)).toISOString(),
                submittedAt: status !== 'draft' ? new Date(2025, 6, 1 + (idx % 28)).toISOString() : null,
                approvedAt: status === 'approved' ? new Date(2025, 7, 1 + (idx % 28)).toISOString() : null,
                approvedBy: status === 'approved' ? 'Admin Pusat' : null,
                declinedAt: status === 'declined' ? new Date(2025, 7, 15).toISOString() : null,
                declinedBy: status === 'declined' ? 'Admin Pusat' : null,
                declineReason: status === 'declined' ? 'Dokumen SK belum lengkap' : null,
            };
        }

        const result = [];
        let idx = 0;

        // Generate entries for all 38 provinces
        provNames.forEach(prov => {
            result.push(buildEntry('Prov. ' + prov, 'dinas_prov', pickStatus(), idx++));

            // Generate entries for all kab/kota in this province
            const kabList = W[prov] || [];
            kabList.forEach(kab => {
                result.push(buildEntry(kab, 'dinas_kab', pickStatus(), idx++));
            });
        });

        return result;
    }

    function toggleDataMode(isDemoOn) {
        _cachedDemoData = null;
        _logPage = 1;
        localStorage.setItem(DEMO_DATA_KEY, isDemoOn ? 'demo' : 'entry');
        document.getElementById('data-mode-label').textContent = isDemoOn ? 'Data Demo' : 'Entry Data';
        renderKementerianDashboard();
    }

    function getActiveSubmissions() {
        const mode = localStorage.getItem(DEMO_DATA_KEY) || 'entry';
        if (mode === 'demo') {
            if (!_cachedDemoData) _cachedDemoData = generateDemoData();
            return _cachedDemoData;
        }
        return getSubmissions();
    }

    function countGender(subs) {
        let male = 0, female = 0;
        subs.forEach(s => {
            if (!s.struktur) return;
            ['ketua','wakil','koordinator'].forEach(k => { if (s.struktur[k]?.jenisKelamin === 'L') male++; if (s.struktur[k]?.jenisKelamin === 'P') female++; });
            (s.struktur.anggota || []).forEach(a => { if (a.jenisKelamin === 'L') male++; if (a.jenisKelamin === 'P') female++; });
        });
        return { male, female };
    }

    function countGenderByRole(subs) {
        const roles = { Ketua: {L:0,P:0}, 'Wakil Ketua': {L:0,P:0}, Koordinator: {L:0,P:0}, Anggota: {L:0,P:0} };
        subs.forEach(s => {
            if (!s.struktur) return;
            if (s.struktur.ketua?.jenisKelamin) roles.Ketua[s.struktur.ketua.jenisKelamin]++;
            if (s.struktur.wakil?.jenisKelamin) roles['Wakil Ketua'][s.struktur.wakil.jenisKelamin]++;
            if (s.struktur.koordinator?.jenisKelamin) roles.Koordinator[s.struktur.koordinator.jenisKelamin]++;
            (s.struktur.anggota || []).forEach(a => { if (a.jenisKelamin) roles.Anggota[a.jenisKelamin]++; });
        });
        return roles;
    }

    function countMembers(subs) {
        let total = 0;
        subs.forEach(s => { if (!s.struktur) return; ['ketua','wakil','koordinator'].forEach(k => { if (s.struktur[k]?.nama) total++; }); total += (s.struktur.anggota || []).length; });
        return total;
    }
    // ---- SVG Donut Helpers ----
    const DONUT_CIRC = 2 * Math.PI * 78; // ~490

    function resetDonutCircles(ids) {
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.setAttribute('stroke-dasharray', `0 ${DONUT_CIRC}`); el.setAttribute('stroke-dashoffset', '0'); }
        });
    }

    function updateStatusDonut(draft, pending, approved, declined) {
        const total = draft + pending + approved + declined;
        const ids = ['donut-st-approved','donut-st-pending','donut-st-draft','donut-st-declined'];
        if (total === 0) {
            resetDonutCircles(ids);
            document.getElementById('donut-st-value').textContent = '0';
            document.getElementById('donut-st-pct').textContent = '-';
            document.getElementById('donut-st-a').textContent = '0';
            document.getElementById('donut-st-p').textContent = '0';
            document.getElementById('donut-st-d').textContent = '0';
            document.getElementById('donut-st-r').textContent = '0';
            return;
        }
        const segments = [
            { id: 'donut-st-approved', val: approved },
            { id: 'donut-st-pending', val: pending },
            { id: 'donut-st-draft', val: draft },
            { id: 'donut-st-declined', val: declined },
        ];
        let offset = 0;
        segments.forEach(seg => {
            const len = (seg.val / total) * DONUT_CIRC;
            const el = document.getElementById(seg.id);
            if (el) {
                el.setAttribute('stroke-dasharray', `${len} ${DONUT_CIRC}`);
                el.setAttribute('stroke-dashoffset', `${-offset}`);
            }
            offset += len;
        });
        document.getElementById('donut-st-value').textContent = total;
        const approvedPct = Math.round((approved / total) * 100);
        document.getElementById('donut-st-pct').textContent = approvedPct + '% disetujui';
        document.getElementById('donut-st-a').textContent = approved;
        document.getElementById('donut-st-p').textContent = pending;
        document.getElementById('donut-st-d').textContent = draft;
        document.getElementById('donut-st-r').textContent = declined;
    }

    function updatePercentageDonut(prefix, count, total, label) {
        const ids = [`donut-${prefix}-green`, `donut-${prefix}-red`];
        if (total === 0) {
            resetDonutCircles(ids);
            document.getElementById(`donut-${prefix}-value`).textContent = '0/0';
            document.getElementById(`donut-${prefix}-pct`).textContent = '-';
            document.getElementById(`donut-${prefix}-yes`).textContent = '0';
            document.getElementById(`donut-${prefix}-no`).textContent = '0';
            return;
        }
        const pct = Math.round((count / total) * 100);
        const greenLen = (count / total) * DONUT_CIRC;
        const redLen = ((total - count) / total) * DONUT_CIRC;

        const greenEl = document.getElementById(`donut-${prefix}-green`);
        const redEl = document.getElementById(`donut-${prefix}-red`);
        if (greenEl) {
            greenEl.setAttribute('stroke-dasharray', `${greenLen} ${DONUT_CIRC}`);
        }
        if (redEl) {
            redEl.setAttribute('stroke-dasharray', `${redLen} ${DONUT_CIRC}`);
            redEl.setAttribute('stroke-dashoffset', `${-greenLen}`);
        }
        document.getElementById(`donut-${prefix}-value`).textContent = `${count}/${total}`;
        document.getElementById(`donut-${prefix}-pct`).textContent = pct + '%';
        document.getElementById(`donut-${prefix}-yes`).textContent = count;
        document.getElementById(`donut-${prefix}-no`).textContent = total - count;
    }

    function setupDonutTooltips(segments) {
        const tooltip = document.getElementById('admin-tooltip');
        if (!tooltip) return;
        segments.forEach(seg => {
            const circle = document.getElementById(seg.id);
            if (!circle) return;
            // Remove old listeners by cloning
            const clone = circle.cloneNode(true);
            circle.parentNode.replaceChild(clone, circle);
            clone.addEventListener('mousemove', (e) => {
                tooltip.textContent = `${seg.label}: ${seg.value}`;
                tooltip.style.background = seg.bg;
                tooltip.style.display = 'block';
                tooltip.style.left = (e.clientX + 15) + 'px';
                tooltip.style.top = (e.clientY - 10) + 'px';
            });
            clone.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });
        });
    }

    function renderKementerianDashboard() {
        const subs = getActiveSubmissions();
        const isDemoMode = (localStorage.getItem(DEMO_DATA_KEY) || 'entry') === 'demo';
        const toggle = document.getElementById('demo-data-toggle');
        if (toggle) toggle.checked = isDemoMode;
        document.getElementById('data-mode-label').textContent = isDemoMode ? 'Data Demo' : 'Entry Data';

        const draft = subs.filter(s => s.status === 'draft').length;
        const pending = subs.filter(s => s.status === 'pending').length;
        const approved = subs.filter(s => s.status === 'approved').length;
        const declined = subs.filter(s => s.status === 'declined').length;
        const { male, female } = countGender(subs);
        const totalMembers = countMembers(subs);

        document.getElementById('stat-total').textContent = subs.length;
        document.getElementById('stat-members').textContent = totalMembers;
        document.getElementById('stat-male').textContent = male;
        document.getElementById('stat-female').textContent = female;
        document.getElementById('stat-pending').textContent = pending;
        document.getElementById('stat-approved').textContent = approved;

        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const textColor = isDark ? '#e5e7eb' : '#374151';

        // Update SVG donut - Status Pengajuan (4 segments)
        updateStatusDonut(draft, pending, approved, declined);
        setupDonutTooltips([
            { id: 'donut-st-approved', label: 'Disetujui', value: approved + ' (' + (subs.length ? Math.round(approved/subs.length*100) : 0) + '%)', bg: '#10b981' },
            { id: 'donut-st-pending', label: 'Pending', value: pending + ' (' + (subs.length ? Math.round(pending/subs.length*100) : 0) + '%)', bg: '#f59e0b' },
            { id: 'donut-st-draft', label: 'Draft', value: draft + ' (' + (subs.length ? Math.round(draft/subs.length*100) : 0) + '%)', bg: '#6b7280' },
            { id: 'donut-st-declined', label: 'Ditolak', value: declined + ' (' + (subs.length ? Math.round(declined/subs.length*100) : 0) + '%)', bg: '#ef4444' },
        ]);

        // Update SVG donut - Persentase Provinsi
        const provSubs = subs.filter(s => s.roleType === 'dinas_prov');
        const provApproved = provSubs.filter(s => s.status === 'approved').length;
        const totalProv = provSubs.length || 38;
        updatePercentageDonut('prov', provApproved, totalProv, 'PROVINSI');
        const provPct = totalProv > 0 ? (provApproved / totalProv * 100).toFixed(1) : 0;
        setupDonutTooltips([
            { id: 'donut-prov-green', label: 'Pokja Provinsi', value: provApproved + ' (' + provPct + '%)', bg: '#22c55e' },
            { id: 'donut-prov-red', label: 'Belum memiliki Pokja', value: (totalProv - provApproved) + ' (' + (100 - provPct).toFixed(1) + '%)', bg: '#ef4444' },
        ]);

        // Update SVG donut - Persentase Kab/Kota
        const kabSubs = subs.filter(s => s.roleType === 'dinas_kab');
        const kabApproved = kabSubs.filter(s => s.status === 'approved').length;
        const totalKab = kabSubs.length || 514;
        updatePercentageDonut('kab', kabApproved, totalKab, 'KAB/KOTA');
        const kabPct = totalKab > 0 ? (kabApproved / totalKab * 100).toFixed(1) : 0;
        setupDonutTooltips([
            { id: 'donut-kab-green', label: 'Pokja Kab/Kota', value: kabApproved + ' (' + kabPct + '%)', bg: '#22c55e' },
            { id: 'donut-kab-red', label: 'Belum memiliki Pokja', value: (totalKab - kabApproved) + ' (' + (100 - kabPct).toFixed(1) + '%)', bg: '#ef4444' },
        ]);

        const genderByRole = countGenderByRole(subs);
        if (genderChart) genderChart.destroy();
        const ctx2 = document.getElementById('chart-gender');
        if (ctx2) {
            genderChart = new Chart(ctx2, {
                type: 'bar', data: { labels: Object.keys(genderByRole), datasets: [{ label: 'Laki-laki', data: Object.values(genderByRole).map(v => v.L), backgroundColor: '#06b6d4', borderRadius: 6 }, { label: 'Perempuan', data: Object.values(genderByRole).map(v => v.P), backgroundColor: '#ec4899', borderRadius: 6 }] },
                options: { responsive: true, maintainAspectRatio: false, scales: { x: { grid: { display: false }, ticks: { color: textColor } }, y: { beginAtZero: true, grid: { color: isDark ? '#3f4739' : '#e5e7eb' }, ticks: { color: textColor, stepSize: 1 } } }, plugins: { legend: { labels: { color: textColor, usePointStyle: true, pointStyle: 'circle' } } } }
            });
        }

        // Sync submissions to localStorage for data-publik page
        try {
            const syncData = subs.map(s => ({
                wilayah: s.wilayah,
                status: s.status,
                roleType: s.roleType || 'dinas_prov',
                nama: s.namaOp,
                tanggal: s.tanggal
            }));
            localStorage.setItem('bsan_pokja_sync', JSON.stringify({
                submissions: syncData,
                updatedAt: new Date().toISOString(),
                source: isDemoMode ? 'demo' : 'entry'
            }));
        } catch(e) {}

        // Initialize standalone admin map
        if (typeof initAdminMap === 'function') {
            setTimeout(initAdminMap, 300);
        }

        // Store reference for detail modal
        _activeSubs = subs;

        // Render paginated table
        renderLogTable();
    }

    function logFilterChanged() {
        _logPage = 1;
        renderLogTable();
    }

    function logGoToPage(p) {
        _logPage = p;
        renderLogTable();
    }

    function renderLogTable() {
        const tbody = document.getElementById('log-tbody');
        const empty = document.getElementById('log-empty');
        const subs = _activeSubs;

        // Apply filters
        const searchQ = (document.getElementById('log-search')?.value || '').toLowerCase();
        const statusF = document.getElementById('log-status-filter')?.value || '';
        const jenisF = document.getElementById('log-jenis-filter')?.value || '';

        const filtered = subs.filter((s, i) => {
            s._origIdx = i; // preserve original index for detail
            if (searchQ && !(s.wilayah || '').toLowerCase().includes(searchQ)) return false;
            if (statusF && s.status !== statusF) return false;
            if (jenisF && s.roleType !== jenisF) return false;
            return true;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = '';
            empty.style.display = '';
            document.getElementById('log-pagination').style.display = 'none';
            document.getElementById('log-count').textContent = '0 data';
            return;
        }
        empty.style.display = 'none';
        document.getElementById('log-pagination').style.display = '';

        // Pagination
        const totalPages = Math.ceil(filtered.length / _logPerPage);
        if (_logPage > totalPages) _logPage = totalPages;
        const start = (_logPage - 1) * _logPerPage;
        const pageData = filtered.slice(start, start + _logPerPage);

        document.getElementById('log-count').textContent = `${filtered.length} data ditemukan`;

        const statusColors = { draft: 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400', pending: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300', approved: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300', declined: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' };
        const statusLabel = { draft: 'Draft', pending: 'Pending', approved: 'Disetujui', declined: 'Ditolak' };

        tbody.innerHTML = pageData.map(s => {
            const jenisLabel = s.roleType === 'dinas_prov' ? 'Provinsi' : 'Kab/Kota';
            // Inline member count (avoid per-row function calls)
            let mCount = 0, fCount = 0, total = 0;
            if (s.struktur) {
                ['ketua','wakil','koordinator'].forEach(k => {
                    if (s.struktur[k]?.nama) { total++; if (s.struktur[k].jenisKelamin==='L') mCount++; else fCount++; }
                });
                (s.struktur.anggota || []).forEach(a => { total++; if (a.jenisKelamin==='L') mCount++; else fCount++; });
            }
            return `<tr class="border-b dark:border-[#3f4739] hover:bg-gray-50 dark:hover:bg-[#1a1414] cursor-pointer" onclick="openApprovalDetail(${s._origIdx})">
                <td class="px-4 py-3 dark:text-white font-medium">${s.wilayah || s.namaPokja || '-'}</td>
                <td class="px-4 py-3 dark:text-gray-300">${jenisLabel}</td>
                <td class="px-4 py-3 dark:text-gray-300">${total}</td>
                <td class="px-4 py-3"><span class="text-cyan-600">${mCount}L</span> / <span class="text-pink-600">${fCount}P</span></td>
                <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium ${statusColors[s.status]}">${statusLabel[s.status]}</span></td>
                <td class="px-4 py-3"><button onclick="event.stopPropagation();openApprovalDetail(${s._origIdx})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">Detail</button></td>
            </tr>`;
        }).join('');

        // Render pagination buttons
        const pageInfo = document.getElementById('log-page-info');
        const pageBtns = document.getElementById('log-page-buttons');
        pageInfo.textContent = `Halaman ${_logPage} dari ${totalPages} (${filtered.length} data)`;

        let btnsHtml = '';
        btnsHtml += `<button onclick="logGoToPage(${_logPage - 1})" ${_logPage <= 1 ? 'disabled' : ''} class="px-3 py-1 rounded border border-gray-300 dark:border-[#3f4739] ${_logPage <= 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-[#1a1414]'}">←</button>`;
        const maxBtns = 7;
        let startP = Math.max(1, _logPage - 3);
        let endP = Math.min(totalPages, startP + maxBtns - 1);
        if (endP - startP < maxBtns - 1) startP = Math.max(1, endP - maxBtns + 1);
        for (let p = startP; p <= endP; p++) {
            btnsHtml += `<button onclick="logGoToPage(${p})" class="px-3 py-1 rounded border ${p === _logPage ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300 dark:border-[#3f4739] hover:bg-gray-100 dark:hover:bg-[#1a1414]'}">${p}</button>`;
        }
        btnsHtml += `<button onclick="logGoToPage(${_logPage + 1})" ${_logPage >= totalPages ? 'disabled' : ''} class="px-3 py-1 rounded border border-gray-300 dark:border-[#3f4739] ${_logPage >= totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-[#1a1414]'}">→</button>`;
        pageBtns.innerHTML = btnsHtml;
    }

    function openApprovalDetail(idx) {
        const s = _activeSubs[idx];
        if (!s) return;
        currentApprovalIdx = idx;

        // Build structure display
        let membersHtml = '';
        if (s.struktur) {
            const roles = [
                { key: 'ketua', label: 'Ketua — Sekretaris Daerah' },
                { key: 'wakil', label: 'Wakil Ketua — Kepala Bappeda' },
                { key: 'koordinator', label: 'Koordinator — Kepala Dinas Pendidikan' },
            ];
            roles.forEach(r => {
                const m = s.struktur[r.key];
                if (m) {
                    membersHtml += `<div class="border-b dark:border-[#3f4739] pb-2"><p class="text-xs text-gray-500 dark:text-gray-400">${r.label}</p><p class="font-medium dark:text-white">${m.nama || '-'}</p><p class="text-sm text-gray-500">${m.email || '-'} · ${m.instansi || '-'}</p></div>`;
                }
            });
            if (s.struktur.anggota && s.struktur.anggota.length) {
                s.struktur.anggota.forEach(a => {
                    membersHtml += `<div class="border-b dark:border-[#3f4739] pb-2"><p class="text-xs text-gray-500 dark:text-gray-400">${a.bidang || 'Anggota'}</p><p class="font-medium dark:text-white">${a.nama || '-'}</p><p class="text-sm text-gray-500">${a.email || '-'} · ${a.instansi || '-'}</p></div>`;
                });
            }
        }

        document.getElementById('approval-detail-content').innerHTML = `
            <div class="space-y-3">
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Wilayah:</span><p class="text-gray-900 dark:text-white font-semibold">${s.wilayah || '-'}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pokja:</span><p class="text-gray-900 dark:text-white">${s.namaPokja || '-'}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor SK:</span><p class="text-gray-900 dark:text-white">${s.nomorSK || '-'}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Masa Berlaku:</span><p class="text-gray-900 dark:text-white">${s.periodeMulai || '-'} s/d ${s.periodeSelesai || '-'}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Dokumen SK:</span><p class="text-gray-900 dark:text-white">${s.skFileName || 'Tidak ada'}</p></div>
                <hr class="dark:border-[#3f4739]">
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Struktur Pokja:</span></div>
                <div class="space-y-2">${membersHtml || '<p class="text-gray-400">Tidak ada data struktur</p>'}</div>
            </div>
        `;

        // PDF Preview
        const pdfSection = document.getElementById('pdf-preview-section');
        if (s.skFileName) {
            pdfSection.classList.remove('hidden');
            document.getElementById('pdf-filename').textContent = s.skFileName;
        } else {
            pdfSection.classList.add('hidden');
        }

        // Action History
        const historySection = document.getElementById('action-history-section');
        const historyList = document.getElementById('action-history-list');
        const log = getActionLog().filter(l => l.wilayah === s.wilayah);
        if (log.length > 0) {
            historySection.classList.remove('hidden');
            historyList.innerHTML = log.map(l => {
                const d = new Date(l.timestamp);
                const dateStr = d.toLocaleDateString('id-ID', {day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'});
                const actionColor = l.action === 'approved' ? 'text-green-600' : 'text-red-600';
                const actionLabel = l.action === 'approved' ? '✅ Disetujui' : '❌ Ditolak';
                return `<div class="flex items-center gap-2 text-sm">
                    <span class="${actionColor} font-medium">${actionLabel}</span>
                    <span class="text-gray-500">oleh ${l.admin}</span>
                    <span class="text-gray-400 ml-auto">${dateStr}</span>
                    ${l.reason ? `<span class="text-xs text-red-500">(${l.reason})</span>` : ''}
                </div>`;
            }).join('');
        } else {
            historySection.classList.add('hidden');
        }

        // Show/hide actions based on status
        const actionsEl = document.getElementById('approval-actions');
        const declineFormEl = document.getElementById('decline-form');
        if (s.status === 'pending') {
            actionsEl.classList.remove('hidden');
        } else {
            actionsEl.classList.add('hidden');
        }
        declineFormEl.classList.add('hidden');

        document.getElementById('detail-approval-modal').style.display = '';
    }

    function closeApprovalModal() {
        document.getElementById('detail-approval-modal').style.display = 'none';
        currentApprovalIdx = -1;
    }

    function approvePokja() {
        if (currentApprovalIdx < 0) return;
        const subs = getSubmissions();
        subs[currentApprovalIdx].status = 'approved';
        subs[currentApprovalIdx].approvedAt = new Date().toISOString();
        subs[currentApprovalIdx].approvedBy = '<?= session()->get('user_name') ?? 'Admin Demo' ?>';
        addActionLogEntry('approved', subs[currentApprovalIdx].wilayah);
        saveSubmissions(subs);
        closeApprovalModal();
        renderKementerianDashboard();
    }

    function showDeclineForm() {
        document.getElementById('approval-actions').style.display = 'none';
        document.getElementById('decline-form').style.display = '';
    }

    function cancelDecline() {
        document.getElementById('decline-form').style.display = 'none';
        document.getElementById('approval-actions').style.display = '';
    }

    function declinePokja() {
        if (currentApprovalIdx < 0) return;
        const reason = document.getElementById('decline-reason-input').value.trim();
        if (!reason) { alert('Masukkan alasan penolakan.'); return; }
        const subs = getSubmissions();
        subs[currentApprovalIdx].status = 'declined';
        subs[currentApprovalIdx].declineReason = reason;
        subs[currentApprovalIdx].declinedAt = new Date().toISOString();
        subs[currentApprovalIdx].declinedBy = '<?= session()->get('user_name') ?? 'Admin Demo' ?>';
        addActionLogEntry('declined', subs[currentApprovalIdx].wilayah, reason);
        saveSubmissions(subs);
        alert('Pengajuan ditolak.');
        closeApprovalModal();
        renderKementerianDashboard();
    }

    function openPdfInNewTab() {
        // Demo mode — no real PDF, show placeholder
        const w = window.open('', '_blank');
        const subs = getSubmissions();
        const s = subs[currentApprovalIdx];
        w.document.write(`<html><head><title>${s?.skFileName || 'SK Pokja'}</title></head><body style="font-family:system-ui;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f9fafb;"><div style="text-align:center;"><h1 style="font-size:3rem;">📄</h1><h2>Preview Dokumen SK</h2><p style="color:#666;">${s?.skFileName || '-'}</p><p style="color:#999;font-size:0.8rem;">Mode Demo — file PDF tidak tersimpan di server</p></div></body></html>`);
    }

    // ---- Dinas Dashboard ----
    function renderDinasDashboard(role) {
        const provName = localStorage.getItem('bsan_wilayah_prov') || '';
        const kabName = localStorage.getItem('bsan_wilayah_kab') || '';
        let wilayah, jenisLabel;
        if (role === 'dinas_prov') {
            jenisLabel = 'Provinsi';
            wilayah = provName ? `Prov. ${provName}` : 'Provinsi';
        } else {
            jenisLabel = 'Kabupaten/Kota';
            wilayah = kabName || 'Kabupaten/Kota';
        }
        document.getElementById('dinas-title').textContent = `Dashboard ${jenisLabel} — ${wilayah}`;
        document.getElementById('dinas-subtitle').textContent = `Kelola Pokja ${wilayah}`;

        // Find submission for this role
        const subs = getSubmissions();
        const mySub = subs.find(s => s.roleType === role && s.wilayah === wilayah);

        if (mySub) {
            // Update cards
            document.getElementById('sk-nomor-display').textContent = mySub.nomorSK || '-';
            document.getElementById('masa-berlaku').textContent = mySub.periodeMulai && mySub.periodeSelesai
                ? `${mySub.periodeMulai} s/d ${mySub.periodeSelesai}` : '-';

            const statusMap = {
                draft: { text: 'Draft', class: 'text-gray-600 dark:text-gray-400' },
                pending: { text: 'Pending', class: 'text-yellow-600' },
                approved: { text: 'Disetujui', class: 'text-green-600' },
                declined: { text: 'Ditolak', class: 'text-red-600' },
            };
            const st = statusMap[mySub.status] || statusMap.draft;
            document.getElementById('status-pokja').textContent = st.text;
            document.getElementById('status-pokja').className = `text-lg font-bold mt-1 ${st.class}`;
            document.getElementById('status-pengajuan').textContent = st.text;
            document.getElementById('status-pengajuan').className = `text-lg font-bold mt-1 ${st.class}`;

            // Show appropriate banner
            if (mySub.status === 'pending') {
                document.getElementById('pending-banner').style.display = '';
            } else if (mySub.status === 'declined') {
                document.getElementById('decline-banner').style.display = '';
                document.getElementById('decline-reason').textContent = mySub.declineReason || 'Tidak ada alasan.';
            } else if (mySub.status === 'approved') {
                document.getElementById('approved-banner').style.display = '';
                document.getElementById('bentuk-pokja-section').style.display = 'none';
            }

            // Change button text if already exists
            const btnSection = document.getElementById('bentuk-pokja-section');
            if (mySub.status === 'draft' || mySub.status === 'declined') {
                btnSection.innerHTML = `<a href="/dashboard/pokja" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-lg transition-colors text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Data Pokja
                </a>`;
            } else if (mySub.status === 'pending' || mySub.status === 'approved') {
                btnSection.innerHTML = `<a href="/dashboard/pokja" class="inline-flex items-center gap-2 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold px-6 py-3 rounded-lg transition-colors text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat Data Pokja
                </a>`;
            }
        } else {
            // No submission yet — show defaults
            document.getElementById('status-pokja').textContent = 'Belum Ada';
            document.getElementById('status-pokja').className = 'text-lg font-bold mt-1 text-gray-400';
        }
    }

    $(document).ready(function() { initDashboard(); });
</script>
<?= $this->endSection() ?>
