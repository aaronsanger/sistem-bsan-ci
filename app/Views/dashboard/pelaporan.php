<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Pokja Not Approved Banner (injected by JS) -->
    <div id="pokja-gate-banner" class="hidden bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <div>
                <p class="font-semibold text-yellow-800 dark:text-yellow-300 text-base">Pokja Belum Disetujui</p>
                <p class="text-sm text-yellow-700 dark:text-yellow-400 mt-1">Fitur Pelaporan hanya aktif setelah data Pokja disetujui oleh Admin Pusat. Silakan lengkapi dan ajukan data Pokja terlebih dahulu.</p>
                <a href="/dashboard/pokja" class="inline-flex items-center gap-2 mt-3 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Isi Data Pokja
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pelaporan Insidental</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Buat dan kelola laporan kejadian insidental</p>
        </div>
        <button id="btn-buat-laporan" onclick="openForm()" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Laporan
        </button>
    </div>

    <!-- Records Table -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="records-table">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Nama Sekolah</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Kategori</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Tanggal Kejadian</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody id="records-tbody"></tbody>
            </table>
        </div>
        <div id="records-empty" class="text-center py-8 text-gray-500 dark:text-gray-400 hidden">
            Belum ada laporan insidental.
        </div>
    </div>
</div>

<!-- Form Modal -->
<div id="form-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeForm()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white dark:bg-[#0F0A0A] px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between z-10">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white" id="form-title">Buat Laporan Insidental</h3>
                <button onclick="closeForm()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-5">
                <input type="hidden" id="edit-index" value="-1">

                <!-- 1. Nama Sekolah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Sekolah <span class="text-red-500">*</span></label>
                    <input type="text" id="field-sekolah" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama sekolah">
                </div>

                <!-- 2. Unsur yang Terlibat (Matriks L/P) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Unsur yang Terlibat <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-400 mb-2">Isi jumlah Laki-laki (L) dan Perempuan (P) per unsur</p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200 dark:border-[#3f4739] rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-[#1a1414]">
                                    <th class="px-3 py-2 text-left text-gray-600 dark:text-gray-400">Unsur</th>
                                    <th class="px-3 py-2 text-center text-blue-600 w-20">L</th>
                                    <th class="px-3 py-2 text-center text-pink-600 w-20">P</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t dark:border-[#3f4739]">
                                    <td class="px-3 py-2 text-gray-700 dark:text-gray-300">Peserta Didik</td>
                                    <td class="px-3 py-1"><input type="number" min="0" value="0" class="unsur-l w-full text-center px-2 py-1.5 border border-gray-300 dark:border-[#3f4739] rounded bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm" data-unsur="peserta_didik"></td>
                                    <td class="px-3 py-1"><input type="number" min="0" value="0" class="unsur-p w-full text-center px-2 py-1.5 border border-gray-300 dark:border-[#3f4739] rounded bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm" data-unsur="peserta_didik"></td>
                                </tr>
                                <tr class="border-t dark:border-[#3f4739]">
                                    <td class="px-3 py-2 text-gray-700 dark:text-gray-300">Tenaga Pendidik</td>
                                    <td class="px-3 py-1"><input type="number" min="0" value="0" class="unsur-l w-full text-center px-2 py-1.5 border border-gray-300 dark:border-[#3f4739] rounded bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm" data-unsur="tenaga_pendidik"></td>
                                    <td class="px-3 py-1"><input type="number" min="0" value="0" class="unsur-p w-full text-center px-2 py-1.5 border border-gray-300 dark:border-[#3f4739] rounded bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm" data-unsur="tenaga_pendidik"></td>
                                </tr>
                                <tr class="border-t dark:border-[#3f4739]">
                                    <td class="px-3 py-2 text-gray-700 dark:text-gray-300">Tenaga Kependidikan</td>
                                    <td class="px-3 py-1"><input type="number" min="0" value="0" class="unsur-l w-full text-center px-2 py-1.5 border border-gray-300 dark:border-[#3f4739] rounded bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm" data-unsur="tenaga_kependidikan"></td>
                                    <td class="px-3 py-1"><input type="number" min="0" value="0" class="unsur-p w-full text-center px-2 py-1.5 border border-gray-300 dark:border-[#3f4739] rounded bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm" data-unsur="tenaga_kependidikan"></td>
                                </tr>
                                <tr class="border-t dark:border-[#3f4739]">
                                    <td class="px-3 py-2 text-gray-700 dark:text-gray-300">Pihak Luar</td>
                                    <td class="px-3 py-1"><input type="number" min="0" value="0" class="unsur-l w-full text-center px-2 py-1.5 border border-gray-300 dark:border-[#3f4739] rounded bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm" data-unsur="pihak_luar"></td>
                                    <td class="px-3 py-1"><input type="number" min="0" value="0" class="unsur-p w-full text-center px-2 py-1.5 border border-gray-300 dark:border-[#3f4739] rounded bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm" data-unsur="pihak_luar"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3. Kapan Terjadi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kapan Terjadi <span class="text-red-500">*</span></label>
                    <input type="date" id="field-tanggal" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <!-- 4. Kategori Pelanggaran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Pelanggaran <span class="text-red-500">*</span></label>
                    <select id="field-kategori" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih kategori</option>
                        <option value="Kekerasan Fisik">Kekerasan Fisik</option>
                        <option value="Kekerasan Psikis">Kekerasan Psikis</option>
                        <option value="Kekerasan Seksual">Kekerasan Seksual</option>
                        <option value="Perundungan (Bullying)">Perundungan (Bullying)</option>
                        <option value="Perundungan Siber">Perundungan Siber</option>
                        <option value="Diskriminasi">Diskriminasi</option>
                        <option value="Intoleransi">Intoleransi</option>
                        <option value="Penyalahgunaan Narkotika/Zat Adiktif">Penyalahgunaan Narkotika/Zat Adiktif</option>
                        <option value="Tawuran">Tawuran</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- 5. Dokumentasi (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dokumentasi <span class="text-gray-400">(opsional)</span></label>
                    <input type="file" id="field-dokumentasi" accept="image/*,.pdf" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">Foto atau PDF, maksimal 5MB</p>
                </div>

                <!-- 6. Rekomendasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rekomendasi <span class="text-red-500">*</span></label>
                    <textarea id="field-rekomendasi" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Rekomendasi tindak lanjut..."></textarea>
                </div>

                <!-- 7. Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status <span class="text-red-500">*</span></label>
                    <select id="field-status" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih status</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dihentikan">Dihentikan</option>
                        <option value="Dilimpahkan">Dilimpahkan</option>
                    </select>
                </div>
            </div>

            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closeForm()" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1a1414] transition-colors font-medium">Batal</button>
                <button onclick="saveRecord()" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detail-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeDetail()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white dark:bg-[#0F0A0A] px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Laporan</h3>
                <button onclick="closeDetail()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div id="detail-content" class="p-6 space-y-4"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const STORAGE_KEY = 'bsan_pelaporan_insidental';
const POKJA_SUBMISSIONS_KEY = 'bsan_pokja_submissions';

// Check if Pokja is approved for current role
function isPokjaApproved() {
    const role = localStorage.getItem('bsan_demo_role') || 'kementerian';
    if (role === 'kementerian') return true; // Admin always has access
    const subs = JSON.parse(localStorage.getItem(POKJA_SUBMISSIONS_KEY) || '[]');
    const provName = localStorage.getItem('bsan_wilayah_prov') || '';
    const kabName = localStorage.getItem('bsan_wilayah_kab') || '';
    let wilayah;
    if (role === 'dinas_prov') { wilayah = provName ? `Prov. ${provName}` : 'Provinsi'; }
    else { wilayah = kabName || 'Kabupaten/Kota'; }
    const mySub = subs.find(s => s.roleType === role && s.wilayah === wilayah);
    return mySub && mySub.status === 'approved';
}

const pokjaApproved = isPokjaApproved();

function getRecords() { return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]'); }
function saveRecords(d) { localStorage.setItem(STORAGE_KEY, JSON.stringify(d)); }

// Apply feature gating on page load
function applyFeatureGate() {
    if (!pokjaApproved) {
        document.getElementById('pokja-gate-banner').classList.remove('hidden');
        document.getElementById('btn-buat-laporan').classList.add('hidden');
    }
}

function openForm(editIdx) {
    document.getElementById('edit-index').value = editIdx ?? -1;
    document.getElementById('form-title').textContent = editIdx >= 0 ? 'Edit Laporan' : 'Buat Laporan Insidental';

    if (editIdx >= 0) {
        const r = getRecords()[editIdx];
        document.getElementById('field-sekolah').value = r.namaSekolah || '';
        document.getElementById('field-tanggal').value = r.tanggalKejadian || '';
        document.getElementById('field-kategori').value = r.kategori || '';
        document.getElementById('field-rekomendasi').value = r.rekomendasi || '';
        document.getElementById('field-status').value = r.status || '';
        // Fill unsur matrix
        if (r.unsurTerlibat) {
            const unsurs = ['peserta_didik', 'tenaga_pendidik', 'tenaga_kependidikan', 'pihak_luar'];
            unsurs.forEach(u => {
                const lInputs = document.querySelectorAll(`.unsur-l[data-unsur="${u}"]`);
                const pInputs = document.querySelectorAll(`.unsur-p[data-unsur="${u}"]`);
                if (lInputs[0] && r.unsurTerlibat[u]) lInputs[0].value = r.unsurTerlibat[u].L || 0;
                if (pInputs[0] && r.unsurTerlibat[u]) pInputs[0].value = r.unsurTerlibat[u].P || 0;
            });
        }
    } else {
        document.getElementById('field-sekolah').value = '';
        document.getElementById('field-tanggal').value = '';
        document.getElementById('field-kategori').value = '';
        document.getElementById('field-rekomendasi').value = '';
        document.getElementById('field-status').value = '';
        document.querySelectorAll('.unsur-l, .unsur-p').forEach(el => el.value = 0);
    }

    document.getElementById('form-modal').classList.remove('hidden');
}

function closeForm() { document.getElementById('form-modal').classList.add('hidden'); }

function gatherUnsur() {
    const unsurs = ['peserta_didik', 'tenaga_pendidik', 'tenaga_kependidikan', 'pihak_luar'];
    const result = {};
    unsurs.forEach(u => {
        const l = document.querySelector(`.unsur-l[data-unsur="${u}"]`);
        const p = document.querySelector(`.unsur-p[data-unsur="${u}"]`);
        result[u] = { L: parseInt(l?.value || 0), P: parseInt(p?.value || 0) };
    });
    return result;
}

function saveRecord() {
    const sekolah = document.getElementById('field-sekolah').value.trim();
    const tanggal = document.getElementById('field-tanggal').value;
    const kategori = document.getElementById('field-kategori').value;
    const rekomendasi = document.getElementById('field-rekomendasi').value.trim();
    const status = document.getElementById('field-status').value;
    const unsur = gatherUnsur();
    const dokFile = document.getElementById('field-dokumentasi').files[0];

    if (!sekolah || !tanggal || !kategori || !rekomendasi || !status) {
        alert('Lengkapi semua field wajib.'); return;
    }

    const records = getRecords();
    const editIdx = parseInt(document.getElementById('edit-index').value);
    const record = {
        namaSekolah: sekolah,
        unsurTerlibat: unsur,
        tanggalKejadian: tanggal,
        kategori: kategori,
        dokumentasi: dokFile ? dokFile.name : (editIdx >= 0 ? records[editIdx]?.dokumentasi : ''),
        rekomendasi: rekomendasi,
        status: status,
        updatedAt: new Date().toISOString(),
    };

    if (editIdx >= 0) {
        record.createdAt = records[editIdx].createdAt;
        records[editIdx] = record;
    } else {
        record.createdAt = new Date().toISOString();
        records.push(record);
    }

    saveRecords(records);
    closeForm();
    renderRecords();
    alert('Laporan berhasil disimpan!');
}

function renderRecords() {
    const records = getRecords();
    const tbody = document.getElementById('records-tbody');
    const empty = document.getElementById('records-empty');

    if (records.length === 0) {
        tbody.innerHTML = '';
        empty.classList.remove('hidden');
        return;
    }
    empty.classList.add('hidden');

    const statusColors = {
        'Selesai': 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
        'Dihentikan': 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
        'Dilimpahkan': 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
    };

    tbody.innerHTML = records.map((r, i) => `
        <tr class="border-b dark:border-[#3f4739] hover:bg-gray-50 dark:hover:bg-[#1a1414]">
            <td class="px-4 py-3 dark:text-white font-medium">${r.namaSekolah}</td>
            <td class="px-4 py-3 dark:text-gray-300">${r.kategori}</td>
            <td class="px-4 py-3 dark:text-gray-300 text-sm">${r.tanggalKejadian}</td>
            <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium ${statusColors[r.status] || ''}">${r.status}</span></td>
            <td class="px-4 py-3 flex gap-2">
                <button onclick="showDetail(${i})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">Detail</button>
                ${pokjaApproved ? `<button onclick="openForm(${i})" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 text-sm font-medium">Edit</button>
                <button onclick="deleteRecord(${i})" class="text-red-600 hover:text-red-800 dark:text-red-400 text-sm font-medium">Hapus</button>` : ''}
            </td>
        </tr>`).join('');
}

function showDetail(idx) {
    const r = getRecords()[idx];
    if (!r) return;

    const unsurLabels = { peserta_didik: 'Peserta Didik', tenaga_pendidik: 'Tenaga Pendidik', tenaga_kependidikan: 'Tenaga Kependidikan', pihak_luar: 'Pihak Luar' };
    let unsurHtml = '<table class="w-full text-sm border dark:border-[#3f4739] rounded"><thead><tr class="bg-gray-50 dark:bg-[#1a1414]"><th class="px-3 py-1.5 text-left">Unsur</th><th class="px-3 py-1.5 text-center text-blue-600">L</th><th class="px-3 py-1.5 text-center text-pink-600">P</th></tr></thead><tbody>';
    for (const [key, label] of Object.entries(unsurLabels)) {
        const u = r.unsurTerlibat?.[key] || { L: 0, P: 0 };
        unsurHtml += `<tr class="border-t dark:border-[#3f4739]"><td class="px-3 py-1.5 dark:text-gray-300">${label}</td><td class="px-3 py-1.5 text-center dark:text-white">${u.L}</td><td class="px-3 py-1.5 text-center dark:text-white">${u.P}</td></tr>`;
    }
    unsurHtml += '</tbody></table>';

    document.getElementById('detail-content').innerHTML = `
        <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Sekolah</span><p class="text-gray-900 dark:text-white font-semibold">${r.namaSekolah}</p></div>
        <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Unsur yang Terlibat</span>${unsurHtml}</div>
        <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kejadian</span><p class="text-gray-900 dark:text-white">${r.tanggalKejadian}</p></div>
        <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori Pelanggaran</span><p class="text-gray-900 dark:text-white">${r.kategori}</p></div>
        <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Dokumentasi</span><p class="text-gray-900 dark:text-white">${r.dokumentasi || 'Tidak ada'}</p></div>
        <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Rekomendasi</span><p class="text-gray-900 dark:text-white">${r.rekomendasi}</p></div>
        <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span><p class="text-gray-900 dark:text-white font-semibold">${r.status}</p></div>
    `;
    document.getElementById('detail-modal').classList.remove('hidden');
}

function closeDetail() { document.getElementById('detail-modal').classList.add('hidden'); }

function deleteRecord(idx) {
    if (!confirm('Hapus laporan ini?')) return;
    const records = getRecords();
    records.splice(idx, 1);
    saveRecords(records);
    renderRecords();
}

$(document).ready(function() { applyFeatureGate(); renderRecords(); });
</script>
<?= $this->endSection() ?>
