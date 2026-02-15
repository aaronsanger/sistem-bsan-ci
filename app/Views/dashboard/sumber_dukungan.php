<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6" id="sd-app">
    <!-- Dynamic content rendered by JS -->
</div>

<!-- Add/Edit Entry Modal -->
<div id="entry-modal" class="modal" style="display:none">
    <div class="modal__backdrop" onclick="closeEntryModal()"></div>
    <div class="modal__container" style="max-width:42rem">
        <div class="modal__content">
            <div class="modal__header">
                <h3 class="modal__title" id="entry-modal-title">Tambah Sumber Rujukan</h3>
                <button onclick="closeEntryModal()" class="modal__close"><svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="p-6 space-y-5">
                <input type="hidden" id="entry-edit-idx" value="-1">

                <!-- Kategori Bentuk Dukungan -->
                <div>
                    <label class="form-label">Kategori Bentuk Dukungan <span style="color:#ef4444">*</span></label>
                    <select id="entry-kategori" class="form-select">
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
                    <label class="form-label">Asal Kementerian/Lembaga <span style="color:#ef4444">*</span></label>
                    <select id="entry-asal" class="form-select">
                        <option value="">Pilih</option>
                    </select>
                </div>

                <!-- Nama Instansi -->
                <div>
                    <label class="form-label">Nama Instansi <span style="color:#ef4444">*</span></label>
                    <input type="text" id="entry-nama" class="form-input" placeholder="Nama instansi/lembaga">
                </div>

                <!-- Penyedia Layanan -->
                <div>
                    <label class="form-label">Penyedia Layanan <span style="color:#ef4444">*</span></label>
                    <select id="entry-penyedia" class="form-select">
                        <option value="">Pilih</option>
                        <option value="Pemerintah Pusat">Pemerintah Pusat</option>
                        <option value="Pemerintah Daerah">Pemerintah Daerah</option>
                        <option value="Swasta">Swasta</option>
                        <option value="NGO/OMS">NGO/OMS</option>
                    </select>
                </div>

                <hr style="border-color:var(--dash-border)">
                <h4 class="form-label" style="font-weight:600">Alamat</h4>

                <!-- Alamat Lengkap -->
                <div class="dash-grid--2" style="gap:0.75rem">
                    <div style="grid-column:span 2">
                        <label class="form-label" style="font-size:0.75rem">Nama Jalan & Nomor</label>
                        <input type="text" id="entry-jalan" class="form-input" placeholder="Jl. Contoh No. 1">
                    </div>
                    <div>
                        <label class="form-label" style="font-size:0.75rem">Kelurahan</label>
                        <input type="text" id="entry-kelurahan" class="form-input" placeholder="Kelurahan">
                    </div>
                    <div>
                        <label class="form-label" style="font-size:0.75rem">Kecamatan</label>
                        <input type="text" id="entry-kecamatan" class="form-input" placeholder="Kecamatan">
                    </div>
                    <div>
                        <label class="form-label" style="font-size:0.75rem">Kode Pos</label>
                        <input type="text" id="entry-kodepos" class="form-input" placeholder="Kode pos">
                    </div>
                    <div>
                        <label class="form-label" style="font-size:0.75rem">Tautan Google Maps <span style="color:var(--dash-text-muted)">(opsional)</span></label>
                        <input type="url" id="entry-gmaps" class="form-input" placeholder="https://maps.google.com/...">
                    </div>
                </div>

                <hr style="border-color:var(--dash-border)">
                <h4 class="form-label" style="font-weight:600">Kontak</h4>

                <div class="dash-grid--2" style="gap:0.75rem">
                    <div>
                        <label class="form-label" style="font-size:0.75rem">No. Call Center (Publik)</label>
                        <input type="tel" id="entry-callcenter" class="form-input" placeholder="Diakses publik">
                    </div>
                    <div>
                        <label class="form-label" style="font-size:0.75rem">No. Pribadi</label>
                        <input type="tel" id="entry-nopribadi" class="form-input" placeholder="No. HP pribadi">
                    </div>
                    <div>
                        <label class="form-label" style="font-size:0.75rem">No. Call Center Pokja</label>
                        <input type="tel" id="entry-callcenterpokja" class="form-input" placeholder="Nomor khusus Pokja">
                    </div>
                    <div>
                        <label class="form-label" style="font-size:0.75rem">Website <span style="color:var(--dash-text-muted)">(opsional)</span></label>
                        <input type="url" id="entry-website" class="form-input" placeholder="https://...">
                    </div>
                </div>
            </div>

            <div style="padding:0 1.5rem 1.5rem;display:flex;gap:0.75rem">
                <button onclick="closeEntryModal()" class="btn-dash btn-dash--outline" style="flex:1">Batal</button>
                <button onclick="saveEntry()" class="btn-dash btn-dash--primary" style="flex:1">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="sd-detail-modal" class="modal" style="display:none">
    <div class="modal__backdrop" onclick="closeDetailModal()"></div>
    <div class="modal__container" style="max-width:32rem">
        <div class="modal__content">
            <div class="modal__header">
                <h3 class="modal__title">Detail Sumber Rujukan</h3>
                <button onclick="closeDetailModal()" class="modal__close"><svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div id="sd-detail-content" class="p-6 space-y-3"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const SD_KEY = 'bsan_sumber_rujukan';
const POKJA_SUBMISSIONS_KEY = 'bsan_pokja_submissions';
const role = localStorage.getItem('bsan_demo_role') || 'kementerian';

// Check if Pokja is approved for current role
function isPokjaApproved() {
    if (role === 'kementerian') return true;
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

// Only allowed to input if role allows AND Pokja is approved
const canInput = (role === 'kementerian' || ((role === 'dinas_prov' || role === 'dinas_kab') && pokjaApproved));

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

    let html = '';

    // Pokja gate banner for dinas who are not approved
    if (isPokja && !pokjaApproved) {
        html += `<div class="dash-alert dash-alert--warning">
            <div style="display:flex;align-items:flex-start;gap:0.75rem">
                <svg style="width:1.5rem;height:1.5rem;color:#d97706;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <div>
                    <p style="font-weight:600;font-size:1rem">Pokja Belum Disetujui</p>
                    <p style="font-size:0.875rem;margin-top:0.25rem">Fitur Sumber Rujukan hanya aktif setelah data Pokja disetujui oleh Admin Pusat. Silakan lengkapi dan ajukan data Pokja terlebih dahulu.</p>
                    <a href="/dashboard/pokja" class="btn-dash btn-dash--warning" style="display:inline-flex;align-items:center;gap:0.5rem;margin-top:0.75rem;font-size:0.875rem">
                        <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Isi Data Pokja
                    </a>
                </div>
            </div>
        </div>`;
    }

    html += `
    <div class="d-flex d-flex--between d-flex--wrap d-flex--gap-4" style="align-items:center">
        <div>
            <h2 class="dash-card__title" style="font-size:1.25rem">Sumber Rujukan BSAN</h2>
            <p class="dash-card__subtitle">Informasi penyedia sumber rujukan BSAN sesuai Permendikdasmen 6/2026</p>
        </div>
        ${canInput ? `<button onclick="openEntryModal()" class="btn-dash btn-dash--primary" style="display:inline-flex;align-items:center;gap:0.5rem;flex-shrink:0">
            <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Data
        </button>` : ''}
    </div>`;

    // Info banner for Kementerian
    if (isKementerian) {
        html += `<div class="dash-alert dash-alert--info">
            <h4 style="font-weight:600;font-size:0.875rem;margin-bottom:0.5rem">📋 Proses Input — Kementerian/Lembaga</h4>
            <p style="font-size:0.875rem">Menghimpun data sumber rujukan dari ${KL_SOURCES.length} K/L terkait.</p>
            <div style="margin-top:0.75rem;display:flex;flex-wrap:wrap;gap:0.5rem">
                ${KL_SOURCES.map(s => `<span class="badge badge--info">${s.label}</span>`).join('')}
            </div>
        </div>`;
    }

    // Info banner for Pokja
    if (isPokja) {
        html += `<div class="dash-alert dash-alert--success">
            <h4 style="font-weight:600;font-size:0.875rem;margin-bottom:0.5rem">📋 Proses Input — Pokja (Perangkat Daerah)</h4>
            <p style="font-size:0.875rem">Menghimpun data sumber rujukan dari perangkat daerah.</p>
            <div style="margin-top:0.75rem;display:flex;flex-wrap:wrap;gap:0.5rem">
                ${POKJA_SOURCES.map(s => `<span class="badge badge--success">${s.label}</span>`).join('')}
            </div>
        </div>`;
    }

    // Stats cards
    const categories = {};
    entries.forEach(e => { categories[e.kategori] = (categories[e.kategori] || 0) + 1; });
    const uniqueCategories = Object.keys(categories).length;
    html += `
    <div class="dash-grid--4">
        <div class="stat-card"><p class="stat-card__label">Total Data</p><p class="stat-card__value">${entries.length}</p></div>
        <div class="stat-card"><p class="stat-card__label">Kategori Terisi</p><p class="stat-card__value" style="color:#2563eb">${uniqueCategories}</p></div>
        <div class="stat-card"><p class="stat-card__label">Pem. Pusat</p><p class="stat-card__value" style="color:#16a34a">${entries.filter(e => e.penyedia === 'Pemerintah Pusat').length}</p></div>
        <div class="stat-card"><p class="stat-card__label">Pem. Daerah</p><p class="stat-card__value" style="color:#9333ea">${entries.filter(e => e.penyedia === 'Pemerintah Daerah').length}</p></div>
    </div>`;

    // Filter bar
    html += `
    <div class="d-flex d-flex--wrap d-flex--gap-3">
        <div style="flex:1">
            <input type="text" id="search-input" oninput="renderTable()" class="form-input" placeholder="🔍 Cari instansi...">
        </div>
        <select id="filter-kategori" onchange="renderTable()" class="form-select" style="width:auto">
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
    <div class="dash-card">
        <div class="dash-table__wrapper">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Nama Instansi</th>
                        <th>Kategori</th>
                        <th>Penyedia</th>
                        <th>Call Center</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="sd-tbody"></tbody>
            </table>
        </div>
        <div id="sd-empty" style="display:none" class="dash-table__empty">Belum ada data sumber rujukan.</div>
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
        empty.style.display = '';
        return;
    }
    empty.style.display = 'none';

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
    group.querySelector('label').innerHTML = `${label} <span style="color:#ef4444">*</span>`;
    const sel = document.getElementById('entry-asal');
    sel.innerHTML = '<option value="">Pilih</option>' + sources.map(s => `<option value="${s.label}">${s.label} — ${s.items}</option>`).join('');
}

function openEntryModal(editIdx) {
    document.getElementById('entry-edit-idx').value = editIdx ?? -1;
    document.getElementById('entry-modal-title').textContent = editIdx >= 0 ? 'Edit Sumber Rujukan' : 'Tambah Sumber Rujukan';
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

    document.getElementById('entry-modal').style.display = '';
}

function closeEntryModal() { document.getElementById('entry-modal').style.display = 'none'; }

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
    document.getElementById('sd-detail-modal').style.display = '';
}

function closeDetailModal() { document.getElementById('sd-detail-modal').style.display = 'none'; }

function deleteEntry(idx) {
    if (!confirm('Hapus data sumber rujukan ini?')) return;
    const entries = getEntries();
    entries.splice(idx, 1);
    saveEntries(entries);
    renderPage();
}

$(document).ready(function() { renderPage(); });
</script>
<?= $this->endSection() ?>
