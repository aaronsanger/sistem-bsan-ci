<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<!-- Admin Kementerian Dashboard -->
<div id="view-kementerian" class="hidden space-y-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Dashboard Admin Kementerian Pusat</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitoring dan approval Pokja seluruh wilayah</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Wilayah</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1" id="stat-total">552</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1" id="stat-pending">0</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Disetujui</p>
            <p class="text-2xl font-bold text-green-600 mt-1" id="stat-approved">0</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Ditolak</p>
            <p class="text-2xl font-bold text-red-600 mt-1" id="stat-declined">0</p>
        </div>
    </div>

    <!-- Log Table -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Log Pengajuan Pokja</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Wilayah</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Jenis</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Tanggal</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody id="log-tbody"></tbody>
            </table>
        </div>
        <div id="log-empty" class="hidden text-center py-8 text-gray-500 dark:text-gray-400">
            Belum ada pengajuan Pokja.
        </div>
    </div>
</div>

<!-- Admin Dinas Dashboard -->
<div id="view-dinas" class="hidden space-y-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white" id="dinas-title">Dashboard</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" id="dinas-subtitle">Kelola Pokja daerah Anda</p>
    </div>

    <!-- Decline Banner -->
    <div id="decline-banner" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-semibold text-red-800 dark:text-red-300">Pengajuan Ditolak</p>
                <p class="text-sm text-red-700 dark:text-red-400 mt-1" id="decline-reason"></p>
            </div>
        </div>
    </div>

    <!-- Pending Banner -->
    <div id="pending-banner" class="hidden bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-semibold text-yellow-800 dark:text-yellow-300">⏳ Menunggu Approval</p>
                <p class="text-sm text-yellow-700 dark:text-yellow-400 mt-1">Pengajuan Pokja sedang diproses oleh Admin Pusat.</p>
            </div>
        </div>
    </div>

    <!-- Approved Banner -->
    <div id="approved-banner" class="hidden bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-semibold text-green-800 dark:text-green-300">✅ Pokja Disetujui</p>
                <p class="text-sm text-green-700 dark:text-green-400 mt-1">Pokja Anda telah disetujui oleh Admin Pusat.</p>
            </div>
        </div>
    </div>

    <!-- SK Card Spotlight -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-800 dark:to-blue-950 rounded-xl p-6 text-white">
        <p class="text-sm text-blue-100 mb-1">Nomor SK Pokja</p>
        <p class="text-2xl font-bold" id="sk-nomor-display">-</p>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Status Pokja</p>
            <p class="text-lg font-bold mt-1" id="status-pokja">Belum Ada</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Masa Berlaku SK</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white mt-1" id="masa-berlaku">-</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Status Pengajuan</p>
            <p class="text-lg font-bold mt-1" id="status-pengajuan">-</p>
        </div>
    </div>

    <!-- Bentuk Pokja Button -->
    <div id="bentuk-pokja-section" class="text-center py-6">
        <a href="/dashboard/pokja" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-lg transition-colors text-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Bentuk Pokja
        </a>
    </div>

    <!-- Quick Links (Dinas only) -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Menu Cepat</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="/dashboard" class="flex flex-col items-center p-4 rounded-xl bg-gray-50 dark:bg-gray-900/20 hover:bg-gray-100 dark:hover:bg-gray-900/30 transition-colors">
                <svg class="w-8 h-8 text-gray-600 dark:text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <span class="text-sm font-medium text-gray-800 dark:text-gray-300">Dashboard</span>
            </a>
            <a href="/dashboard/pokja" class="flex flex-col items-center p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span class="text-sm font-medium text-blue-800 dark:text-blue-300">Pokja</span>
            </a>
            <a href="/dashboard/pelaporan" class="flex flex-col items-center p-4 rounded-xl bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                <svg class="w-8 h-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <span class="text-sm font-medium text-orange-800 dark:text-orange-300">Pelaporan</span>
            </a>
            <a href="/dashboard/sumber-rujukan" class="flex flex-col items-center p-4 rounded-xl bg-teal-50 dark:bg-teal-900/20 hover:bg-teal-100 dark:hover:bg-teal-900/30 transition-colors">
                <svg class="w-8 h-8 text-teal-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                <span class="text-sm font-medium text-teal-800 dark:text-teal-300">Sumber Rujukan</span>
            </a>
        </div>
    </div>
</div>

<!-- Kementerian: Detail Modal -->
<div id="detail-approval-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeApprovalModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white dark:bg-[#0F0A0A] px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Pengajuan Pokja</h3>
                <button onclick="closeApprovalModal()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="approval-detail-content" class="p-6 space-y-4"></div>
            <div id="approval-actions" class="px-6 pb-6 flex gap-3">
                <button onclick="showDeclineForm()" class="flex-1 px-4 py-2.5 border border-red-300 dark:border-red-800 rounded-lg text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors font-medium">Tolak</button>
                <button onclick="approvePokja()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Setujui</button>
            </div>
            <div id="decline-form" class="hidden px-6 pb-6 space-y-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Penolakan</label>
                <textarea id="decline-reason-input" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 outline-none resize-none" placeholder="Jelaskan alasan penolakan..."></textarea>
                <div class="flex gap-3">
                    <button onclick="cancelDecline()" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1a1414] transition-colors font-medium">Batal</button>
                    <button onclick="declinePokja()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Tolak Pengajuan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const POKJA_SUBMISSIONS_KEY = 'bsan_pokja_submissions';
    let currentApprovalIdx = -1;

    function getSubmissions() { return JSON.parse(localStorage.getItem(POKJA_SUBMISSIONS_KEY) || '[]'); }
    function saveSubmissions(d) { localStorage.setItem(POKJA_SUBMISSIONS_KEY, JSON.stringify(d)); }

    function initDashboard() {
        const role = localStorage.getItem('bsan_demo_role') || 'kementerian';
        if (role === 'kementerian') {
            document.getElementById('view-kementerian').classList.remove('hidden');
            renderKementerianDashboard();
        } else {
            document.getElementById('view-dinas').classList.remove('hidden');
            renderDinasDashboard(role);
        }
    }

    // ---- Kementerian Dashboard ----
    function renderKementerianDashboard() {
        const subs = getSubmissions();
        const pending = subs.filter(s => s.status === 'pending').length;
        const approved = subs.filter(s => s.status === 'approved').length;
        const declined = subs.filter(s => s.status === 'declined').length;

        document.getElementById('stat-pending').textContent = pending;
        document.getElementById('stat-approved').textContent = approved;
        document.getElementById('stat-declined').textContent = declined;

        const tbody = document.getElementById('log-tbody');
        const empty = document.getElementById('log-empty');

        if (subs.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');
        tbody.innerHTML = subs.map((s, i) => {
            const statusColors = {
                draft: 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400',
                pending: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
                approved: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
                declined: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
            };
            const statusLabel = {
                draft: 'Draft',
                pending: 'Pending',
                approved: 'Disetujui',
                declined: 'Ditolak',
            };
            const date = new Date(s.submittedAt || s.createdAt);
            const dateStr = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            const jenisLabel = s.roleType === 'dinas_prov' ? 'Provinsi' : 'Kab/Kota';

            return `<tr class="border-b dark:border-[#3f4739] hover:bg-gray-50 dark:hover:bg-[#1a1414]">
                <td class="px-4 py-3 dark:text-white font-medium">${s.wilayah || s.namaPokja || '-'}</td>
                <td class="px-4 py-3 dark:text-gray-300">${jenisLabel}</td>
                <td class="px-4 py-3 dark:text-gray-300 text-sm">${dateStr}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium ${statusColors[s.status]}">${statusLabel[s.status]}${s.status === 'declined' && s.declineReason ? ' (' + s.declineReason.substring(0, 30) + ')' : ''}</span></td>
                <td class="px-4 py-3">
                    <button onclick="openApprovalDetail(${i})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">Detail</button>
                </td>
            </tr>`;
        }).join('');
    }

    function openApprovalDetail(idx) {
        const subs = getSubmissions();
        const s = subs[idx];
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

        // Show/hide actions based on status
        const actionsEl = document.getElementById('approval-actions');
        const declineFormEl = document.getElementById('decline-form');
        if (s.status === 'pending') {
            actionsEl.classList.remove('hidden');
        } else {
            actionsEl.classList.add('hidden');
        }
        declineFormEl.classList.add('hidden');

        document.getElementById('detail-approval-modal').classList.remove('hidden');
    }

    function closeApprovalModal() {
        document.getElementById('detail-approval-modal').classList.add('hidden');
        currentApprovalIdx = -1;
    }

    function approvePokja() {
        if (currentApprovalIdx < 0) return;
        const subs = getSubmissions();
        subs[currentApprovalIdx].status = 'approved';
        subs[currentApprovalIdx].approvedAt = new Date().toISOString();
        saveSubmissions(subs);
        closeApprovalModal();
        renderKementerianDashboard();
    }

    function showDeclineForm() {
        document.getElementById('approval-actions').classList.add('hidden');
        document.getElementById('decline-form').classList.remove('hidden');
    }

    function cancelDecline() {
        document.getElementById('decline-form').classList.add('hidden');
        document.getElementById('approval-actions').classList.remove('hidden');
    }

    function declinePokja() {
        if (currentApprovalIdx < 0) return;
        const reason = document.getElementById('decline-reason-input').value.trim();
        if (!reason) { alert('Masukkan alasan penolakan.'); return; }
        const subs = getSubmissions();
        subs[currentApprovalIdx].status = 'declined';
        subs[currentApprovalIdx].declineReason = reason;
        subs[currentApprovalIdx].declinedAt = new Date().toISOString();
        saveSubmissions(subs);
        alert('Pengajuan ditolak.');
        closeApprovalModal();
        renderKementerianDashboard();
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
                document.getElementById('pending-banner').classList.remove('hidden');
            } else if (mySub.status === 'declined') {
                document.getElementById('decline-banner').classList.remove('hidden');
                document.getElementById('decline-reason').textContent = mySub.declineReason || 'Tidak ada alasan.';
            } else if (mySub.status === 'approved') {
                document.getElementById('approved-banner').classList.remove('hidden');
                document.getElementById('bentuk-pokja-section').classList.add('hidden');
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
