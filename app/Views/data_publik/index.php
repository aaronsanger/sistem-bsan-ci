<?= $this->extend('layouts/main') ?>

<?= $this->section('head') ?>
<style>
    /* Dark mode page backgrounds */
    [data-theme="dark"] body {
        background: #0F0A0A;
    }

    [data-theme="dark"] .section {
        background: #0F0A0A !important;
    }

    /* Disclaimer Alert */
    .disclaimer-alert {
        background: #fef9c3;
        border: 1px solid #fde047;
        border-radius: var(--radius-lg);
        padding: var(--spacing-4);
        margin-bottom: var(--spacing-6);
    }

    .disclaimer-alert p {
        color: #854d0e;
        font-size: 0.875rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--spacing-4);
        margin-bottom: var(--spacing-6);
    }

    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Stat Cards */
    .stat-card {
        border-radius: var(--radius-xl);
        padding: var(--spacing-5);
        box-shadow: var(--shadow-sm);
        transition: box-shadow var(--transition-normal);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-md);
    }

    .stat-card--green {
        background: linear-gradient(to bottom right, #f0fdf4, #dcfce7);
        border: 1px solid #bbf7d0;
    }

    .stat-card--blue {
        background: linear-gradient(to bottom right, #eff6ff, #dbeafe);
        border: 1px solid #bfdbfe;
    }

    .stat-card--purple {
        background: linear-gradient(to bottom right, #faf5ff, #f3e8ff);
        border: 1px solid #e9d5ff;
    }

    [data-theme="dark"] .stat-card--green {
        background: linear-gradient(to bottom right, rgba(22, 101, 52, 0.2), rgba(22, 101, 52, 0.3));
        border-color: rgba(22, 101, 52, 0.5);
    }

    [data-theme="dark"] .stat-card--blue {
        background: linear-gradient(to bottom right, rgba(30, 64, 175, 0.2), rgba(30, 64, 175, 0.3));
        border-color: rgba(30, 64, 175, 0.5);
    }

    [data-theme="dark"] .stat-card--purple {
        background: linear-gradient(to bottom right, rgba(126, 34, 206, 0.2), rgba(126, 34, 206, 0.3));
        border-color: rgba(126, 34, 206, 0.5);
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .stat-card--green .stat-label { color: #16a34a; }
    .stat-card--blue .stat-label { color: #2563eb; }
    .stat-card--purple .stat-label { color: #9333ea; }

    [data-theme="dark"] .stat-card--green .stat-label { color: #4ade80; }
    [data-theme="dark"] .stat-card--blue .stat-label { color: #60a5fa; }
    [data-theme="dark"] .stat-card--purple .stat-label { color: #c084fc; }

    .stat-value {
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: var(--spacing-1);
    }

    .stat-card--green .stat-value { color: #15803d; }
    .stat-card--blue .stat-value { color: #1d4ed8; }
    .stat-card--purple .stat-value { color: #7e22ce; }

    [data-theme="dark"] .stat-card--green .stat-value { color: #86efac; }
    [data-theme="dark"] .stat-card--blue .stat-value { color: #93c5fd; }
    [data-theme="dark"] .stat-card--purple .stat-value { color: #d8b4fe; }

    .stat-sublabel {
        font-size: 0.75rem;
        margin-top: var(--spacing-1);
    }

    .stat-card--green .stat-sublabel { color: #22c55e; }
    .stat-card--blue .stat-sublabel { color: #3b82f6; }
    .stat-card--purple .stat-sublabel { color: #a855f7; }

    [data-theme="dark"] .stat-card--green .stat-sublabel { color: rgba(74, 222, 128, 0.7); }
    [data-theme="dark"] .stat-card--blue .stat-sublabel { color: rgba(96, 165, 250, 0.7); }
    [data-theme="dark"] .stat-card--purple .stat-sublabel { color: rgba(192, 132, 252, 0.7); }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-card--green .stat-icon { background: #bbf7d0; }
    .stat-card--blue .stat-icon { background: #bfdbfe; }
    .stat-card--purple .stat-icon { background: #e9d5ff; }

    [data-theme="dark"] .stat-card--green .stat-icon { background: rgba(22, 101, 52, 0.5); }
    [data-theme="dark"] .stat-card--blue .stat-icon { background: rgba(30, 64, 175, 0.5); }
    [data-theme="dark"] .stat-card--purple .stat-icon { background: rgba(126, 34, 206, 0.5); }

    .stat-icon svg { width: 24px; height: 24px; }
    .stat-card--green .stat-icon svg { color: #16a34a; }
    .stat-card--blue .stat-icon svg { color: #2563eb; }
    .stat-card--purple .stat-icon svg { color: #9333ea; }

    [data-theme="dark"] .stat-card--green .stat-icon svg { color: #4ade80; }
    [data-theme="dark"] .stat-card--blue .stat-icon svg { color: #60a5fa; }
    [data-theme="dark"] .stat-card--purple .stat-icon svg { color: #c084fc; }

    /* Table Controls */
    .table-controls {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: var(--spacing-4);
        margin-bottom: var(--spacing-4);
    }

    .table-controls__left,
    .table-controls__right {
        display: flex;
        align-items: center;
        gap: var(--spacing-2);
        flex-wrap: wrap;
    }

    .table-controls__label {
        font-size: 0.875rem;
        color: var(--color-gray-600);
    }

    [data-theme="dark"] .table-controls__label { color: var(--color-gray-400); }

    .entries-select,
    .search-input {
        border: 1px solid var(--color-gray-300);
        border-radius: var(--radius-md);
        padding: var(--spacing-1) var(--spacing-2);
        font-size: 0.875rem;
        background: white;
        color: var(--color-gray-900);
    }

    [data-theme="dark"] .entries-select,
    [data-theme="dark"] .search-input {
        background: #1a1414;
        border-color: #3f4739;
        color: white;
    }

    .btn--export {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-1);
        background: #059669;
        color: white;
        padding: var(--spacing-1) var(--spacing-4);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
    }

    .btn--export:hover { background: #047857; }
    .btn--export svg { width: 16px; height: 16px; }

    /* Data Table */
    .data-table-wrapper {
        background: white;
        border: 1px solid var(--color-gray-300);
        border-radius: var(--radius-lg);
        overflow: hidden;
        margin-bottom: var(--spacing-4);
    }

    [data-theme="dark"] .data-table-wrapper {
        background: #1a1414;
        border-color: #3f4739;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .data-table th {
        background: #f9fafb;
        padding: var(--spacing-3) var(--spacing-4);
        text-align: left;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        border-bottom: 1px solid var(--color-gray-300);
    }

    .data-table th:hover { background: #f3f4f6; }

    [data-theme="dark"] .data-table th {
        background: #0F0A0A;
        color: white;
        border-color: #3f4739;
    }

    [data-theme="dark"] .data-table th:hover { background: #3f4739; }

    .data-table td {
        padding: var(--spacing-3) var(--spacing-4);
        border-bottom: 1px solid var(--color-gray-200);
        color: var(--color-gray-900);
    }

    [data-theme="dark"] .data-table td {
        border-color: #3f4739;
        color: var(--color-gray-300);
    }

    .data-table tbody tr:hover { background: rgba(59, 130, 246, 0.05); }
    [data-theme="dark"] .data-table tbody tr:hover { background: rgba(59, 130, 246, 0.1); }

    .data-table__link { color: #2563eb; cursor: pointer; }
    .data-table__link:hover { text-decoration: underline; }
    [data-theme="dark"] .data-table__link { color: #60a5fa; }

    .view-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #2563eb;
        padding: 4px;
    }
    .view-btn:hover { color: #1d4ed8; }
    [data-theme="dark"] .view-btn { color: #60a5fa; }
    [data-theme="dark"] .view-btn:hover { color: #93c5fd; }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
    }
    .status-badge--success { background: #dcfce7; color: #15803d; }
    .status-badge--warning { background: #fef9c3; color: #a16207; }
    .status-badge--muted { background: #f3f4f6; color: #4b5563; }

    [data-theme="dark"] .status-badge--success { background: rgba(22, 101, 52, 0.4); color: #86efac; }
    [data-theme="dark"] .status-badge--warning { background: rgba(202, 138, 4, 0.4); color: #fde047; }
    [data-theme="dark"] .status-badge--muted { background: rgba(75, 85, 99, 0.4); color: #9ca3af; }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-2);
    }
    .pagination__info { font-size: 0.875rem; color: var(--color-gray-600); }
    [data-theme="dark"] .pagination__info { color: var(--color-gray-400); }
    .pagination__buttons { display: flex; gap: var(--spacing-1); }
    .pagination__btn {
        padding: var(--spacing-1) var(--spacing-3);
        border: 1px solid var(--color-gray-300);
        background: white;
        color: var(--color-gray-700);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        cursor: pointer;
    }
    .pagination__btn:hover:not(:disabled) { background: var(--color-gray-100); }
    .pagination__btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .pagination__btn--active { background: #1d4ed8; color: white; border-color: #1d4ed8; }

    [data-theme="dark"] .pagination__btn { background: #1a1414; border-color: #3f4739; color: var(--color-gray-300); }
    [data-theme="dark"] .pagination__btn:hover:not(:disabled) { background: #3f4739; }
    [data-theme="dark"] .pagination__btn--active { background: #1d4ed8; border-color: #1d4ed8; color: white; }

    /* Page Title */
    .page-title-section { text-align: center; margin-bottom: var(--spacing-6); }
    .page-title { font-size: 1.5rem; font-weight: 700; color: var(--color-gray-900); }
    [data-theme="dark"] .page-title { color: white; }
    .page-subtitle { color: var(--color-gray-600); }
    [data-theme="dark"] .page-subtitle { color: var(--color-gray-400); }
    .page-update { color: var(--color-gray-400); font-size: 0.875rem; }

    /* Breadcrumb */
    .breadcrumb { margin-bottom: var(--spacing-4); font-size: 0.875rem; }
    .breadcrumb a { color: #2563eb; text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }
    [data-theme="dark"] .breadcrumb a { color: #60a5fa; }
    .breadcrumb span { color: var(--color-gray-500); margin: 0 var(--spacing-2); }
    [data-theme="dark"] .breadcrumb span { color: var(--color-gray-400); }

    /* Back Button */
    .btn--back {
        background: #6b7280; color: white;
        padding: var(--spacing-2) var(--spacing-4);
        border-radius: var(--radius-md); font-size: 0.875rem;
        font-weight: 500; border: none; cursor: pointer;
    }
    .btn--back:hover { background: #4b5563; }

    /* Donut Charts Section */
    .charts-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--spacing-6);
        margin-top: var(--spacing-8);
    }
    @media (min-width: 1024px) { .charts-grid { grid-template-columns: repeat(2, 1fr); } }

    .chart-card {
        background: white; border-radius: 1.5rem; box-shadow: var(--shadow-lg);
        padding: var(--spacing-8); border: 1px solid var(--color-gray-100);
    }
    [data-theme="dark"] .chart-card { background: #1a1414; border-color: #3f4739; }
    .chart-card h2 { font-size: 1.125rem; font-weight: 600; color: var(--color-gray-800); margin-bottom: var(--spacing-8); text-align: center; }
    [data-theme="dark"] .chart-card h2 { color: white; }

    .donut-wrapper { display: flex; justify-content: center; align-items: center; }
    .donut-container { position: relative; cursor: pointer; }
    .donut-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none; }
    .donut-center__label { font-size: 0.75rem; color: var(--color-gray-400); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500; }
    [data-theme="dark"] .donut-center__label { color: var(--color-gray-500); }
    .donut-center__value { font-size: 1.875rem; font-weight: 700; color: var(--color-gray-800); }
    [data-theme="dark"] .donut-center__value { color: white; }
    .donut-center__pct { font-size: 0.875rem; font-weight: 600; color: #16a34a; }
    [data-theme="dark"] .donut-center__pct { color: #4ade80; }
    .chart-date { font-size: 0.75rem; color: var(--color-gray-500); margin-top: var(--spacing-6); text-align: center; }
    [data-theme="dark"] .chart-date { color: var(--color-gray-300); }

    /* Tooltip */
    .tooltip { position: fixed; z-index: 50; padding: 8px 16px; border-radius: var(--radius-lg); font-size: 0.875rem; color: white; white-space: nowrap; box-shadow: var(--shadow-lg); pointer-events: none; display: none; }
    .tooltip--green { background: #22c55e; }
    .tooltip--red { background: #ef4444; }

    /* Map Section */
    .map-section { margin-top: var(--spacing-8); }
    .map-section h2 { font-size: 1.125rem; font-weight: 600; color: var(--color-gray-800); margin-bottom: var(--spacing-4); text-align: center; }
    [data-theme="dark"] .map-section h2 { color: white; }
    .map-placeholder { background: white; border: 1px solid var(--color-gray-200); border-radius: var(--radius-lg); padding: var(--spacing-8); text-align: center; color: var(--color-gray-500); min-height: 400px; display: flex; align-items: center; justify-content: center; }
    [data-theme="dark"] .map-placeholder { background: #1a1414; border-color: #3f4739; color: var(--color-gray-400); }

    /* Anggota View */
    .anggota-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-6); }
    .anggota-header__title { font-size: 1.5rem; font-weight: 700; color: var(--color-gray-900); }
    [data-theme="dark"] .anggota-header__title { color: white; }
    .anggota-header__subtitle { font-size: 0.875rem; color: var(--color-gray-600); }
    [data-theme="dark"] .anggota-header__subtitle { color: var(--color-gray-400); }
    .sk-info { font-size: 0.875rem; color: var(--color-gray-700); margin-bottom: var(--spacing-4); }
    [data-theme="dark"] .sk-info { color: var(--color-gray-300); }
    .sk-info p { margin-bottom: var(--spacing-1); }
    .sk-info span { display: inline-block; width: 150px; }
    .operator-info { font-size: 0.875rem; }
    .operator-info strong { color: var(--color-gray-700); }
    [data-theme="dark"] .operator-info strong { color: var(--color-gray-300); }
    .operator-info .update { color: #3b82f6; font-size: 0.75rem; }
    [data-theme="dark"] .operator-info .update { color: #60a5fa; }

    /* Table Footer Row */
    .table-footer-row { background: #f9fafb; font-weight: 600; }
    [data-theme="dark"] .table-footer-row { background: #1a1414; color: white; }

    /* Hidden class */
    .hidden { display: none !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Main Content -->
<main class="section" style="background: var(--color-gray-50); min-height: calc(100vh - 64px)">
    <div class="container" style="max-width: 1200px">

        <!-- LIST VIEW (Main View) -->
        <div id="view-list">
            <!-- Disclaimer -->
            <div class="disclaimer-alert">
                <p><strong>⚠️ Disclaimer:</strong> Data dibawah adalah dummy untuk keperluan pengembangan dan demonstrasi sistem.</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card stat-card--green">
                    <div>
                        <p class="stat-label">Provinsi Terbentuk</p>
                        <p class="stat-value" id="stat-provinsi">0</p>
                        <p class="stat-sublabel">dari 38 provinsi</p>
                    </div>
                    <div class="stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
                <div class="stat-card stat-card--blue">
                    <div>
                        <p class="stat-label">Kab/Kota Terbentuk</p>
                        <p class="stat-value" id="stat-kotakab">0</p>
                        <p class="stat-sublabel" id="stat-kotakab-total">dari 514 kab/kota</p>
                    </div>
                    <div class="stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                    </div>
                </div>
                <div class="stat-card stat-card--purple">
                    <div>
                        <p class="stat-label">Persentase Nasional</p>
                        <p class="stat-value" id="stat-persentase">0%</p>
                        <p class="stat-sublabel">capaian seluruh Indonesia</p>
                    </div>
                    <div class="stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Page Title -->
            <div class="page-title-section">
                <h1 class="page-title">Jumlah Kelompok Kerja tiap Provinsi</h1>
                <p class="page-subtitle" id="current-date">per 2 Februari 2026</p>
                <p class="page-update" id="last-update">[Update terakhir: 2/2/2026, 16.50.00]</p>
            </div>

            <!-- Table Controls -->
            <div class="table-controls">
                <div class="table-controls__left">
                    <span class="table-controls__label">Show</span>
                    <select id="entries-select" class="entries-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="table-controls__label">entries</span>
                </div>
                <div class="table-controls__right">
                    <span class="table-controls__label">Search:</span>
                    <input type="text" id="search-input" class="search-input">
                    <button class="btn--export" onclick="exportToCSV()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export CSV
                    </button>
                </div>
            </div>

            <!-- Province Table -->
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th onclick="sortTable('no')">No <span id="sort-no">▼</span></th>
                            <th onclick="sortTable('nama')">Nama Provinsi <span id="sort-nama">▼</span></th>
                            <th onclick="sortTable('statusPokja')" style="text-align:center">Status Pokja <span id="sort-statusPokja">▼</span></th>
                            <th onclick="sortTable('jumlahKotaKab')" style="text-align:center">Jumlah Kota/Kab <span id="sort-jumlahKotaKab">▼</span></th>
                            <th onclick="sortTable('jumlahPokjaKotaKab')" style="text-align:center">Jumlah Pokja Kota/Kab <span id="sort-jumlahPokjaKotaKab">▼</span></th>
                            <th onclick="sortTable('persentase')" style="text-align:center">Persentase <span id="sort-persentase">▼</span></th>
                            <th style="text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="province-table-body"></tbody>
                    <tfoot id="province-table-footer"></tfoot>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination" style="margin-bottom: var(--spacing-8)">
                <div class="pagination__info" id="pagination-info">Showing 1 to 10 of 38 entries</div>
                <div class="pagination__buttons" id="pagination-buttons"></div>
            </div>

            <!-- Donut Charts -->
            <div class="charts-grid">
                <div class="chart-card">
                    <h2>Persentase Pokja Provinsi</h2>
                    <div class="donut-wrapper">
                        <div class="donut-container" id="donut-provinsi">
                            <svg width="220" height="220" viewBox="0 0 220 220">
                                <circle cx="110" cy="110" r="85" fill="none" stroke="#e5e7eb" stroke-width="24"/>
                                <circle id="donut-prov-red" cx="110" cy="110" r="85" fill="none" stroke="#ef4444" stroke-width="24" stroke-linecap="round" stroke-dasharray="0 534" transform="rotate(-90 110 110)" style="transition: all 0.8s ease"/>
                                <circle id="donut-prov-green" cx="110" cy="110" r="85" fill="none" stroke="#22c55e" stroke-width="24" stroke-linecap="round" stroke-dasharray="0 534" transform="rotate(-90 110 110)" style="transition: all 0.8s ease"/>
                            </svg>
                            <div class="donut-center">
                                <span class="donut-center__label">PROVINSI</span>
                                <span class="donut-center__value" id="donut-prov-value">0/38</span>
                                <span class="donut-center__pct" id="donut-prov-pct">0%</span>
                            </div>
                        </div>
                    </div>
                    <p class="chart-date" id="chart-date-prov">Data per 2 Februari 2026</p>
                </div>

                <div class="chart-card">
                    <h2>Persentase Pokja Kab/Kota</h2>
                    <div class="donut-wrapper">
                        <div class="donut-container" id="donut-kotakab">
                            <svg width="220" height="220" viewBox="0 0 220 220">
                                <circle cx="110" cy="110" r="85" fill="none" stroke="#e5e7eb" stroke-width="24"/>
                                <circle id="donut-kab-red" cx="110" cy="110" r="85" fill="none" stroke="#ef4444" stroke-width="24" stroke-linecap="round" stroke-dasharray="0 534" transform="rotate(-90 110 110)" style="transition: all 0.8s ease"/>
                                <circle id="donut-kab-green" cx="110" cy="110" r="85" fill="none" stroke="#22c55e" stroke-width="24" stroke-linecap="round" stroke-dasharray="0 534" transform="rotate(-90 110 110)" style="transition: all 0.8s ease"/>
                            </svg>
                            <div class="donut-center">
                                <span class="donut-center__label">KAB/KOTA</span>
                                <span class="donut-center__value" id="donut-kab-value">0/514</span>
                                <span class="donut-center__pct" id="donut-kab-pct">0%</span>
                            </div>
                        </div>
                    </div>
                    <p class="chart-date" id="chart-date-kab">Data per 2 Februari 2026</p>
                </div>
            </div>

            <!-- Map Section -->
            <div class="map-section">
                <h2>Peta Sebaran Pokja</h2>
                <div id="map-container"></div>
            </div>
        </div>

        <!-- KOTAKAB VIEW -->
        <div id="view-kotakab" class="hidden">
            <div class="breadcrumb">
                <a href="#" onclick="showListView(); return false;">Indonesia</a>
                <span>&gt;&gt;</span>
                <span id="breadcrumb-prov">Prov. ...</span>
            </div>
            <div class="page-title-section">
                <h1 class="page-title" id="kotakab-title">Jumlah Kelompok Kerja tiap PROV. ...</h1>
            </div>
            <div class="table-controls">
                <div class="table-controls__left">
                    <span class="table-controls__label">Show</span>
                    <select id="kk-entries-select" class="entries-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="table-controls__label">entries</span>
                </div>
                <div class="table-controls__right">
                    <span class="table-controls__label">Search:</span>
                    <input type="text" id="kk-search-input" class="search-input">
                </div>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kota/Kabupaten</th>
                            <th style="text-align:center">Status Pokja</th>
                            <th style="text-align:center">Jumlah Anggota</th>
                            <th style="text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kotakab-table-body"></tbody>
                    <tfoot id="kotakab-table-footer"></tfoot>
                </table>
            </div>
        </div>

        <!-- ANGGOTA PROV VIEW -->
        <div id="view-anggota-prov" class="hidden">
            <div class="anggota-header">
                <div>
                    <p class="anggota-header__subtitle">Kelompok Kerja (Pokja)</p>
                    <h1 class="anggota-header__title" id="anggota-prov-title">Prov. ...</h1>
                </div>
                <button class="btn--back" onclick="showListView()">Kembali</button>
            </div>
            <h2 style="font-size: 1rem; font-weight: 600; margin-bottom: var(--spacing-4); color: var(--color-gray-800)">ANGGOTA</h2>
            <div class="data-table-wrapper" style="margin-bottom: var(--spacing-6)">
                <table class="data-table">
                    <thead style="background: #1d4ed8">
                        <tr>
                            <th style="color: white; background: #1d4ed8">No</th>
                            <th style="color: white; background: #1d4ed8">Nama</th>
                            <th style="color: white; background: #1d4ed8">Status Keanggotaan</th>
                            <th style="color: white; background: #1d4ed8">Asal Instansi</th>
                            <th style="color: white; background: #1d4ed8; text-align: center">Admin Pokja</th>
                        </tr>
                    </thead>
                    <tbody id="anggota-prov-table-body"></tbody>
                </table>
            </div>
            <div class="sk-info" id="sk-info-prov"></div>
            <div class="operator-info" id="operator-info-prov"></div>
        </div>

        <!-- ANGGOTA KOTAKAB VIEW -->
        <div id="view-anggota-kotakab" class="hidden">
            <div class="anggota-header">
                <div>
                    <p class="anggota-header__subtitle">Kelompok Kerja (Pokja)</p>
                    <h1 class="anggota-header__title" id="anggota-kk-title">...</h1>
                    <p class="anggota-header__subtitle" id="anggota-kk-prov">Prov. ...</p>
                </div>
                <button class="btn--back" onclick="showKotaKabView()">Kembali</button>
            </div>
            <h2 style="font-size: 1rem; font-weight: 600; margin-bottom: var(--spacing-4); color: var(--color-gray-800)">ANGGOTA</h2>
            <div class="data-table-wrapper" style="margin-bottom: var(--spacing-6)">
                <table class="data-table">
                    <thead style="background: #1d4ed8">
                        <tr>
                            <th style="color: white; background: #1d4ed8">No</th>
                            <th style="color: white; background: #1d4ed8">Nama</th>
                            <th style="color: white; background: #1d4ed8">Status Keanggotaan</th>
                            <th style="color: white; background: #1d4ed8">Asal Instansi</th>
                            <th style="color: white; background: #1d4ed8; text-align: center">Admin Pokja</th>
                        </tr>
                    </thead>
                    <tbody id="anggota-kk-table-body"></tbody>
                </table>
            </div>
            <div class="sk-info" id="sk-info-kk"></div>
            <div class="operator-info" id="operator-info-kk"></div>
        </div>

    </div>
</main>

<!-- Tooltip -->
<div class="tooltip" id="tooltip"></div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/assets/js/data-publik-data.js"></script>
<script src="/assets/js/indonesia-all-levels-data.js"></script>
<script src="/assets/js/utils/themeColors.js"></script>
<script src="/assets/js/utils/mapConfig.js"></script>
<script src="/assets/js/utils/mapTemplates.js"></script>
<script src="/assets/js/map-visualization.js"></script>
<script>
    // ========================================
    // STATE
    // ========================================
    var provinsiData = [];
    var pokjaTotals = {};
    let currentPage = 1;
    let entriesPerPage = 10;
    let sortField = 'nama';
    let sortDirection = 'asc';
    let searchTerm = '';
    let selectedProvinsi = null;
    let selectedKotaKab = null;

    let kkSearchTerm = '';
    let kkEntriesPerPage = 10;
    let kkCurrentPage = 1;

    // ========================================
    // INITIALIZE
    // ========================================
    document.addEventListener('DOMContentLoaded', () => {
        provinsiData = generateProvinceData();
        pokjaTotals = calculateTotals(provinsiData);
        updateDate();
        updateStats();
        updateDonutCharts();
        renderTable();
        setupEventListeners();

        if (typeof renderMap === 'function') {
            setTimeout(renderMap, 200);
        }
    });

    function updateDate() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('current-date').textContent = `per ${dateStr}`;
        document.getElementById('last-update').textContent = `[Update terakhir: ${now.toLocaleString('id-ID')}]`;
        document.getElementById('chart-date-prov').textContent = `Data per ${dateStr}`;
        document.getElementById('chart-date-kab').textContent = `Data per ${dateStr}`;
    }

    function updateStats() {
        document.getElementById('stat-provinsi').textContent = pokjaTotals.pokjaProvinsi;
        document.getElementById('stat-kotakab').textContent = pokjaTotals.jumlahPokjaKotaKab;
        document.getElementById('stat-kotakab-total').textContent = `dari ${pokjaTotals.jumlahKotaKab} kab/kota`;
        document.getElementById('stat-persentase').textContent = pokjaTotals.persentase.toFixed(1) + '%';
    }

    function updateDonutCharts() {
        const circumference = 534;
        const provPct = (pokjaTotals.pokjaProvinsi / 38) * 100;
        const provGreen = (provPct / 100) * circumference;
        const provRed = ((100 - provPct) / 100) * circumference;
        document.getElementById('donut-prov-green').setAttribute('stroke-dasharray', `${provGreen} ${circumference}`);
        document.getElementById('donut-prov-red').setAttribute('stroke-dasharray', `${provRed} ${circumference}`);
        document.getElementById('donut-prov-red').setAttribute('stroke-dashoffset', `-${provGreen}`);
        document.getElementById('donut-prov-value').textContent = `${pokjaTotals.pokjaProvinsi}/38`;
        document.getElementById('donut-prov-pct').textContent = `${provPct.toFixed(0)}%`;

        setupDonutTooltips('donut-provinsi', [
            { id: 'donut-prov-green', label: 'Pokja Provinsi', value: provPct.toFixed(2) + '%', color: 'green' },
            { id: 'donut-prov-red', label: 'Belum memiliki Pokja', value: (100 - provPct).toFixed(2) + '%', color: 'red' }
        ]);

        const kabPct = pokjaTotals.persentase;
        const kabGreen = (kabPct / 100) * circumference;
        const kabRed = ((100 - kabPct) / 100) * circumference;
        document.getElementById('donut-kab-green').setAttribute('stroke-dasharray', `${kabGreen} ${circumference}`);
        document.getElementById('donut-kab-red').setAttribute('stroke-dasharray', `${kabRed} ${circumference}`);
        document.getElementById('donut-kab-red').setAttribute('stroke-dashoffset', `-${kabGreen}`);
        document.getElementById('donut-kab-value').textContent = `${pokjaTotals.jumlahPokjaKotaKab}/${pokjaTotals.jumlahKotaKab}`;
        document.getElementById('donut-kab-pct').textContent = `${kabPct.toFixed(0)}%`;

        setupDonutTooltips('donut-kotakab', [
            { id: 'donut-kab-green', label: 'Pokja Kab/Kota', value: kabPct.toFixed(2) + '%', color: 'green' },
            { id: 'donut-kab-red', label: 'Belum memiliki Pokja', value: (100 - kabPct).toFixed(2) + '%', color: 'red' }
        ]);
    }

    function setupDonutTooltips(containerId, segments) {
        const container = document.getElementById(containerId);
        const tooltip = document.getElementById('tooltip');
        if (!container || !tooltip) return;

        segments.forEach(seg => {
            const circle = document.getElementById(seg.id);
            if (!circle) return;
            circle.addEventListener('mousemove', (e) => {
                tooltip.textContent = `${seg.label}: ${seg.value}`;
                tooltip.className = `tooltip tooltip--${seg.color}`;
                tooltip.style.display = 'block';
                tooltip.style.left = (e.clientX + 15) + 'px';
                tooltip.style.top = (e.clientY - 10) + 'px';
            });
            circle.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });
        });
    }

    function setupEventListeners() {
        document.getElementById('entries-select').addEventListener('change', (e) => {
            entriesPerPage = parseInt(e.target.value);
            currentPage = 1;
            renderTable();
        });
        document.getElementById('search-input').addEventListener('input', (e) => {
            searchTerm = e.target.value.toLowerCase();
            currentPage = 1;
            renderTable();
        });
        document.getElementById('kk-entries-select').addEventListener('change', (e) => {
            kkEntriesPerPage = parseInt(e.target.value);
            kkCurrentPage = 1;
            renderKotaKabTable();
        });
        document.getElementById('kk-search-input').addEventListener('input', (e) => {
            kkSearchTerm = e.target.value.toLowerCase();
            kkCurrentPage = 1;
            renderKotaKabTable();
        });
    }

    // ========================================
    // TABLE RENDERING
    // ========================================
    function getFilteredAndSortedData() {
        let data = [...provinsiData];
        if (searchTerm) {
            data = data.filter(p => p.nama.toLowerCase().includes(searchTerm) || p.kotaKab.some(k => k.nama.toLowerCase().includes(searchTerm)));
        }
        data.sort((a, b) => {
            let aVal = a[sortField];
            let bVal = b[sortField];
            if (typeof aVal === 'string') aVal = aVal.toLowerCase();
            if (typeof bVal === 'string') bVal = bVal.toLowerCase();
            if (aVal < bVal) return sortDirection === 'asc' ? -1 : 1;
            if (aVal > bVal) return sortDirection === 'asc' ? 1 : -1;
            return 0;
        });
        return data;
    }

    function renderTable() {
        const data = getFilteredAndSortedData();
        const total = data.length;
        const totalPages = Math.ceil(total / entriesPerPage);
        const start = (currentPage - 1) * entriesPerPage;
        const end = Math.min(start + entriesPerPage, total);
        const pageData = data.slice(start, end);
        const tbody = document.getElementById('province-table-body');
        tbody.innerHTML = pageData.map((prov, idx) => `
            <tr>
                <td>${start + idx + 1}</td>
                <td class="data-table__link" onclick="showKotaKabViewFor(${provinsiData.indexOf(prov)})">${prov.nama}</td>
                <td style="text-align:center">${createStatusBadge(prov.statusPokja)}</td>
                <td style="text-align:center">${prov.jumlahKotaKab}</td>
                <td style="text-align:center">${prov.jumlahPokjaKotaKab}</td>
                <td style="text-align:center">${prov.persentase.toFixed(1)}%</td>
                <td style="text-align:center"><a class="data-table__link" onclick="showAnggotaProvView(${provinsiData.indexOf(prov)})" style="cursor:pointer">Lihat</a></td>
            </tr>
        `).join('');
        document.getElementById('province-table-footer').innerHTML = `
            <tr class="table-footer-row">
                <td colspan="2">TOTAL SEMUA</td>
                <td style="text-align:center"></td>
                <td style="text-align:center">${pokjaTotals.jumlahKotaKab}</td>
                <td style="text-align:center">${pokjaTotals.jumlahPokjaKotaKab}</td>
                <td style="text-align:center">${pokjaTotals.persentase.toFixed(2)}%</td>
                <td></td>
            </tr>
        `;
        document.getElementById('pagination-info').textContent = `Showing ${start + 1} to ${end} of ${total} entries`;
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const container = document.getElementById('pagination-buttons');
        let html = `<button class="pagination__btn" onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>`;
        for (let i = 1; i <= Math.min(5, totalPages); i++) {
            html += `<button class="pagination__btn ${i === currentPage ? 'pagination__btn--active' : ''}" onclick="goToPage(${i})">${i}</button>`;
        }
        html += `<button class="pagination__btn" onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;
        container.innerHTML = html;
    }

    function goToPage(page) {
        const totalPages = Math.ceil(getFilteredAndSortedData().length / entriesPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTable();
    }

    function sortTable(field) {
        if (sortField === field) {
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            sortField = field;
            sortDirection = 'asc';
        }
        renderTable();
    }

    function createStatusBadge(status) {
        let cls = 'status-badge--muted';
        if (status === 'Terbentuk') cls = 'status-badge--success';
        else if (status === 'Dalam Proses') cls = 'status-badge--warning';
        return `<span class="status-badge ${cls}">${status}</span>`;
    }

    // ========================================
    // VIEW SWITCHING
    // ========================================
    function showListView() {
        document.getElementById('view-list').classList.remove('hidden');
        document.getElementById('view-kotakab').classList.add('hidden');
        document.getElementById('view-anggota-prov').classList.add('hidden');
        document.getElementById('view-anggota-kotakab').classList.add('hidden');
        selectedProvinsi = null;
        selectedKotaKab = null;
    }

    function showKotaKabViewFor(provIdx) {
        selectedProvinsi = provinsiData[provIdx];
        showKotaKabView();
    }

    function showKotaKabView() {
        if (!selectedProvinsi) return;
        kkSearchTerm = '';
        kkCurrentPage = 1;
        document.getElementById('kk-search-input').value = '';
        document.getElementById('view-list').classList.add('hidden');
        document.getElementById('view-kotakab').classList.remove('hidden');
        document.getElementById('view-anggota-prov').classList.add('hidden');
        document.getElementById('view-anggota-kotakab').classList.add('hidden');
        document.getElementById('breadcrumb-prov').textContent = `Prov. ${selectedProvinsi.nama}`;
        document.getElementById('kotakab-title').textContent = `Jumlah Kelompok Kerja tiap PROV. ${selectedProvinsi.nama.toUpperCase()}`;
        renderKotaKabTable();
    }

    function renderKotaKabTable() {
        const tbody = document.getElementById('kotakab-table-body');
        let kotaKab = selectedProvinsi.kotaKab;
        if (kkSearchTerm) {
            kotaKab = kotaKab.filter(k => k.nama.toLowerCase().includes(kkSearchTerm));
        }
        const filteredWithIdx = kotaKab.map(k => ({
            ...k,
            originalIdx: selectedProvinsi.kotaKab.indexOf(k)
        }));
        tbody.innerHTML = filteredWithIdx.map((k, displayIdx) => `
            <tr>
                <td>${displayIdx + 1}</td>
                <td>${k.nama}</td>
                <td style="text-align:center">${createStatusBadge(k.statusPokja)}</td>
                <td style="text-align:center">${k.jumlahAnggota}</td>
                <td style="text-align:center"><a class="data-table__link" onclick="showAnggotaKKView(${k.originalIdx})" style="cursor:pointer">Lihat</a></td>
            </tr>
        `).join('');
        const totalPokja = kotaKab.filter(k => k.pokjaKotaKab).length;
        const totalAnggota = kotaKab.reduce((sum, k) => sum + k.jumlahAnggota, 0);
        document.getElementById('kotakab-table-footer').innerHTML = `
            <tr class="table-footer-row">
                <td colspan="2">TOTAL (${kotaKab.length} hasil)</td>
                <td style="text-align:center">${createStatusBadge(totalPokja > 0 ? 'Terbentuk' : 'Belum Terbentuk')}</td>
                <td style="text-align:center">${totalAnggota}</td>
                <td></td>
            </tr>
        `;
    }

    function showAnggotaProvView(provIdx) {
        selectedProvinsi = provinsiData[provIdx];
        document.getElementById('view-list').classList.add('hidden');
        document.getElementById('view-kotakab').classList.add('hidden');
        document.getElementById('view-anggota-prov').classList.remove('hidden');
        document.getElementById('view-anggota-kotakab').classList.add('hidden');
        document.getElementById('anggota-prov-title').textContent = `Prov. ${selectedProvinsi.nama}`;
        renderAnggotaTable('anggota-prov-table-body', selectedProvinsi.anggota);
        renderSKInfo('sk-info-prov', 'operator-info-prov', selectedProvinsi);
    }

    function showAnggotaKKView(kkIdx) {
        selectedKotaKab = selectedProvinsi.kotaKab[kkIdx];
        document.getElementById('view-list').classList.add('hidden');
        document.getElementById('view-kotakab').classList.add('hidden');
        document.getElementById('view-anggota-prov').classList.add('hidden');
        document.getElementById('view-anggota-kotakab').classList.remove('hidden');
        document.getElementById('anggota-kk-title').textContent = selectedKotaKab.nama;
        document.getElementById('anggota-kk-prov').textContent = `Prov. ${selectedProvinsi.nama}`;
        renderAnggotaTable('anggota-kk-table-body', selectedKotaKab.anggota);
        renderSKInfo('sk-info-kk', 'operator-info-kk', selectedKotaKab);
    }

    function renderAnggotaTable(tbodyId, anggotaList) {
        const tbody = document.getElementById(tbodyId);
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const evenBg = isDark ? '#0F0A0A' : 'white';
        const oddBg = isDark ? '#0F0A0A' : '#f9fafb';
        const textColor = isDark ? 'white' : 'inherit';
        const linkColor = isDark ? '#60a5fa' : '#2563eb';

        if (!anggotaList || anggotaList.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding: 32px; color: var(--color-gray-500)">Data anggota belum tersedia</td></tr>`;
            return;
        }
        tbody.innerHTML = anggotaList.map((a, idx) => `
            <tr style="background: ${idx % 2 === 0 ? evenBg : oddBg}; color: ${textColor}">
                <td>${a.no}</td>
                <td style="color: ${linkColor}">${a.nama}</td>
                <td>${a.statusKeanggotaan}</td>
                <td>${a.asalInstansi}</td>
                <td style="text-align:center">${a.adminPokja ? '✓' : ''}</td>
            </tr>
        `).join('');
    }

    function renderSKInfo(skId, opId, data) {
        document.getElementById(skId).innerHTML = `
            <p><span>Nomor SK</span>: ${data.nomorSK}</p>
            <p><span>Tanggal SK</span>: ${data.tanggalSK}</p>
            <p><span>Tanggal Berakhir SK</span>: ${data.tanggalBerakhirSK}</p>
            <p><span>Status SK</span>: ${createStatusBadge(data.statusSK === 'Valid' ? 'Terbentuk' : 'Belum Terbentuk')}</p>
        `;
        document.getElementById(opId).innerHTML = `
            <p><strong>Operator Dinas:</strong> ${data.operatorDinas}</p>
            <p class="update">[Update ${data.lastUpdate}]</p>
        `;
    }

    // ========================================
    // EXPORT CSV
    // ========================================
    function exportToCSV() {
        const headers = ['No', 'Nama Provinsi', 'Status Pokja', 'Jumlah Kota/Kab', 'Jumlah Pokja Kota/Kab', 'Persentase'];
        const rows = getFilteredAndSortedData().map((p, i) => [i + 1, p.nama, p.statusPokja, p.jumlahKotaKab, p.jumlahPokjaKotaKab, p.persentase.toFixed(1) + '%']);
        const csv = [headers.join(','), ...rows.map(r => r.map(c => `"${c}"`).join(','))].join('\n');
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `data-pokja-${new Date().toISOString().split('T')[0]}.csv`;
        link.click();
    }
</script>
<?= $this->endSection() ?>
