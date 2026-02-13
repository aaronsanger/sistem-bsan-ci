<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6" id="pokja-app">
    <!-- Loading / Init -->
</div>

<!-- Demo Info Modal -->
<div id="demo-info-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-lg shadow-2xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center gap-3">
                <span class="text-2xl">⚠️</span>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Penting — Mode Demo Pokja</h3>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Mohon diperhatikan sebelum mengisi struktur Pokja:</p>
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h4 class="font-semibold text-blue-800 dark:text-blue-300 text-sm mb-1">📧 Email Ketua Pokja</h4>
                    <p class="text-sm text-blue-700 dark:text-blue-400">Khusus Ketua Pokja diisi memakai <strong>email asli</strong> sebagai contoh simulasi pengiriman link verifikasi.</p>
                    <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Password dapat dibuat sendiri setelah pemilik email klik link verifikasi dan proses verifikasi berhasil.</p>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <h4 class="font-semibold text-yellow-800 dark:text-yellow-300 text-sm mb-1">📧 Email selain Ketua Pokja</h4>
                    <p class="text-sm text-yellow-700 dark:text-yellow-400">Selain Ketua Pokja <strong>jangan menggunakan</strong> alamat email asli.</p>
                    <p class="text-sm text-yellow-700 dark:text-yellow-400 mt-1">Email selain Ketua akan langsung aktif dan bisa digunakan login Masuk Anggota Pokja.</p>
                    <p class="text-sm text-yellow-700 dark:text-yellow-400 mt-1">Password masuk: <code class="bg-yellow-100 dark:bg-yellow-900/50 px-2 py-0.5 rounded font-mono font-bold">pokja12345</code></p>
                </div>
            </div>
            <div class="px-6 pb-6">
                <button onclick="closeDemoInfo()" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>

<!-- Submit Confirmation Modal -->
<div id="submit-confirm-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-md shadow-2xl p-8 text-center">
            <div class="w-16 h-16 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Ajukan Pokja ke Admin Pusat?</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Data akan dikunci dan tidak bisa diedit selama proses review.</p>
            <div class="flex gap-3">
                <button onclick="closeSubmitConfirm()" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1a1414] transition-colors font-medium">Cancel</button>
                <button onclick="submitToAdmin()" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">OK</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const POKJA_SUBMISSIONS_KEY = 'bsan_pokja_submissions';
const DEMO_SHOWN_KEY = 'bsan_pokja_demo_shown';
const role = localStorage.getItem('bsan_demo_role') || 'kementerian';

function getSubmissions() { return JSON.parse(localStorage.getItem(POKJA_SUBMISSIONS_KEY) || '[]'); }
function saveSubmissions(d) { localStorage.setItem(POKJA_SUBMISSIONS_KEY, JSON.stringify(d)); }

function getMySubmission() {
    const subs = getSubmissions();
    return { sub: subs.find(s => s.roleType === role), idx: subs.findIndex(s => s.roleType === role) };
}

// Default Anggota list
const defaultAnggota = [
    { bidang: 'Bidang Pendidikan', nama: '', email: '', instansi: '' },
    { bidang: 'Bidang PPPA', nama: '', email: '', instansi: '' },
    { bidang: 'Bidang Sosial', nama: '', email: '', instansi: '' },
    { bidang: 'Bidang Kesehatan', nama: '', email: '', instansi: '' },
    { bidang: 'Bidang Dukbangga', nama: '', email: '', instansi: '' },
    { bidang: 'Bidang Kominfo', nama: '', email: '', instansi: '' },
];

function init() {
    if (role === 'kementerian') {
        // Kementerian shouldn't be on pokja page — redirect to dashboard
        location.href = '/dashboard';
        return;
    }

    // Show demo info first time
    if (!localStorage.getItem(DEMO_SHOWN_KEY + '_' + role)) {
        document.getElementById('demo-info-modal').classList.remove('hidden');
    }

    renderPokjaPage();
}

function closeDemoInfo() {
    document.getElementById('demo-info-modal').classList.add('hidden');
    localStorage.setItem(DEMO_SHOWN_KEY + '_' + role, '1');
}

function renderPokjaPage() {
    const { sub } = getMySubmission();
    const app = document.getElementById('pokja-app');
    const wilayah = role === 'dinas_prov' ? 'Prov. Aceh' : 'Kota Banda Aceh';

    if (!sub) {
        // No submission yet — show creation form
        renderCreationForm(app, wilayah);
    } else if (sub.status === 'draft') {
        renderDraftView(app, sub, wilayah);
    } else if (sub.status === 'pending') {
        renderPendingView(app, sub, wilayah);
    } else if (sub.status === 'approved') {
        renderApprovedView(app, sub, wilayah);
    } else if (sub.status === 'declined') {
        renderDeclinedView(app, sub, wilayah);
    }
}

function renderCreationForm(app, wilayah) {
    app.innerHTML = buildFormHTML(wilayah, null);
    setupFormEvents();
}

function buildFormHTML(wilayah, existing) {
    const s = existing?.struktur || {};
    const sk = existing || {};
    const anggotaList = s.anggota && s.anggota.length ? s.anggota : defaultAnggota;
    const activeTab = existing?.nomorSK ? 'sk' : 'struktur';

    return `
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Bentuk Pokja</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lengkapi data Pokja ${wilayah}</p>
        </div>
    </div>

    ${sk.nomorSK ? '' : `
    <!-- SK Reminder -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 flex items-start gap-3" id="sk-reminder">
        <span class="text-xl">📄</span>
        <div class="flex-1">
            <p class="font-semibold text-blue-800 dark:text-blue-300">Dokumen SK</p>
            <p class="text-sm text-blue-700 dark:text-blue-400">Lengkapi dan unggah file SK agar Pokja dapat diajukan ke Admin Pusat.</p>
        </div>
        <button onclick="switchTab('sk')" class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors whitespace-nowrap">Lengkapi Data SK</button>
    </div>
    `}

    <!-- Tabs -->
    <div class="flex gap-1 bg-gray-100 dark:bg-[#1a1414] p-1 rounded-lg">
        <button onclick="switchTab('struktur')" id="tab-btn-struktur" class="flex-1 px-4 py-2 rounded-md text-sm font-medium transition-colors ${activeTab === 'struktur' ? 'bg-white dark:bg-[#0F0A0A] text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'}">1. Struktur Pokja</button>
        <button onclick="switchTab('sk')" id="tab-btn-sk" class="flex-1 px-4 py-2 rounded-md text-sm font-medium transition-colors ${activeTab === 'sk' ? 'bg-white dark:bg-[#0F0A0A] text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'}">2. Data SK</button>
    </div>

    <!-- Tab 1: Struktur Pokja -->
    <div id="tab-struktur" class="${activeTab === 'struktur' ? '' : 'hidden'}">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6 space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Struktur & Anggota Pokja ${wilayah}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lengkapi struktur Pokja sebelum mengunggah SK</p>
            </div>

            <!-- Nama Pokja -->
            <div>
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Identitas Pokja</h4>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Pokja <span class="text-red-500">*</span></label>
                <input type="text" id="nama-pokja" value="${sk.namaPokja || ''}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Pokja BSAN ${wilayah}">
            </div>

            <hr class="dark:border-[#3f4739]">

            <!-- Pimpinan Pokja -->
            <div>
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Pimpinan Pokja</h4>

                <!-- Ketua -->
                <div class="border border-gray-200 dark:border-[#3f4739] rounded-xl p-4 mb-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">Ketua Pokja</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Sekretaris Daerah</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input type="text" id="ketua-nama" value="${s.ketua?.nama || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama Ketua">
                        <input type="email" id="ketua-email" value="${s.ketua?.email || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Email Ketua (email asli)">
                        <input type="text" id="ketua-instansi" value="${s.ketua?.instansi || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Instansi Ketua">
                    </div>
                </div>

                <!-- Wakil Ketua -->
                <div class="border border-gray-200 dark:border-[#3f4739] rounded-xl p-4 mb-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">Wakil Ketua</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Kepala Bappeda</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input type="text" id="wakil-nama" value="${s.wakil?.nama || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama Wakil">
                        <input type="email" id="wakil-email" value="${s.wakil?.email || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Email Wakil">
                        <input type="text" id="wakil-instansi" value="${s.wakil?.instansi || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Instansi Wakil">
                    </div>
                </div>

                <!-- Koordinator -->
                <div class="border border-gray-200 dark:border-[#3f4739] rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">Koordinator</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Kepala Dinas Pendidikan</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input type="text" id="koordinator-nama" value="${s.koordinator?.nama || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama Koordinator">
                        <input type="email" id="koordinator-email" value="${s.koordinator?.email || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Email Koordinator">
                        <input type="text" id="koordinator-instansi" value="${s.koordinator?.instansi || ''}" class="inp px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Instansi Koordinator">
                    </div>
                </div>
            </div>

            <hr class="dark:border-[#3f4739]">

            <!-- Anggota Pokja -->
            <div>
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Anggota Pokja</h4>
                <div id="anggota-container" class="space-y-3">
                    ${anggotaList.map((a, i) => buildAnggotaRow(a, i)).join('')}
                </div>
                <button onclick="addAnggota()" class="mt-3 inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 text-sm font-medium hover:text-blue-800 dark:hover:text-blue-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Anggota
                </button>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end pt-4 border-t dark:border-[#3f4739]">
                <button onclick="saveStruktur()" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">Simpan Struktur Pokja</button>
            </div>
        </div>
    </div>

    <!-- Tab 2: Data SK -->
    <div id="tab-sk" class="${activeTab === 'sk' ? '' : 'hidden'}">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6 space-y-5">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data SK Pokja ${wilayah}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lengkapi data SK sebelum mengajukan ke Admin Pusat</p>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Informasi SK</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor SK <span class="text-red-500">*</span></label>
                        <input type="text" id="nomor-sk" value="${sk.nomorSK || ''}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nomor SK">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal SK <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal-sk" value="${sk.tanggalSK || ''}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periode Mulai <span class="text-red-500">*</span></label>
                        <input type="date" id="periode-mulai" value="${sk.periodeMulai || ''}" onchange="autoSetPeriodeSelesai()" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periode Selesai <span class="text-red-500">*</span></label>
                        <input type="date" id="periode-selesai" value="${sk.periodeSelesai || ''}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Dokumen SK</h4>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload SK (PDF)</label>
                <input type="file" id="sk-file" accept=".pdf" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
                <p class="text-xs text-gray-400 mt-1">Maksimal 2MB, format PDF</p>
                ${sk.skFileName ? `<p class="text-sm text-green-600 dark:text-green-400 mt-1">📄 ${sk.skFileName}</p>` : ''}
            </div>

            <div class="flex gap-3 pt-4 border-t dark:border-[#3f4739]">
                <button onclick="switchTab('struktur')" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1a1414] transition-colors font-medium">Batal</button>
                <button onclick="saveSK()" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Simpan Data SK</button>
            </div>
        </div>
    </div>
    `;
}

function buildAnggotaRow(a, i) {
    return `<div class="border border-gray-200 dark:border-[#3f4739] rounded-xl p-4 anggota-row" data-index="${i}">
        <div class="flex items-center justify-between mb-3">
            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">${a.bidang || 'Anggota Baru'}</span>
            ${i >= 6 ? `<button onclick="removeAnggota(${i})" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>` : ''}
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <input type="text" value="${a.nama || ''}" class="anggota-nama px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama">
            <input type="email" value="${a.email || ''}" class="anggota-email px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Email">
            <input type="text" value="${a.instansi || ''}" class="anggota-instansi px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Instansi">
        </div>
    </div>`;
}

function addAnggota() {
    const container = document.getElementById('anggota-container');
    const rows = container.querySelectorAll('.anggota-row');
    const newIdx = rows.length;
    container.insertAdjacentHTML('beforeend', buildAnggotaRow({ bidang: `Anggota Tambahan ${newIdx - 5}`, nama: '', email: '', instansi: '' }, newIdx));
}

function removeAnggota(idx) {
    const rows = document.querySelectorAll('.anggota-row');
    if (rows[idx]) rows[idx].remove();
    // Re-index
    document.querySelectorAll('.anggota-row').forEach((row, i) => row.dataset.index = i);
}

function switchTab(tab) {
    document.getElementById('tab-struktur').classList.toggle('hidden', tab !== 'struktur');
    document.getElementById('tab-sk').classList.toggle('hidden', tab !== 'sk');
    document.getElementById('tab-btn-struktur').classList.toggle('bg-white', tab === 'struktur');
    document.getElementById('tab-btn-struktur').classList.toggle('dark:bg-[#0F0A0A]', tab === 'struktur');
    document.getElementById('tab-btn-struktur').classList.toggle('text-gray-900', tab === 'struktur');
    document.getElementById('tab-btn-struktur').classList.toggle('dark:text-white', tab === 'struktur');
    document.getElementById('tab-btn-struktur').classList.toggle('shadow-sm', tab === 'struktur');
    document.getElementById('tab-btn-sk').classList.toggle('bg-white', tab === 'sk');
    document.getElementById('tab-btn-sk').classList.toggle('dark:bg-[#0F0A0A]', tab === 'sk');
    document.getElementById('tab-btn-sk').classList.toggle('text-gray-900', tab === 'sk');
    document.getElementById('tab-btn-sk').classList.toggle('dark:text-white', tab === 'sk');
    document.getElementById('tab-btn-sk').classList.toggle('shadow-sm', tab === 'sk');
}

function autoSetPeriodeSelesai() {
    const mulai = document.getElementById('periode-mulai').value;
    if (mulai) {
        const d = new Date(mulai);
        d.setFullYear(d.getFullYear() + 4);
        document.getElementById('periode-selesai').value = d.toISOString().split('T')[0];
    }
}

function gatherStruktur() {
    return {
        ketua: { nama: $('#ketua-nama').val(), email: $('#ketua-email').val(), instansi: $('#ketua-instansi').val() },
        wakil: { nama: $('#wakil-nama').val(), email: $('#wakil-email').val(), instansi: $('#wakil-instansi').val() },
        koordinator: { nama: $('#koordinator-nama').val(), email: $('#koordinator-email').val(), instansi: $('#koordinator-instansi').val() },
        anggota: Array.from(document.querySelectorAll('.anggota-row')).map((row, i) => {
            const bidangEl = row.querySelector('.text-xs.font-semibold, span');
            return {
                bidang: bidangEl ? bidangEl.textContent.trim() : `Anggota ${i+1}`,
                nama: row.querySelector('.anggota-nama')?.value || '',
                email: row.querySelector('.anggota-email')?.value || '',
                instansi: row.querySelector('.anggota-instansi')?.value || '',
            };
        })
    };
}

function saveStruktur() {
    const namaPokja = document.getElementById('nama-pokja').value.trim();
    if (!namaPokja) { alert('Masukkan Nama Pokja.'); return; }

    const struktur = gatherStruktur();
    if (!struktur.ketua.nama) { alert('Masukkan nama Ketua Pokja.'); return; }

    const subs = getSubmissions();
    const { idx } = getMySubmission();
    const wilayah = role === 'dinas_prov' ? 'Prov. Aceh' : 'Kota Banda Aceh';

    const submission = idx >= 0 ? { ...subs[idx] } : {
        roleType: role,
        wilayah: wilayah,
        status: 'draft',
        createdAt: new Date().toISOString(),
    };

    submission.namaPokja = namaPokja;
    submission.struktur = struktur;
    submission.updatedAt = new Date().toISOString();

    if (idx >= 0) {
        subs[idx] = submission;
    } else {
        subs.push(submission);
    }
    saveSubmissions(subs);
    alert('Struktur Pokja berhasil disimpan!');
    renderPokjaPage();
}

function saveSK() {
    const nomorSK = document.getElementById('nomor-sk').value.trim();
    const tanggalSK = document.getElementById('tanggal-sk').value;
    const periodeMulai = document.getElementById('periode-mulai').value;
    const periodeSelesai = document.getElementById('periode-selesai').value;
    const skFile = document.getElementById('sk-file').files[0];

    if (!nomorSK || !tanggalSK || !periodeMulai || !periodeSelesai) {
        alert('Lengkapi semua field SK.'); return;
    }

    const subs = getSubmissions();
    const { idx } = getMySubmission();
    if (idx < 0) { alert('Simpan Struktur Pokja terlebih dahulu.'); return; }

    subs[idx].nomorSK = nomorSK;
    subs[idx].tanggalSK = tanggalSK;
    subs[idx].periodeMulai = periodeMulai;
    subs[idx].periodeSelesai = periodeSelesai;
    subs[idx].skFileName = skFile ? skFile.name : subs[idx].skFileName || '';
    subs[idx].updatedAt = new Date().toISOString();

    saveSubmissions(subs);
    alert('Data SK berhasil disimpan!');
    renderPokjaPage();
}

function setupFormEvents() {
    // Auto-fill periode selesai
    const mulaiEl = document.getElementById('periode-mulai');
    if (mulaiEl) mulaiEl.addEventListener('change', autoSetPeriodeSelesai);
}

// ---- Draft View ----
function renderDraftView(app, sub, wilayah) {
    const hasStruktur = sub.struktur && sub.struktur.ketua;
    const hasSK = sub.nomorSK;
    const canSubmit = hasStruktur && hasSK;

    let strukturRecap = '';
    if (hasStruktur) {
        const s = sub.struktur;
        strukturRecap = `
        <div class="space-y-2">
            ${renderMemberLine('Ketua — Sekretaris Daerah', s.ketua)}
            ${renderMemberLine('Wakil Ketua — Kepala Bappeda', s.wakil)}
            ${renderMemberLine('Koordinator — Kepala Dinas Pendidikan', s.koordinator)}
            ${(s.anggota || []).map(a => renderMemberLine(a.bidang, a)).join('')}
        </div>`;
    }

    app.innerHTML = `
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Data Pokja ${wilayah}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Review dan ajukan Pokja ke Admin Pusat</p>
        </div>
    </div>

    ${!hasSK ? `
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 flex items-start gap-3">
        <span class="text-xl">📄</span>
        <div class="flex-1">
            <p class="font-semibold text-blue-800 dark:text-blue-300">Dokumen SK</p>
            <p class="text-sm text-blue-700 dark:text-blue-400">Lengkapi dan unggah file SK agar Pokja dapat diajukan ke Admin Pusat.</p>
        </div>
        <button onclick="editPokja('sk')" class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors whitespace-nowrap">Lengkapi Data SK</button>
    </div>` : ''}

    ${canSubmit ? `
    <div class="flex justify-end">
        <button onclick="confirmSubmit()" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Ajukan ke Admin Pusat
        </button>
    </div>` : ''}

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Nama Pokja</p>
            <p class="font-bold text-gray-900 dark:text-white mt-1">${sub.namaPokja || '-'}</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Nomor SK</p>
            <p class="font-bold text-gray-900 dark:text-white mt-1">${sub.nomorSK || '-'}</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Masa Berlaku SK</p>
            <p class="font-bold text-gray-900 dark:text-white mt-1">${sub.periodeMulai && sub.periodeSelesai ? sub.periodeMulai + ' s/d ' + sub.periodeSelesai : '-'}</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Dokumen SK</p>
            <p class="font-bold text-gray-900 dark:text-white mt-1">${sub.skFileName ? '📄 ' + sub.skFileName : '-'}</p>
        </div>
    </div>

    <!-- Struktur Recap -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Struktur dan Anggota Pokja</h3>
            <button onclick="editPokja('struktur')" class="text-blue-600 dark:text-blue-400 text-sm font-medium hover:text-blue-800">Edit Struktur</button>
        </div>
        ${strukturRecap || '<p class="text-gray-400">Belum ada data struktur.</p>'}
    </div>
    `;
}

function renderMemberLine(label, m) {
    if (!m || !m.nama) return '';
    return `<div class="flex items-start gap-3 border-b dark:border-[#3f4739] pb-2">
        <div class="flex-1">
            <p class="text-xs text-gray-500 dark:text-gray-400">${label}</p>
            <p class="font-medium text-gray-900 dark:text-white">${m.nama || '-'}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">${m.email || '-'} · ${m.instansi || '-'}</p>
        </div>
    </div>`;
}

function editPokja(tab) {
    const { sub } = getMySubmission();
    const wilayah = role === 'dinas_prov' ? 'Prov. Aceh' : 'Kota Banda Aceh';
    const app = document.getElementById('pokja-app');
    app.innerHTML = buildFormHTML(wilayah, sub);
    setupFormEvents();
    if (tab) switchTab(tab);
}

function confirmSubmit() {
    document.getElementById('submit-confirm-modal').classList.remove('hidden');
}

function closeSubmitConfirm() {
    document.getElementById('submit-confirm-modal').classList.add('hidden');
}

function submitToAdmin() {
    const subs = getSubmissions();
    const { idx } = getMySubmission();
    if (idx < 0) return;
    subs[idx].status = 'pending';
    subs[idx].submittedAt = new Date().toISOString();
    saveSubmissions(subs);
    closeSubmitConfirm();
    renderPokjaPage();
}

// ---- Pending View ----
function renderPendingView(app, sub, wilayah) {
    app.innerHTML = `
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Data Pokja ${wilayah}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Status pengajuan Pokja</p>
    </div>

    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6 text-center">
        <div class="w-16 h-16 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-300">⏳ Menunggu Approval</h3>
        <p class="text-sm text-yellow-700 dark:text-yellow-400 mt-2">Pengajuan Pokja sedang diproses oleh Admin Pusat.</p>
    </div>

    ${renderReadonlySummary(sub)}
    `;
}

// ---- Approved View ----
function renderApprovedView(app, sub, wilayah) {
    app.innerHTML = `
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Data Pokja ${wilayah}</h2>
    </div>

    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 text-center">
        <div class="w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-green-800 dark:text-green-300">✅ Pokja Disetujui</h3>
        <p class="text-sm text-green-700 dark:text-green-400 mt-2">Pokja Anda telah disetujui oleh Admin Pusat.</p>
    </div>

    ${renderReadonlySummary(sub)}
    `;
}

// ---- Declined View ----
function renderDeclinedView(app, sub, wilayah) {
    app.innerHTML = `
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Data Pokja ${wilayah}</h2>
    </div>

    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 flex items-start gap-3">
        <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div class="flex-1">
            <p class="font-semibold text-red-800 dark:text-red-300">Pengajuan Ditolak</p>
            <p class="text-sm text-red-700 dark:text-red-400 mt-1">${sub.declineReason || 'Tidak ada alasan.'}</p>
        </div>
    </div>

    ${renderReadonlySummary(sub)}

    <div class="flex justify-end">
        <button onclick="resubmit()" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit & Ajukan Ulang
        </button>
    </div>
    `;
}

function resubmit() {
    const subs = getSubmissions();
    const { idx } = getMySubmission();
    if (idx < 0) return;
    subs[idx].status = 'draft';
    subs[idx].declineReason = '';
    saveSubmissions(subs);
    editPokja('struktur');
}

function renderReadonlySummary(sub) {
    const s = sub.struktur || {};
    let membersHtml = '';
    if (s.ketua) membersHtml += renderMemberLine('Ketua — Sekretaris Daerah', s.ketua);
    if (s.wakil) membersHtml += renderMemberLine('Wakil Ketua — Kepala Bappeda', s.wakil);
    if (s.koordinator) membersHtml += renderMemberLine('Koordinator — Kepala Dinas Pendidikan', s.koordinator);
    if (s.anggota) s.anggota.forEach(a => { membersHtml += renderMemberLine(a.bidang, a); });

    return `
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Nama Pokja</p>
            <p class="font-bold text-gray-900 dark:text-white mt-1">${sub.namaPokja || '-'}</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Nomor SK</p>
            <p class="font-bold text-gray-900 dark:text-white mt-1">${sub.nomorSK || '-'}</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Masa Berlaku SK</p>
            <p class="font-bold text-gray-900 dark:text-white mt-1">${sub.periodeMulai && sub.periodeSelesai ? sub.periodeMulai + ' s/d ' + sub.periodeSelesai : '-'}</p>
        </div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Dokumen SK</p>
            <p class="font-bold text-gray-900 dark:text-white mt-1">${sub.skFileName ? '📄 ' + sub.skFileName : '-'}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Struktur dan Anggota Pokja</h3>
        <div class="space-y-2">${membersHtml || '<p class="text-gray-400">Tidak ada data struktur.</p>'}</div>
    </div>`;
}

$(document).ready(function() { init(); });
</script>
<?= $this->endSection() ?>
