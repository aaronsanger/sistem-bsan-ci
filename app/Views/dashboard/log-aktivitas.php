<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Log Aktivitas Admin</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Riwayat lengkap aksi Admin Pusat terhadap pengajuan Pokja</p>
    </div>

    <!-- Filter / Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Aksi</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1" id="stat-total-actions">0</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Disetujui</p>
            <p class="text-2xl font-bold text-green-600 mt-1" id="stat-approved-actions">0</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Ditolak</p>
            <p class="text-2xl font-bold text-red-600 mt-1" id="stat-declined-actions">0</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Aksi Terakhir</p>
            <p class="text-sm font-bold text-gray-900 dark:text-white mt-1" id="stat-last-action">-</p>
        </div>
    </div>

    <!-- Log Table -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Waktu</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Aksi</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Wilayah</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Admin</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="activity-log-tbody"></tbody>
            </table>
        </div>
        <div id="log-empty" class="hidden text-center py-8 text-gray-500 dark:text-gray-400">
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
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');
        tbody.innerHTML = log.map(l => {
            const d = new Date(l.timestamp);
            const dateStr = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            const isApproved = l.action === 'approved';
            const actionBadge = isApproved
                ? '<span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">✅ Disetujui</span>'
                : '<span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">❌ Ditolak</span>';

            return `<tr class="border-b dark:border-[#3f4739] hover:bg-gray-50 dark:hover:bg-[#1a1414]">
                <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-sm whitespace-nowrap">${dateStr}</td>
                <td class="px-4 py-3">${actionBadge}</td>
                <td class="px-4 py-3 dark:text-white font-medium">${l.wilayah || '-'}</td>
                <td class="px-4 py-3 dark:text-gray-300">${l.admin || '-'}</td>
                <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-sm">${l.reason || '-'}</td>
            </tr>`;
        }).join('');
    }

    $(document).ready(function() { renderActivityLog(); });
</script>
<?= $this->endSection() ?>
