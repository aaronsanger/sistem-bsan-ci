<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6" id="sd-app">
    <!-- Dynamic content rendered by JS -->
</div>

<!-- Add/Edit Entry Modal -->
<div id="entry-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeEntryModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white dark:bg-[#0F0A0A] px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between z-10">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white" id="entry-modal-title">Tambah Sumber Dukungan</h3>
                <button onclick="closeEntryModal()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="p-6 space-y-5">
                <input type="hidden" id="entry-edit-idx" value="-1">

                <!-- Kategori Bentuk Dukungan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Bentuk Dukungan <span class="text-red-500">*</span></label>
                    <select id="entry-kategori" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih kategori</option>
                        <option value="Layanan Kesehatan">Layanan Kesehatan</option>
                        <option value="Layanan Konseling/Psikologi">Layanan Konseling/Psikologi</option>
                        <option value="Layanan Disabilitas">Layanan Disabilitas</option>
                        <option value="Pendampingan Sosial">Pendampingan Sosial</option>
                        <option value="Bimbingan Rohani">Bimbingan Rohani</option>
                        <option value="Bantuan Hukum & Advokasi">Bantuan Hukum & Advokasi</option>
                        <option value="Kepolisian">Kepolisian</option>
                        <option value="Pendampingan Profesi">Pendampingan Profesi</option>
                        <option value="Penanggulangan Bencana">Penanggulangan Bencana</option>
                        <option value="Layanan Lain">Layanan Lain</option>
                    </select>
                </div>

                <!-- Asal K/L atau Perangkat Daerah -->
                <div id="asal-group">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asal Kementerian/Lembaga <span class="text-red-500">*</span></label>
                    <select id="entry-asal" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih</option>
                    </select>
                </div>

                <!-- Nama Instansi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Instansi <span class="text-red-500">*</span></label>
                    <input type="text" id="entry-nama" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama instansi/lembaga">
                </div>

                <!-- Penyedia Layanan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Penyedia Layanan <span class="text-red-500">*</span></label>
                    <select id="entry-penyedia" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih</option>
                        <option value="Pemerintah Pusat">Pemerintah Pusat</option>
                        <option value="Pemerintah Daerah">Pemerintah Daerah</option>
                        <option value="Swasta">Swasta</option>
                        <option value="NGO/OMS">NGO/OMS</option>
                    </select>
                </div>

                <hr class="dark:border-[#3f4739]">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Alamat</h4>

                <!-- Alamat Lengkap -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Nama Jalan & Nomor</label>
                        <input type="text" id="entry-jalan" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Jl. Contoh No. 1">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Kelurahan</label>
                        <input type="text" id="entry-kelurahan" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Kelurahan">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Kecamatan</label>
                        <input type="text" id="entry-kecamatan" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Kecamatan">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Kode Pos</label>
                        <input type="text" id="entry-kodepos" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Kode pos">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Tautan Google Maps <span class="text-gray-400">(opsional)</span></label>
                        <input type="url" id="entry-gmaps" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="https://maps.google.com/...">
                    </div>
                </div>

                <hr class="dark:border-[#3f4739]">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Kontak</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">No. Call Center (Publik)</label>
                        <input type="tel" id="entry-callcenter" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Diakses publik">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">No. Pribadi</label>
                        <input type="tel" id="entry-nopribadi" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="No. HP pribadi">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">No. Call Center Pokja</label>
                        <input type="tel" id="entry-callcenterpokja" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nomor khusus Pokja">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Website <span class="text-gray-400">(opsional)</span></label>
                        <input type="url" id="entry-website" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="https://...">
                    </div>
                </div>
            </div>

            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closeEntryModal()" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1a1414] transition-colors font-medium">Batal</button>
                <button onclick="saveEntry()" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="sd-detail-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeDetailModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white dark:bg-[#0F0A0A] px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Sumber Dukungan</h3>
                <button onclick="closeDetailModal()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]"><svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div id="sd-detail-content" class="p-6 space-y-3"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const SD_KEY = 'bsan_sumber_dukungan';
const role = localStorage.getItem('bsan_demo_role') || 'kementerian';

// Only Kementerian and Koordinator (dinas) can input
const canInput = (role === 'kementerian' || role === 'dinas_prov' || role === 'dinas_kab');

// Kementerian-level K/L sources
const KL_SOURCES = [
    { label: 'KemenPPPA', items: 'UPTD PPPA, Puspaga' },
    { label: 'Kemensos', items: 'Dinsos, Peksos' },
    { label: 'Kemendagri', items: 'Kantor Lurah/Desa, Kantor Camat' },
    { label: 'TNI', items: 'Babinsa' },
    { label: 'Polri', items: 'Bhabinkamtibmas, Polsek, Polres, Polda (unit PPA)' },
    { label: 'Kemenkum', items: 'LBH, OMS, Lembaga Advokat, LPSK' },
    { label: 'Kemenkes', items: 'Puskesmas, RSUD, Psikolog, PMI' },
    { label: 'Kemendikdasmen', items: 'ULD (Unit Layanan Disabilitas)' },
    { label: 'Kemendukbangga / Direktorat Bina Ketahanan Remaja', items: 'PIK-R, GenRe' },
    { label: 'Kemenag', items: 'Tokoh Agama, Organisasi Agama (PHDI, KWI, MLKI, Majelis Tinggi Agama Konghucu, PGI, Walubi, MUI, PP Muhammadiyah, PP NU)' },
    { label: 'KPAI', items: 'KPAD' },
    { label: 'KND (Komisi Nasional Disabilitas)', items: 'Level Provinsi' },
    { label: 'BNPB', items: 'Pemadam Kebakaran' },
    { label: 'KemenkoPMK', items: 'Peserta koordinasi' },
];

// Pokja-level perangkat daerah
const POKJA_SOURCES = [
    { label: 'Sekretariat Daerah', items: 'OMS, LBH, Tokoh Masyarakat' },
    { label: 'Bidang Sosial', items: 'Peksos' },
    { label: 'Bidang Pendidikan', items: 'K3TK, K3S, MKKS, MKPS, Organisasi Profesi PTK, Satgas Perlindungan PTK, Pengawas, Penilik' },
    { label: 'Bidang PPPA', items: 'UPT PPPA' },
    { label: 'Bidang Kominfo', items: 'Dinas Kominfo, Layanan Siber' },
    { label: 'Bidang Dukbangga', items: 'PIK-R, GenRe' },
    { label: 'Bidang Kesehatan', items: 'RSUD, Puskesmas, PMI' },
    { label: 'Bidang Penanggulangan Bencana', items: 'Damkar' },
    { label: 'Kelompok Kerja BSAN', items: 'Kontak Koordinator dan Anggota Pokja' },
];

function getEntries() { return JSON.parse(localStorage.getItem(SD_KEY) || '[]'); }
function saveEntries(d) { localStorage.setItem(SD_KEY, JSON.stringify(d)); }

function renderPage() {
    const app = document.getElementById('sd-app');
    const entries = getEntries();
    const isPokja = (role === 'dinas_prov' || role === 'dinas_kab');
    const isKementerian = (role === 'kementerian');

    // Header
    let html = `
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Sumber Dukungan BSAN</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Informasi penyedia sumber dukungan BSAN sesuai Permendikdasmen 6/2026</p>
        </div>
        ${canInput ? `<button onclick="openEntryModal()" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Data
        </button>` : ''}
    </div>`;

    // Info banner for Kementerian
    if (isKementerian) {
        html += `<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
            <h4 class="font-semibold text-blue-800 dark:text-blue-300 text-sm mb-2">📋 Proses Input — Kementerian/Lembaga</h4>
            <p class="text-sm text-blue-700 dark:text-blue-400">Menghimpun data sumber dukungan dari ${KL_SOURCES.length} K/L terkait.</p>
            <div class="mt-3 flex flex-wrap gap-2">
                ${KL_SOURCES.map(s => `<span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded text-xs">${s.label}</span>`).join('')}
            </div>
        </div>`;
    }

    // Info banner for Pokja
    if (isPokja) {
        html += `<div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
            <h4 class="font-semibold text-green-800 dark:text-green-300 text-sm mb-2">📋 Proses Input — Pokja (Perangkat Daerah)</h4>
            <p class="text-sm text-green-700 dark:text-green-400">Menghimpun data sumber dukungan dari perangkat daerah.</p>
            <div class="mt-3 flex flex-wrap gap-2">
                ${POKJA_SOURCES.map(s => `<span class="px-2 py-1 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded text-xs">${s.label}</span>`).join('')}
            </div>
        </div>`;
    }

    // Stats cards
    const categories = {};
    entries.forEach(e => { categories[e.kategori] = (categories[e.kategori] || 0) + 1; });
    const uniqueCategories = Object.keys(categories).length;
    html += `
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5"><p class="text-sm text-gray-500 dark:text-gray-400">Total Data</p><p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">${entries.length}</p></div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5"><p class="text-sm text-gray-500 dark:text-gray-400">Kategori Terisi</p><p class="text-2xl font-bold text-blue-600 mt-1">${uniqueCategories}</p></div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5"><p class="text-sm text-gray-500 dark:text-gray-400">Pem. Pusat</p><p class="text-2xl font-bold text-green-600 mt-1">${entries.filter(e => e.penyedia === 'Pemerintah Pusat').length}</p></div>
        <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-5"><p class="text-sm text-gray-500 dark:text-gray-400">Pem. Daerah</p><p class="text-2xl font-bold text-purple-600 mt-1">${entries.filter(e => e.penyedia === 'Pemerintah Daerah').length}</p></div>
    </div>`;

    // Filter bar
    html += `
    <div class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <input type="text" id="search-input" oninput="renderTable()" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="🔍 Cari instansi...">
        </div>
        <select id="filter-kategori" onchange="renderTable()" class="px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">Semua Kategori</option>
            <option value="Layanan Kesehatan">Layanan Kesehatan</option>
            <option value="Layanan Konseling/Psikologi">Layanan Konseling/Psikologi</option>
            <option value="Layanan Disabilitas">Layanan Disabilitas</option>
            <option value="Pendampingan Sosial">Pendampingan Sosial</option>
            <option value="Bimbingan Rohani">Bimbingan Rohani</option>
            <option value="Bantuan Hukum & Advokasi">Bantuan Hukum & Advokasi</option>
            <option value="Kepolisian">Kepolisian</option>
            <option value="Pendampingan Profesi">Pendampingan Profesi</option>
            <option value="Penanggulangan Bencana">Penanggulangan Bencana</option>
            <option value="Layanan Lain">Layanan Lain</option>
        </select>
    </div>`;

    // Data table
    html += `
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Nama Instansi</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Kategori</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Penyedia</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Call Center</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sd-tbody"></tbody>
            </table>
        </div>
        <div id="sd-empty" class="text-center py-8 text-gray-500 dark:text-gray-400 hidden">Belum ada data sumber dukungan.</div>
    </div>`;

    app.innerHTML = html;
    renderTable();
}

function renderTable() {
    const entries = getEntries();
    const search = document.getElementById('search-input')?.value?.toLowerCase() || '';
    const filterKat = document.getElementById('filter-kategori')?.value || '';

    const filtered = entries.filter(e => {
        const matchSearch = !search || e.namaInstansi.toLowerCase().includes(search) || (e.asal || '').toLowerCase().includes(search);
        const matchKat = !filterKat || e.kategori === filterKat;
        return matchSearch && matchKat;
    });

    const tbody = document.getElementById('sd-tbody');
    const empty = document.getElementById('sd-empty');

    if (!filtered.length) {
        tbody.innerHTML = '';
        empty.classList.remove('hidden');
        return;
    }
    empty.classList.add('hidden');

    const penyediaColors = {
        'Pemerintah Pusat': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
        'Pemerintah Daerah': 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
        'Swasta': 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
        'NGO/OMS': 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300',
    };

    tbody.innerHTML = filtered.map((e, i) => {
        const origIdx = entries.indexOf(e);
        return `<tr class="border-b dark:border-[#3f4739] hover:bg-gray-50 dark:hover:bg-[#1a1414]">
            <td class="px-4 py-3 font-medium dark:text-white">${e.namaInstansi}</td>
            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">${e.kategori}</td>
            <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium ${penyediaColors[e.penyedia] || ''}">${e.penyedia}</span></td>
            <td class="px-4 py-3 text-sm dark:text-gray-300">${e.callCenter || '-'}</td>
            <td class="px-4 py-3 flex gap-2">
                <button onclick="showDetail(${origIdx})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">Detail</button>
                ${canInput ? `<button onclick="openEntryModal(${origIdx})" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 text-sm font-medium">Edit</button>
                <button onclick="deleteEntry(${origIdx})" class="text-red-600 hover:text-red-800 dark:text-red-400 text-sm font-medium">Hapus</button>` : ''}
            </td>
        </tr>`;
    }).join('');
}

function updateAsalOptions() {
    const isPokja = (role === 'dinas_prov' || role === 'dinas_kab');
    const sources = isPokja ? POKJA_SOURCES : KL_SOURCES;
    const label = isPokja ? 'Asal Perangkat Daerah' : 'Asal Kementerian/Lembaga';

    const group = document.getElementById('asal-group');
    group.querySelector('label').innerHTML = `${label} <span class="text-red-500">*</span>`;
    const sel = document.getElementById('entry-asal');
    sel.innerHTML = '<option value="">Pilih</option>' + sources.map(s => `<option value="${s.label}">${s.label} — ${s.items}</option>`).join('');
}

function openEntryModal(editIdx) {
    document.getElementById('entry-edit-idx').value = editIdx ?? -1;
    document.getElementById('entry-modal-title').textContent = editIdx >= 0 ? 'Edit Sumber Dukungan' : 'Tambah Sumber Dukungan';
    updateAsalOptions();

    if (editIdx >= 0) {
        const e = getEntries()[editIdx];
        document.getElementById('entry-kategori').value = e.kategori || '';
        document.getElementById('entry-asal').value = e.asal || '';
        document.getElementById('entry-nama').value = e.namaInstansi || '';
        document.getElementById('entry-penyedia').value = e.penyedia || '';
        document.getElementById('entry-jalan').value = e.jalan || '';
        document.getElementById('entry-kelurahan').value = e.kelurahan || '';
        document.getElementById('entry-kecamatan').value = e.kecamatan || '';
        document.getElementById('entry-kodepos').value = e.kodePos || '';
        document.getElementById('entry-gmaps').value = e.googleMaps || '';
        document.getElementById('entry-callcenter').value = e.callCenter || '';
        document.getElementById('entry-nopribadi').value = e.noPribadi || '';
        document.getElementById('entry-callcenterpokja').value = e.callCenterPokja || '';
        document.getElementById('entry-website').value = e.website || '';
    } else {
        ['entry-kategori', 'entry-asal', 'entry-nama', 'entry-penyedia', 'entry-jalan', 'entry-kelurahan', 'entry-kecamatan', 'entry-kodepos', 'entry-gmaps', 'entry-callcenter', 'entry-nopribadi', 'entry-callcenterpokja', 'entry-website'].forEach(id => document.getElementById(id).value = '');
    }

    document.getElementById('entry-modal').classList.remove('hidden');
}

function closeEntryModal() { document.getElementById('entry-modal').classList.add('hidden'); }

function saveEntry() {
    const kategori = document.getElementById('entry-kategori').value;
    const asal = document.getElementById('entry-asal').value;
    const nama = document.getElementById('entry-nama').value.trim();
    const penyedia = document.getElementById('entry-penyedia').value;

    if (!kategori || !asal || !nama || !penyedia) { alert('Lengkapi semua field wajib.'); return; }

    const entry = {
        kategori, asal, namaInstansi: nama, penyedia,
        jalan: document.getElementById('entry-jalan').value.trim(),
        kelurahan: document.getElementById('entry-kelurahan').value.trim(),
        kecamatan: document.getElementById('entry-kecamatan').value.trim(),
        kodePos: document.getElementById('entry-kodepos').value.trim(),
        googleMaps: document.getElementById('entry-gmaps').value.trim(),
        callCenter: document.getElementById('entry-callcenter').value.trim(),
        noPribadi: document.getElementById('entry-nopribadi').value.trim(),
        callCenterPokja: document.getElementById('entry-callcenterpokja').value.trim(),
        website: document.getElementById('entry-website').value.trim(),
        inputBy: role,
        updatedAt: new Date().toISOString(),
    };

    const entries = getEntries();
    const editIdx = parseInt(document.getElementById('entry-edit-idx').value);
    if (editIdx >= 0) {
        entry.createdAt = entries[editIdx].createdAt;
        entries[editIdx] = entry;
    } else {
        entry.createdAt = new Date().toISOString();
        entries.push(entry);
    }

    saveEntries(entries);
    closeEntryModal();
    renderPage();
    alert('Data berhasil disimpan!');
}

function showDetail(idx) {
    const e = getEntries()[idx];
    if (!e) return;
    const alamat = [e.jalan, e.kelurahan, e.kecamatan, e.kodePos].filter(Boolean).join(', ') || '-';
    document.getElementById('sd-detail-content').innerHTML = `
        <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Instansi</span><p class="text-gray-900 dark:text-white font-semibold text-lg">${e.namaInstansi}</p></div>
        <div class="grid grid-cols-2 gap-4">
            <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kategori</span><p class="text-gray-900 dark:text-white text-sm">${e.kategori}</p></div>
            <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Asal K/L</span><p class="text-gray-900 dark:text-white text-sm">${e.asal}</p></div>
            <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Penyedia</span><p class="text-gray-900 dark:text-white text-sm">${e.penyedia}</p></div>
            <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Input Oleh</span><p class="text-gray-900 dark:text-white text-sm">${e.inputBy}</p></div>
        </div>
        <hr class="dark:border-[#3f4739]">
        <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Alamat</span><p class="text-gray-900 dark:text-white text-sm">${alamat}</p></div>
        ${e.googleMaps ? `<div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Google Maps</span><p><a href="${e.googleMaps}" target="_blank" class="text-blue-600 hover:underline text-sm">Buka di Google Maps ↗</a></p></div>` : ''}
        <hr class="dark:border-[#3f4739]">
        <div class="grid grid-cols-2 gap-4">
            <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Call Center (Publik)</span><p class="text-gray-900 dark:text-white text-sm font-mono">${e.callCenter || '-'}</p></div>
            <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">No. Pribadi</span><p class="text-gray-900 dark:text-white text-sm font-mono">${e.noPribadi || '-'}</p></div>
            <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Call Center Pokja</span><p class="text-gray-900 dark:text-white text-sm font-mono">${e.callCenterPokja || '-'}</p></div>
            <div><span class="text-xs font-medium text-gray-500 dark:text-gray-400">Website</span><p>${e.website ? `<a href="${e.website}" target="_blank" class="text-blue-600 hover:underline text-sm">${e.website}</a>` : '-'}</p></div>
        </div>
    `;
    document.getElementById('sd-detail-modal').classList.remove('hidden');
}

function closeDetailModal() { document.getElementById('sd-detail-modal').classList.add('hidden'); }

function deleteEntry(idx) {
    if (!confirm('Hapus data sumber dukungan ini?')) return;
    const entries = getEntries();
    entries.splice(idx, 1);
    saveEntries(entries);
    renderPage();
}

$(document).ready(function() { renderPage(); });
</script>
<?= $this->endSection() ?>
