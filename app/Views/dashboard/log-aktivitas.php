<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <div>
        <h2 class="dash-card__title" style="font-size:1.25rem">Log Aktivitas Admin</h2>
        <p class="dash-card__subtitle">Riwayat lengkap aksi Admin Pusat terhadap pengajuan Pokja</p>
    </div>

    <!-- Filter / Stats -->
    <div class="dash-grid--4">
        <div class="stat-card">
            <p class="stat-card__label">Total Aksi</p>
            <p class="stat-card__value" id="stat-total-actions">0</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__label">Disetujui</p>
            <p class="stat-card__value" id="stat-approved-actions" style="color:#16a34a">0</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__label">Ditolak</p>
            <p class="stat-card__value" id="stat-declined-actions" style="color:#dc2626">0</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__label">Aksi Terakhir</p>
            <p class="stat-card__value" id="stat-last-action" style="font-size:0.875rem">-</p>
        </div>
    </div>

    <!-- Log Table -->
    <div class="dash-card">
        <div class="dash-table__wrapper">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Aksi</th>
                        <th>Wilayah</th>
                        <th>Admin</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="activity-log-tbody"></tbody>
            </table>
        </div>
        <div id="log-empty" style="display:none" class="dash-table__empty">
            Belum ada aktivitas tercatat.
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const POKJA_ACTION_LOG_KEY = 'bsan_pokja_action_log';

    function getActionLog() { return JSON.parse(localStorage.getItem(POKJA_ACTION_LOG_KEY) || '[]'); }

    function renderActivityLog() {
        const log = getActionLog();
        const tbody = document.getElementById('activity-log-tbody');
        const empty = document.getElementById('log-empty');

        // Stats
        const approved = log.filter(l => l.action === 'approved').length;
        const declined = log.filter(l => l.action === 'declined').length;
        document.getElementById('stat-total-actions').textContent = log.length;
        document.getElementById('stat-approved-actions').textContent = approved;
        document.getElementById('stat-declined-actions').textContent = declined;

        if (log.length > 0) {
            const last = log[0];
            const d = new Date(last.timestamp);
            document.getElementById('stat-last-action').textContent = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
        }

        if (log.length === 0) {
            tbody.innerHTML = '';
            empty.style.display = '';
            return;
        }

        empty.style.display = 'none';
        tbody.innerHTML = log.map(l => {
            const d = new Date(l.timestamp);
            const dateStr = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            const isApproved = l.action === 'approved';
            const actionBadge = isApproved
                ? '<span class="badge badge--success">✅ Disetujui</span>'
                : '<span class="badge badge--danger">❌ Ditolak</span>';

            return `<tr>
                <td style="white-space:nowrap">${dateStr}</td>
                <td>${actionBadge}</td>
                <td class="dash-table__cell--primary">${l.wilayah || '-'}</td>
                <td>${l.admin || '-'}</td>
                <td>${l.reason || '-'}</td>
            </tr>`;
        }).join('');
    }

    $(document).ready(function() { renderActivityLog(); });
</script>
<?= $this->endSection() ?>
