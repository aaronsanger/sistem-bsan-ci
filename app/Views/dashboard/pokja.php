<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6" id="pokja-app"></div>

<!-- Demo Info Modal -->
<div id="demo-info-modal" class="modal" style="display:none">
    <div class="modal__backdrop"></div>
    <div class="modal__container" style="max-width:32rem">
        <div class="modal__content">
            <div class="modal__header">
                <span style="font-size:1.5rem">⚠️</span>
                <h3 class="modal__title">Informasi Penting — Mode Demo Pokja</h3>
            </div>
            <div class="p-6 space-y-4">
                <p style="font-size:0.875rem;color:var(--dash-text-muted)">Mohon diperhatikan sebelum mengisi struktur Pokja:</p>
                <div class="dash-alert dash-alert--info">
                    <h4 style="font-weight:600;font-size:0.875rem;margin-bottom:0.25rem">📧 Email Ketua Pokja</h4>
                    <p style="font-size:0.875rem">Khusus Ketua Pokja diisi memakai <strong>email asli</strong> sebagai contoh simulasi pengiriman link verifikasi.</p>
                    <p style="font-size:0.875rem;margin-top:0.25rem">Password dapat dibuat sendiri setelah pemilik email klik link verifikasi dan proses verifikasi berhasil.</p>
                </div>
                <div class="dash-alert dash-alert--warning">
                    <h4 style="font-weight:600;font-size:0.875rem;margin-bottom:0.25rem">📧 Email selain Ketua Pokja</h4>
                    <p style="font-size:0.875rem">Selain Ketua Pokja <strong>jangan menggunakan</strong> alamat email asli.</p>
                    <p style="font-size:0.875rem;margin-top:0.25rem">Email selain Ketua akan langsung aktif dan bisa digunakan login Masuk Anggota Pokja.</p>
                    <p style="font-size:0.875rem;margin-top:0.25rem">Password masuk: <code style="background:var(--dash-bg-secondary);padding:0.125rem 0.5rem;border-radius:0.25rem;font-family:monospace;font-weight:700">pokja12345</code></p>
                </div>
            </div>
            <div style="padding:0 1.5rem 1.5rem">
                <button onclick="closeDemoInfo()" class="btn-dash btn-dash--primary" style="width:100%">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>

<!-- Submit Confirmation Modal -->
<div id="submit-confirm-modal" class="modal" style="display:none">
    <div class="modal__backdrop"></div>
    <div class="modal__container" style="max-width:28rem">
        <div class="modal__content" style="padding:2rem;text-align:center">
            <div style="width:4rem;height:4rem;border-radius:50%;background:var(--dash-bg-secondary);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
                <svg style="width:2rem;height:2rem;color:#d97706" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <h3 class="modal__title" style="margin-bottom:0.5rem">Ajukan Pokja ke Admin Pusat?</h3>
            <p style="font-size:0.875rem;color:var(--dash-text-muted);margin-bottom:1.5rem">Data akan dikunci dan tidak bisa diedit selama proses review.</p>
            <div style="display:flex;gap:0.75rem">
                <button onclick="closeSubmitConfirm()" class="btn-dash btn-dash--outline" style="flex:1">Cancel</button>
                <button onclick="submitToAdmin()" class="btn-dash btn-dash--primary" style="flex:1">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Excel Modal -->
<div id="import-excel-modal" class="modal" style="display:none">
    <div class="modal__backdrop" onclick="closeImportModal()"></div>
    <div class="modal__container" style="max-width:32rem">
        <div class="modal__content">
            <div class="modal__header">
                <h3 class="modal__title">Import Data dari Excel</h3>
                <button onclick="closeImportModal()" class="modal__close">
                    <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6">
                <div id="import-dropzone" style="border:2px dashed var(--dash-border);border-radius:0.75rem;padding:2rem;text-align:center;cursor:pointer;transition:all 0.2s"
                     onclick="document.getElementById('import-file-input').click()">
                    <svg style="width:3rem;height:3rem;margin:0 auto;color:var(--dash-text-muted);margin-bottom:0.75rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p style="font-size:0.875rem;font-weight:500">Drag & drop file Excel di sini</p>
                    <p style="font-size:0.75rem;color:var(--dash-text-muted);margin-top:0.25rem">atau klik untuk mencari file</p>
                    <p style="font-size:0.75rem;color:var(--dash-text-muted);margin-top:0.5rem">Format: .xlsx, .xls</p>
                </div>
                <div id="import-file-info" style="display:none;margin-top:0.75rem" class="dash-alert dash-alert--success d-flex d-flex--gap-2" >
                    <svg style="width:1.25rem;height:1.25rem;color:#16a34a;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="import-file-name" style="font-size:0.875rem;font-weight:500;overflow:hidden;text-overflow:ellipsis"></span>
                    <button onclick="clearImportFile()" style="margin-left:auto;flex-shrink:0;color:#16a34a"><svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <input type="file" id="import-file-input" accept=".xlsx,.xls" style="display:none" onchange="onImportFileSelected(this)">
            </div>
            <div style="padding:0 1.5rem 1.5rem;display:flex;gap:0.75rem">
                <button onclick="closeImportModal()" class="btn-dash btn-dash--outline" style="flex:1">Batal</button>
                <button id="btn-do-import" onclick="doImport()" disabled class="btn-dash btn-dash--primary" style="flex:1">Import Data</button>
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
    const w = getWilayahName();
    return { sub: subs.find(s => s.roleType === role && s.wilayah === w), idx: subs.findIndex(s => s.roleType === role && s.wilayah === w) };
}

// ---- Phone normalizer: any format → 628xxxxxxxxx ----
function normalizePhone(val) {
    let digits = val.replace(/[^0-9]/g, '');
    if (digits.startsWith('0')) digits = '62' + digits.substring(1);
    else if (!digits.startsWith('62') && digits.length > 0) digits = '62' + digits;
    return digits;
}

// ---- Phone digit validator: 10-13 digits ----
function isValidPhoneLength(phone) {
    const digits = phone.replace(/[^0-9]/g, '');
    return digits.length >= 10 && digits.length <= 13;
}

// ---- Email validator ----
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// ---- Live phone normalization via event delegation ----
document.addEventListener('DOMContentLoaded', function() {
    const app = document.getElementById('pokja-app');
    if (!app) return;
    app.addEventListener('blur', function(e) {
        const el = e.target;
        if (el.tagName !== 'INPUT' || el.type !== 'tel') return;
        const raw = el.value.trim();
        if (raw) el.value = normalizePhone(raw);
    }, true);
    // Also restrict to digits only on keypress
    app.addEventListener('input', function(e) {
        const el = e.target;
        if (el.tagName !== 'INPUT' || el.type !== 'tel') return;
        el.value = el.value.replace(/[^0-9\-+]/g, '');
    }, true);
});

// Instansi auto-fill mapping (non-editable)
const INSTANSI_MAP = {
    ketua: 'Sekretaris Daerah',
    wakil: 'Kepala Bappeda',
    koordinator: 'Kepala Dinas Pendidikan',
    'Bidang Pendidikan': 'Dinas Pendidikan',
    'Bidang PPPA': 'Dinas PPPA',
    'Bidang Sosial': 'Dinas Sosial',
    'Bidang Kesehatan': 'Dinas Kesehatan',
    'Bidang Dukbangga': 'Dinas Dukbangga',
    'Bidang Kominfo': 'Dinas Kominfo',
};

const JABATAN_MAP = {
    ketua: 'Ketua Pokja',
    wakil: 'Wakil Ketua',
    koordinator: 'Koordinator',
};

// Dynamic wilayah from localStorage
function getWilayahName() {
    if (role === 'dinas_prov') {
        const prov = localStorage.getItem('bsan_wilayah_prov');
        return prov ? `Prov. ${prov}` : 'Provinsi';
    } else {
        const kab = localStorage.getItem('bsan_wilayah_kab');
        return kab || 'Kabupaten/Kota';
    }
}

// Bidang options for Tambah Anggota dropdown
const BIDANG_OPTIONS = [
    { value: 'Bidang Pendidikan', instansi: 'Dinas Pendidikan' },
    { value: 'Bidang PPPA', instansi: 'Dinas PPPA' },
    { value: 'Bidang Sosial', instansi: 'Dinas Sosial' },
    { value: 'Bidang Kesehatan', instansi: 'Dinas Kesehatan' },
    { value: 'Bidang Dukbangga', instansi: 'Dinas Dukbangga' },
    { value: 'Bidang Kominfo', instansi: 'Dinas Kominfo' },
];

const defaultAnggota = BIDANG_OPTIONS.map(b => ({
    bidang: b.value, nama: '', email: '', jenisKelamin: '', noWa: '', nomorInstansi: '', nomorPribadi: ''
}));

const GENDER_OPTIONS = '<option value="">Pilih</option><option value="L">Laki-laki</option><option value="P">Perempuan</option>';

function init() {
    if (role === 'kementerian') { location.href = '/dashboard'; return; }
    // Always show info modal for non-approved accounts
    const { sub } = getMySubmission();
    if (!sub || sub.status !== 'approved') {
        document.getElementById('demo-info-modal').style.display = '';
    }
    renderPokjaPage();
}

function closeDemoInfo() {
    document.getElementById('demo-info-modal').style.display = 'none';
}

function renderPokjaPage() {
    const { sub } = getMySubmission();
    const app = document.getElementById('pokja-app');
    const wilayah = getWilayahName();

    if (!sub) renderCreationForm(app, wilayah);
    else if (sub.status === 'draft') renderDraftView(app, sub, wilayah);
    else if (sub.status === 'pending') renderPendingView(app, sub, wilayah);
    else if (sub.status === 'approved') renderApprovedView(app, sub, wilayah);
    else if (sub.status === 'declined') renderDeclinedView(app, sub, wilayah);
}

function renderCreationForm(app, wilayah) {
    app.innerHTML = buildFormHTML(wilayah, null);
}

// ---- Build Leader Row (7 fields: Nama*, Jabatan*locked, Email*, JK*, WA*, No Instansi*, No Pribadi optional) ----
function buildLeaderRow(key, label, sublabel, colorClass, data) {
    const d = data || {};
    const instansi = INSTANSI_MAP[key] || '';
    const jabatan = JABATAN_MAP[key] || '';
    const genderSel = (val) => GENDER_OPTIONS.replace(`value="${val}"`, `value="${val}" selected`);
    const initials = d.nama ? d.nama.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase() : label[0];

    return `<div class="dash-card" style="border-left:4px solid ${key === 'ketua' ? '#ef4444' : key === 'wakil' ? '#3b82f6' : '#8b5cf6'};margin-bottom:1rem;overflow:hidden" data-leader="${key}">
        <div style="padding:0.75rem 1rem;background:var(--dash-bg-secondary);border-bottom:1px solid var(--dash-border);display:flex;align-items:center;gap:0.75rem">
            <div style="width:2rem;height:2rem;border-radius:50%;background:${key === 'ketua' ? 'rgba(239,68,68,0.15)' : key === 'wakil' ? 'rgba(59,130,246,0.15)' : 'rgba(139,92,246,0.15)'};color:${key === 'ketua' ? '#dc2626' : key === 'wakil' ? '#2563eb' : '#7c3aed'};display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700">${initials}</div>
            <div>
                <span style="font-weight:600;font-size:0.875rem">${label}</span>
                <span style="font-size:0.75rem;color:var(--dash-text-muted);margin-left:0.5rem">${sublabel}</span>
            </div>
        </div>
        <div style="padding:1rem">
            <div class="dash-grid dash-grid--4">
                <div>
                    <label class="form-dash__label">Nama <span style="color:#ef4444">*</span></label>
                    <input type="text" class="leader-nama form-dash__input" value="${d.nama || ''}" placeholder="Nama lengkap" required>
                </div>
                <div>
                    <label class="form-dash__label">Jabatan <span style="color:#ef4444">*</span></label>
                    <input type="text" class="leader-jabatan form-dash__input" style="background:var(--dash-bg-secondary);color:var(--dash-text-muted);cursor:not-allowed" value="${jabatan}" readonly>
                </div>
                <div>
                    <label class="form-dash__label">Email <span style="color:#ef4444">*</span></label>
                    <input type="email" class="leader-email form-dash__input" value="${d.email || ''}" placeholder="Email" required>
                </div>
                <div>
                    <label class="form-dash__label">Jenis Kelamin <span style="color:#ef4444">*</span></label>
                    <select class="leader-gender form-dash__input" required>${genderSel(d.jenisKelamin || '')}</select>
                </div>
                <div>
                    <label class="form-dash__label">No. WhatsApp <span style="color:#ef4444">*</span></label>
                    <input type="tel" class="leader-wa form-dash__input" value="${d.noWa || ''}" placeholder="628xxxxxxxxx" required>
                </div>
                <div>
                    <label class="form-dash__label">No. Instansi <span style="color:#ef4444">*</span></label>
                    <input type="tel" class="leader-instansi-no form-dash__input" value="${d.nomorInstansi || ''}" placeholder="No. telepon instansi" required>
                </div>
                <div>
                    <label class="form-dash__label">No. Pribadi <span style="color:var(--dash-text-muted)">(opsional)</span></label>
                    <input type="tel" class="leader-pribadi form-dash__input" value="${d.nomorPribadi || ''}" placeholder="No. HP pribadi">
                </div>
            </div>
        </div>
    </div>`;
}

// ---- Build Anggota Row (default 6 bidang rows, locked bidang) ----
function buildAnggotaRow(a, i, isExtra) {
    const instansi = INSTANSI_MAP[a.bidang] || 'Dinas terkait';
    const genderSel = GENDER_OPTIONS.replace(`value="${a.jenisKelamin || ''}"`, `value="${a.jenisKelamin || ''}" selected`);
    const badge = getRoleBadge(a.bidang);
    const initials = a.nama ? a.nama.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase() : (i + 1).toString();

    let headerHtml;
    if (isExtra) {
        const opts = BIDANG_OPTIONS.map(b =>
            `<option value="${b.value}" ${a.bidang === b.value ? 'selected' : ''}>${b.value}</option>`
        ).join('');
        headerHtml = `<div style="padding:0.75rem 1rem;background:var(--dash-bg-secondary);border-bottom:1px solid var(--dash-border);display:flex;align-items:center;gap:0.75rem">
            <div style="width:2rem;height:2rem;border-radius:50%;background:var(--dash-bg-secondary);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:var(--dash-text-muted)">${initials}</div>
            <select class="anggota-bidang-select form-dash__input" style="width:auto;padding:0.25rem 0.5rem;font-size:0.75rem;font-weight:600" onchange="updateAnggotaInstansi(this)">${opts}</select>
            <span class="anggota-instansi-label" style="font-size:0.75rem;color:var(--dash-text-muted)">${instansi}</span>
            <button onclick="removeAnggota(this)" style="margin-left:auto;color:#ef4444;font-size:0.75rem;font-weight:500;padding:0.25rem 0.5rem;border-radius:0.25rem">Hapus</button>
        </div>`;
    } else {
        headerHtml = `<div style="padding:0.75rem 1rem;background:var(--dash-bg-secondary);border-bottom:1px solid var(--dash-border);display:flex;align-items:center;gap:0.75rem">
            <div style="width:2rem;height:2rem;border-radius:50%;background:var(--dash-bg-secondary);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:var(--dash-text-muted)">${initials}</div>
            <span class="anggota-bidang-label" style="font-weight:600;font-size:0.875rem">${a.bidang}</span>
            <span class="anggota-instansi-label" style="font-size:0.75rem;color:var(--dash-text-muted)">${instansi}</span>
        </div>`;
    }

    return `<div class="dash-card anggota-row" style="overflow:hidden" data-index="${i}" data-bidang="${a.bidang}" data-extra="${isExtra ? '1' : '0'}">
        ${headerHtml}
        <div style="padding:1rem">
            <div class="dash-grid dash-grid--4">
                <div>
                    <label class="form-dash__label">Nama <span style="color:#ef4444">*</span></label>
                    <input type="text" value="${a.nama || ''}" class="anggota-nama form-dash__input" placeholder="Nama" required>
                </div>
                <div>
                    <label class="form-dash__label">Jabatan <span style="color:#ef4444">*</span></label>
                    <input type="text" value="Anggota" class="anggota-jabatan form-dash__input" style="background:var(--dash-bg-secondary);color:var(--dash-text-muted);cursor:not-allowed" readonly>
                </div>
                <div>
                    <label class="form-dash__label">Email <span style="color:#ef4444">*</span></label>
                    <input type="email" value="${a.email || ''}" class="anggota-email form-dash__input" placeholder="Email" required>
                </div>
                <div>
                    <label class="form-dash__label">Jenis Kelamin <span style="color:#ef4444">*</span></label>
                    <select class="anggota-gender form-dash__input" required>${genderSel}</select>
                </div>
                <div>
                    <label class="form-dash__label">No. WhatsApp <span style="color:#ef4444">*</span></label>
                    <input type="tel" value="${a.noWa || ''}" class="anggota-wa form-dash__input" placeholder="628xxxxxxxxx" required>
                </div>
                <div>
                    <label class="form-dash__label">No. Instansi <span style="color:#ef4444">*</span></label>
                    <input type="tel" value="${a.nomorInstansi || ''}" class="anggota-instansi-no form-dash__input" placeholder="No. telepon instansi" required>
                </div>
                <div>
                    <label class="form-dash__label">No. Pribadi <span style="color:var(--dash-text-muted)">(opsional)</span></label>
                    <input type="tel" value="${a.nomorPribadi || ''}" class="anggota-pribadi form-dash__input" placeholder="No. HP pribadi">
                </div>
            </div>
        </div>
    </div>`;
}

function updateAnggotaInstansi(selectEl) {
    const row = selectEl.closest('.anggota-row');
    const bidang = selectEl.value;
    const instansi = INSTANSI_MAP[bidang] || 'Dinas terkait';
    row.dataset.bidang = bidang;
    row.querySelector('.anggota-instansi-label').textContent = '📌 ' + instansi;
}

function addAnggota() {
    const container = document.getElementById('anggota-container');
    const rows = container.querySelectorAll('.anggota-row');
    const newIdx = rows.length;
    const newAnggota = { bidang: 'Bidang Pendidikan', nama: '', email: '', jenisKelamin: '', noWa: '', nomorInstansi: '', nomorPribadi: '' };
    container.insertAdjacentHTML('beforeend', buildAnggotaRow(newAnggota, newIdx, true));
}

function removeAnggota(btn) {
    const row = btn.closest('.anggota-row');
    row.remove();
    document.querySelectorAll('.anggota-row').forEach((r, i) => r.dataset.index = i);
}

function buildFormHTML(wilayah, existing) {
    const s = existing?.struktur || {};
    const sk = existing || {};
    const anggotaList = s.anggota && s.anggota.length ? s.anggota : defaultAnggota;
    const activeTab = existing?.nomorSK ? 'sk' : 'struktur';

    return `
    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1rem">
        <div>
            <h2 class="dash-section__title">Bentuk Pokja</h2>
            <p style="font-size:0.875rem;color:var(--dash-text-muted);margin-top:0.25rem">Lengkapi data Pokja ${wilayah}</p>
        </div>
    </div>

    ${sk.nomorSK ? '' : `
    <div class="dash-alert dash-alert--info" style="display:flex;align-items:flex-start;gap:0.75rem" id="sk-reminder">
        <span style="font-size:1.25rem">📄</span>
        <div style="flex:1">
            <p style="font-weight:600">Dokumen SK</p>
            <p style="font-size:0.875rem">Lengkapi dan unggah file SK agar Pokja dapat diajukan ke Admin Pusat.</p>
        </div>
        <button onclick="switchTab('sk')" class="btn-dash btn-dash--primary" style="white-space:nowrap;font-size:0.875rem">Lengkapi Data SK</button>
    </div>
    `}

    <div style="display:flex;gap:0.25rem;background:var(--dash-bg-secondary);padding:0.25rem;border-radius:0.5rem">
        <button onclick="switchTab('struktur')" id="tab-btn-struktur" style="flex:1;padding:0.5rem 1rem;border-radius:0.375rem;font-size:0.875rem;font-weight:500;background:${activeTab === 'struktur' ? 'var(--dash-card-bg)' : 'transparent'};color:${activeTab === 'struktur' ? 'var(--dash-text)' : 'var(--dash-text-muted)'};box-shadow:${activeTab === 'struktur' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none'};border:none;cursor:pointer">1. Struktur Pokja</button>
        <button onclick="switchTab('sk')" id="tab-btn-sk" style="flex:1;padding:0.5rem 1rem;border-radius:0.375rem;font-size:0.875rem;font-weight:500;background:${activeTab === 'sk' ? 'var(--dash-card-bg)' : 'transparent'};color:${activeTab === 'sk' ? 'var(--dash-text)' : 'var(--dash-text-muted)'};box-shadow:${activeTab === 'sk' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none'};border:none;cursor:pointer">2. Data SK</button>
    </div>

    <!-- Tab 1: Struktur Pokja -->
    <div id="tab-struktur" style="${activeTab === 'struktur' ? '' : 'display:none'}">
        <div class="dash-card" style="padding:1.5rem">
            <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.75rem">
                <div>
                    <h3 style="font-size:1.125rem;font-weight:600;display:flex;align-items:center;gap:0.5rem"><svg style="width:1.25rem;height:1.25rem;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Struktur & Anggota Pokja ${wilayah}</h3>
                    <p style="font-size:0.875rem;color:var(--dash-text-muted);margin-top:0.25rem">Lengkapi struktur Pokja sebelum mengunggah SK</p>
                </div>
                <div style="display:flex;gap:0.5rem">
                    <button onclick="exportDummyData()" class="btn-dash btn-dash--outline" style="font-size:0.875rem;color:#c2410c;border-color:#fdba74" title="Download data contoh">
                        <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Data Contoh
                    </button>
                    <button onclick="exportExcelTemplate()" class="btn-dash btn-dash--outline" style="font-size:0.875rem;color:#15803d;border-color:#86efac" title="Download template Excel">
                        <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export Template
                    </button>
                    <button onclick="openImportModal()" class="btn-dash btn-dash--outline" style="font-size:0.875rem" title="Import data dari Excel">
                        <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Import Excel
                    </button>
                </div>
            </div>

            <!-- Identitas Pokja -->
            <div style="margin-top:1.5rem">
                <h4 style="font-size:0.875rem;font-weight:600;margin-bottom:0.75rem;display:flex;align-items:center;gap:0.5rem"><svg style="width:1rem;height:1rem;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Identitas Pokja</h4>
                <div class="dash-grid dash-grid--2">
                    <div>
                        <label class="form-dash__label">Nama Pokja <span style="color:#ef4444">*</span></label>
                        <input type="text" id="nama-pokja" value="${sk.namaPokja || ''}" class="form-dash__input" placeholder="Contoh: Pokja BSAN ${wilayah}">
                    </div>
                    <div>
                        <label class="form-dash__label">No. Call Center Pokja <span style="color:#ef4444">*</span></label>
                        <input type="tel" id="call-center-pokja" value="${sk.callCenterPokja || ''}" class="form-dash__input" placeholder="Nomor call center Pokja" required>
                    </div>
                </div>
            </div>

            <hr style="border-color:var(--dash-border)">

            <div>
                <h4 style="font-size:0.875rem;font-weight:600;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem"><svg style="width:1rem;height:1rem;color:#ef4444" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>Pimpinan Pokja</h4>
                ${buildLeaderRow('ketua', 'Ketua Pokja', 'Sekretaris Daerah', '', s.ketua)}
                ${buildLeaderRow('wakil', 'Wakil Ketua', 'Kepala Bappeda', '', s.wakil)}
                ${buildLeaderRow('koordinator', 'Koordinator', 'Kepala Dinas Pendidikan', '', s.koordinator)}
            </div>

            <hr style="border-color:var(--dash-border)">

            <div>
                <h4 style="font-size:0.875rem;font-weight:600;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem"><svg style="width:1rem;height:1rem;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>Anggota Pokja</h4>
                <div id="anggota-container" style="display:flex;flex-direction:column;gap:0.75rem">
                    ${anggotaList.map((a, i) => {
                        const isExtra = a.isExtra || false;
                        return buildAnggotaRow(a, i, isExtra);
                    }).join('')}
                </div>
                <button onclick="addAnggota()" style="margin-top:0.75rem;display:inline-flex;align-items:center;gap:0.5rem;color:#2563eb;font-size:0.875rem;font-weight:500;background:none;border:none;cursor:pointer">
                    <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Anggota
                </button>
            </div>

            <div style="display:flex;justify-content:flex-end;padding-top:1rem;border-top:1px solid var(--dash-border)">
                <button onclick="saveStruktur()" class="btn-dash btn-dash--primary">Simpan Struktur Pokja</button>
            </div>
        </div>
    </div>

    <!-- Tab 2: Data SK -->
    <div id="tab-sk" style="${activeTab === 'sk' ? '' : 'display:none'}">
        <div class="dash-card" style="padding:1.5rem">
            <div>
                <h3 style="font-size:1.125rem;font-weight:600">Data SK Pokja ${wilayah}</h3>
                <p style="font-size:0.875rem;color:var(--dash-text-muted);margin-top:0.25rem">Lengkapi data SK sebelum mengajukan ke Admin Pusat</p>
            </div>
            <div class="dash-grid dash-grid--2" style="margin-top:1.25rem">
                <div>
                    <label class="form-dash__label">Nomor SK <span style="color:#ef4444">*</span></label>
                    <input type="text" id="nomor-sk" value="${sk.nomorSK || ''}" class="form-dash__input" placeholder="Nomor SK">
                </div>
                <div>
                    <label class="form-dash__label">Tanggal SK <span style="color:#ef4444">*</span></label>
                    <input type="date" id="tanggal-sk" value="${sk.tanggalSK || ''}" class="form-dash__input">
                </div>
                <div>
                    <label class="form-dash__label">Periode Mulai <span style="color:#ef4444">*</span></label>
                    <input type="date" id="periode-mulai" value="${sk.periodeMulai || ''}" onchange="autoSetPeriodeSelesai()" class="form-dash__input">
                </div>
                <div>
                    <label class="form-dash__label">Periode Selesai <span style="color:#ef4444">*</span></label>
                    <input type="date" id="periode-selesai" value="${sk.periodeSelesai || ''}" class="form-dash__input">
                </div>
            </div>
            <div style="margin-top:1.25rem">
                <label class="form-dash__label">Dokumen SK</label>
                <input type="file" id="sk-file" accept=".pdf" class="form-dash__input" style="padding:0">
                <p style="font-size:0.75rem;color:var(--dash-text-muted);margin-top:0.25rem">Maksimal 2MB, format PDF</p>
                ${sk.skFileName ? `<p style="font-size:0.875rem;color:#16a34a;margin-top:0.25rem">📄 ${sk.skFileName}</p>` : ''}
            </div>
            <div style="display:flex;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--dash-border);margin-top:1.25rem">
                <button onclick="switchTab('struktur')" class="btn-dash btn-dash--outline" style="flex:1">Batal</button>
                <button onclick="saveSK()" class="btn-dash btn-dash--primary" style="flex:1">Simpan Data SK</button>
            </div>
        </div>
    </div>`;
}

function switchTab(tab) {
    document.getElementById('tab-struktur').style.display = tab === 'struktur' ? '' : 'none';
    document.getElementById('tab-sk').style.display = tab === 'sk' ? '' : 'none';
    ['struktur', 'sk'].forEach(t => {
        const btn = document.getElementById('tab-btn-' + t);
        const active = t === tab;
        btn.style.background = active ? 'var(--dash-card-bg)' : 'transparent';
        btn.style.color = active ? 'var(--dash-text)' : 'var(--dash-text-muted)';
        btn.style.boxShadow = active ? '0 1px 2px rgba(0,0,0,0.05)' : 'none';
    });
}

function autoSetPeriodeSelesai() {
    const mulai = document.getElementById('periode-mulai').value;
    if (mulai) {
        const d = new Date(mulai); d.setFullYear(d.getFullYear() + 4);
        document.getElementById('periode-selesai').value = d.toISOString().split('T')[0];
    }
}

function gatherLeader(key) {
    const el = document.querySelector(`[data-leader="${key}"]`);
    if (!el) return {};
    return {
        nama: el.querySelector('.leader-nama')?.value || '',
        jabatan: el.querySelector('.leader-jabatan')?.value || '',
        instansi: INSTANSI_MAP[key] || '',
        email: el.querySelector('.leader-email')?.value || '',
        jenisKelamin: el.querySelector('.leader-gender')?.value || '',
        noWa: el.querySelector('.leader-wa')?.value || '',
        nomorInstansi: el.querySelector('.leader-instansi-no')?.value || '',
        nomorPribadi: el.querySelector('.leader-pribadi')?.value || '',
    };
}

function gatherStruktur() {
    return {
        ketua: gatherLeader('ketua'),
        wakil: gatherLeader('wakil'),
        koordinator: gatherLeader('koordinator'),
        anggota: Array.from(document.querySelectorAll('.anggota-row')).map((row) => {
            const isExtra = row.dataset.extra === '1';
            const bidang = isExtra
                ? (row.querySelector('.anggota-bidang-select')?.value || 'Bidang Pendidikan')
                : (row.dataset.bidang || 'Anggota');
            return {
                bidang,
                isExtra,
                nama: row.querySelector('.anggota-nama')?.value || '',
                jabatan: 'Anggota',
                instansi: INSTANSI_MAP[bidang] || 'Dinas terkait',
                email: row.querySelector('.anggota-email')?.value || '',
                jenisKelamin: row.querySelector('.anggota-gender')?.value || '',
                noWa: row.querySelector('.anggota-wa')?.value || '',
                nomorInstansi: row.querySelector('.anggota-instansi-no')?.value || '',
                nomorPribadi: row.querySelector('.anggota-pribadi')?.value || '',
            };
        })
    };
}

function validateRequired(struktur) {
    // Validate leaders
    for (const key of ['ketua', 'wakil', 'koordinator']) {
        const m = struktur[key];
        const label = JABATAN_MAP[key];
        if (!m.nama) return `Nama ${label} wajib diisi.`;
        if (!m.email) return `Email ${label} wajib diisi.`;
        if (m.email && !isValidEmail(m.email)) return `Email ${label} tidak valid.`;
        if (!m.jenisKelamin) return `Jenis Kelamin ${label} wajib diisi.`;
        if (!m.noWa) return `No. WhatsApp ${label} wajib diisi.`;
        if (m.noWa && !isValidPhoneLength(m.noWa)) return `No. WhatsApp ${label} harus 10-13 digit.`;
        if (!m.nomorInstansi) return `No. Instansi ${label} wajib diisi.`;
        if (m.nomorInstansi && !isValidPhoneLength(m.nomorInstansi)) return `No. Instansi ${label} harus 10-13 digit.`;
        if (m.nomorPribadi && !isValidPhoneLength(m.nomorPribadi)) return `No. Pribadi ${label} harus 10-13 digit.`;
    }
    // Validate anggota
    for (let i = 0; i < struktur.anggota.length; i++) {
        const a = struktur.anggota[i];
        const label = a.bidang;
        if (!a.nama) return `Nama ${label} wajib diisi.`;
        if (!a.email) return `Email ${label} wajib diisi.`;
        if (a.email && !isValidEmail(a.email)) return `Email ${label} tidak valid.`;
        if (!a.jenisKelamin) return `Jenis Kelamin ${label} wajib diisi.`;
        if (!a.noWa) return `No. WhatsApp ${label} wajib diisi.`;
        if (a.noWa && !isValidPhoneLength(a.noWa)) return `No. WhatsApp ${label} harus 10-13 digit.`;
        if (!a.nomorInstansi) return `No. Instansi ${label} wajib diisi.`;
        if (a.nomorInstansi && !isValidPhoneLength(a.nomorInstansi)) return `No. Instansi ${label} harus 10-13 digit.`;
        if (a.nomorPribadi && !isValidPhoneLength(a.nomorPribadi)) return `No. Pribadi ${label} harus 10-13 digit.`;
    }
    return null;
}

function saveStruktur() {
    const namaPokja = document.getElementById('nama-pokja').value.trim();
    if (!namaPokja) { alert('Masukkan Nama Pokja.'); return; }

    const struktur = gatherStruktur();
    const err = validateRequired(struktur);
    if (err) { alert(err); return; }

    const callCenterPokja = document.getElementById('call-center-pokja').value.trim();
    if (!callCenterPokja) { alert('No. Call Center Pokja wajib diisi.'); return; }
    if (!isValidPhoneLength(callCenterPokja)) { alert('No. Call Center Pokja harus 10-13 digit.'); return; }

    const subs = getSubmissions();
    const { idx } = getMySubmission();
    const wilayah = getWilayahName();

    const submission = idx >= 0 ? { ...subs[idx] } : { roleType: role, wilayah, status: 'draft', createdAt: new Date().toISOString() };
    submission.namaPokja = namaPokja;
    submission.callCenterPokja = callCenterPokja;
    submission.struktur = struktur;
    submission.updatedAt = new Date().toISOString();

    if (idx >= 0) subs[idx] = submission; else subs.push(submission);
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
    if (!nomorSK || !tanggalSK || !periodeMulai || !periodeSelesai) { alert('Lengkapi semua field SK.'); return; }

    const subs = getSubmissions();
    const { idx } = getMySubmission();
    if (idx < 0) { alert('Simpan Struktur Pokja terlebih dahulu.'); return; }

    subs[idx].nomorSK = nomorSK; subs[idx].tanggalSK = tanggalSK;
    subs[idx].periodeMulai = periodeMulai; subs[idx].periodeSelesai = periodeSelesai;
    subs[idx].skFileName = skFile ? skFile.name : subs[idx].skFileName || '';
    subs[idx].updatedAt = new Date().toISOString();
    saveSubmissions(subs);
    alert('Data SK berhasil disimpan!');
    renderPokjaPage();
}

// ---- View Renderers ----
function getRoleBadge(label) {
    if (label.includes('Ketua') && !label.includes('Wakil')) return { bg: 'rgba(239,68,68,0.15)', color: '#dc2626', border: '#fecaca' };
    if (label.includes('Wakil')) return { bg: 'rgba(59,130,246,0.15)', color: '#2563eb', border: '#bfdbfe' };
    if (label.includes('Koordinator')) return { bg: 'rgba(139,92,246,0.15)', color: '#7c3aed', border: '#c4b5fd' };
    return { bg: 'var(--dash-bg-secondary)', color: 'var(--dash-text-muted)', border: 'var(--dash-border)' };
}

function renderMemberCard(label, m, index) {
    if (!m || !m.nama) return '';
    const gLabel = m.jenisKelamin === 'L' ? 'Laki-laki' : m.jenisKelamin === 'P' ? 'Perempuan' : '-';
    const badge = getRoleBadge(label);
    const initials = m.nama.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
    const isLeader = label.includes('Ketua') || label.includes('Wakil') || label.includes('Koordinator');
    return `<div class="dash-card" style="padding:1rem;${isLeader ? 'border-left:4px solid ' + badge.color : ''}">
        <div style="display:flex;align-items:flex-start;gap:0.75rem">
            <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:${badge.bg};color:${badge.color};display:flex;align-items:center;justify-content:center;font-size:0.875rem;font-weight:700;flex-shrink:0">${initials}</div>
            <div style="flex:1;min-width:0">
                <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap">
                    <span style="font-weight:600;font-size:0.875rem">${m.nama}</span>
                    <span style="display:inline-flex;align-items:center;padding:0.125rem 0.5rem;border-radius:9999px;font-size:0.75rem;font-weight:500;border:1px solid ${badge.border};background:${badge.bg};color:${badge.color}">${m.jabatan || label}</span>
                </div>
                <p style="font-size:0.75rem;color:var(--dash-text-muted);margin-top:0.125rem">${m.instansi || INSTANSI_MAP[label] || '-'}</p>
                <div class="dash-grid dash-grid--2" style="margin-top:0.5rem;gap:0.25rem 1rem">
                    <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--dash-text-muted)"><svg style="width:0.875rem;height:0.875rem;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg><span style="overflow:hidden;text-overflow:ellipsis">${m.email || '-'}</span></div>
                    <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--dash-text-muted)"><svg style="width:0.875rem;height:0.875rem;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>${gLabel}</div>
                    <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--dash-text-muted)"><svg style="width:0.875rem;height:0.875rem;color:#22c55e;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>WA: ${m.noWa || '-'}</div>
                    <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--dash-text-muted)"><svg style="width:0.875rem;height:0.875rem;color:#3b82f6;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>Kantor: ${m.nomorInstansi || '-'}</div>
                </div>
            </div>
        </div>
    </div>`;
}

function formatDate(dateStr) {
    if (!dateStr) return '-';
    const d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
}

function renderReadonlySummary(sub) {
    const s = sub.struktur || {};
    let leadersHtml = '';
    let anggotaHtml = '';
    if (s.ketua) leadersHtml += renderMemberCard('Ketua Pokja', { ...s.ketua, jabatan: 'Ketua Pokja', instansi: 'Sekretaris Daerah' });
    if (s.wakil) leadersHtml += renderMemberCard('Wakil Ketua', { ...s.wakil, jabatan: 'Wakil Ketua', instansi: 'Kepala Bappeda' });
    if (s.koordinator) leadersHtml += renderMemberCard('Koordinator', { ...s.koordinator, jabatan: 'Koordinator', instansi: 'Kepala Dinas Pendidikan' });
    if (s.anggota) s.anggota.forEach((a, i) => { anggotaHtml += renderMemberCard(a.bidang, a, i); });
    const totalMembers = (s.ketua ? 1 : 0) + (s.wakil ? 1 : 0) + (s.koordinator ? 1 : 0) + (s.anggota ? s.anggota.length : 0);

    return `
    <div class="dash-grid dash-grid--4">
        <div class="dash-card" style="padding:1.25rem;border-left:4px solid #3b82f6">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem">
                <div style="width:2.25rem;height:2.25rem;border-radius:0.5rem;background:rgba(59,130,246,0.15);display:flex;align-items:center;justify-content:center"><svg style="width:1.25rem;height:1.25rem;color:#2563eb" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
                <p style="font-size:0.75rem;font-weight:500;color:#2563eb;text-transform:uppercase;letter-spacing:0.05em">Nama Pokja</p>
            </div>
            <p style="font-weight:700;font-size:1rem;line-height:1.25">${sub.namaPokja || '-'}</p>
        </div>
        <div class="dash-card" style="padding:1.25rem;border-left:4px solid #7c3aed">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem">
                <div style="width:2.25rem;height:2.25rem;border-radius:0.5rem;background:rgba(139,92,246,0.15);display:flex;align-items:center;justify-content:center"><svg style="width:1.25rem;height:1.25rem;color:#7c3aed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                <p style="font-size:0.75rem;font-weight:500;color:#7c3aed;text-transform:uppercase;letter-spacing:0.05em">Nomor SK</p>
            </div>
            <p style="font-weight:700;font-size:1rem;font-family:monospace">${sub.nomorSK || '-'}</p>
        </div>
        <div class="dash-card" style="padding:1.25rem;border-left:4px solid #d97706">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem">
                <div style="width:2.25rem;height:2.25rem;border-radius:0.5rem;background:rgba(217,119,6,0.15);display:flex;align-items:center;justify-content:center"><svg style="width:1.25rem;height:1.25rem;color:#d97706" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                <p style="font-size:0.75rem;font-weight:500;color:#d97706;text-transform:uppercase;letter-spacing:0.05em">Masa Berlaku SK</p>
            </div>
            <p style="font-weight:700;font-size:0.875rem">${sub.periodeMulai ? formatDate(sub.periodeMulai) : '-'}</p>
            ${sub.periodeSelesai ? `<p style="font-size:0.75rem;color:var(--dash-text-muted);margin-top:0.125rem">s/d ${formatDate(sub.periodeSelesai)}</p>` : ''}
        </div>
        <div class="dash-card" style="padding:1.25rem;border-left:4px solid #16a34a">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem">
                <div style="width:2.25rem;height:2.25rem;border-radius:0.5rem;background:rgba(22,163,74,0.15);display:flex;align-items:center;justify-content:center"><svg style="width:1.25rem;height:1.25rem;color:#16a34a" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                <p style="font-size:0.75rem;font-weight:500;color:#16a34a;text-transform:uppercase;letter-spacing:0.05em">Call Center</p>
            </div>
            <p style="font-weight:700;font-size:1rem;font-family:monospace">${sub.callCenterPokja || '-'}</p>
        </div>
    </div>
    <div class="dash-card" style="overflow:hidden">
        <div style="padding:1rem 1.5rem;border-bottom:1px solid var(--dash-border)">
            <h3 style="font-size:1.125rem;font-weight:600">Struktur & Anggota Pokja</h3>
            <p style="font-size:0.875rem;color:var(--dash-text-muted);margin-top:0.125rem">${totalMembers} anggota terdaftar</p>
        </div>
        <div style="padding:1.5rem;display:flex;flex-direction:column;gap:1rem">
            ${leadersHtml ? `<div>
                <h4 style="font-size:0.75rem;font-weight:600;color:var(--dash-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.75rem">Pimpinan Pokja</h4>
                <div class="dash-grid dash-grid--3">${leadersHtml}</div>
            </div>` : ''}
            ${anggotaHtml ? `<div style="padding-top:0.5rem">
                <h4 style="font-size:0.75rem;font-weight:600;color:var(--dash-text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.75rem">Anggota Pokja</h4>
                <div class="dash-grid dash-grid--2">${anggotaHtml}</div>
            </div>` : ''}
            ${!leadersHtml && !anggotaHtml ? '<p style="color:var(--dash-text-muted);text-align:center;padding:2rem 0">Tidak ada data struktur.</p>' : ''}
        </div>
    </div>`;
}

function renderDraftView(app, sub, wilayah) {
    const hasSK = sub.nomorSK;
    const canSubmit = sub.struktur?.ketua && hasSK;
    app.innerHTML = `
    <div><h2 class="dash-section__title">Data Pokja ${wilayah}</h2><p style="font-size:0.875rem;color:var(--dash-text-muted);margin-top:0.25rem">Review dan ajukan Pokja ke Admin Pusat</p></div>
    ${!hasSK ? `<div class="dash-alert dash-alert--info" style="display:flex;align-items:flex-start;gap:0.75rem"><span style="font-size:1.25rem">📄</span><div style="flex:1"><p style="font-weight:600">Dokumen SK</p><p style="font-size:0.875rem">Lengkapi dan unggah file SK agar Pokja dapat diajukan ke Admin Pusat.</p></div><button onclick="editPokja('sk')" class="btn-dash btn-dash--primary" style="white-space:nowrap;font-size:0.875rem">Lengkapi Data SK</button></div>` : ''}
    <div style="display:flex;flex-wrap:wrap;align-items:center;gap:0.75rem">
        <button onclick="editPokja('struktur')" class="btn-dash btn-dash--outline" style="font-size:0.875rem">
            <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Struktur
        </button>
        <button onclick="editPokja('sk')" class="btn-dash btn-dash--outline" style="font-size:0.875rem;color:#7c3aed;border-color:#c4b5fd">
            <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Update SK
        </button>
        ${canSubmit ? `<button onclick="confirmSubmit()" class="btn-dash btn-dash--success" style="margin-left:auto;font-size:0.875rem">
            <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Ajukan ke Admin Pusat
        </button>` : ''}
    </div>
    ${renderReadonlySummary(sub)}`;
}

function renderPendingView(app, sub, wilayah) {
    app.innerHTML = `
    <div><h2 class="dash-section__title">Data Pokja ${wilayah}</h2></div>
    <div class="dash-alert dash-alert--warning" style="padding:1.5rem;text-align:center">
        <div style="width:4rem;height:4rem;border-radius:50%;background:rgba(234,179,8,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem"><svg style="width:2rem;height:2rem;color:#ca8a04" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <h3 style="font-size:1.125rem;font-weight:700">⏳ Menunggu Approval</h3>
        <p style="font-size:0.875rem;margin-top:0.5rem">Pengajuan Pokja sedang diproses oleh Admin Pusat.</p>
    </div>
    ${renderReadonlySummary(sub)}`;
}

function renderApprovedView(app, sub, wilayah) {
    app.innerHTML = `
    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.75rem">
        <div><h2 class="dash-section__title">Data Pokja ${wilayah}</h2></div>
        <div style="display:flex;gap:0.5rem">
            <button onclick="editPokja('struktur')" class="btn-dash btn-dash--outline" style="font-size:0.875rem">
                <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Struktur
            </button>
            <button onclick="editPokja('sk')" class="btn-dash btn-dash--outline" style="font-size:0.875rem;color:#7c3aed;border-color:#c4b5fd">
                <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Update SK
            </button>
        </div>
    </div>
    <div class="dash-alert dash-alert--success" style="display:flex;align-items:center;gap:0.75rem">
        <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:rgba(22,163,74,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0"><svg style="width:1.5rem;height:1.5rem;color:#16a34a" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <div>
            <h3 style="font-weight:700">Pokja Disetujui</h3>
            <p style="font-size:0.875rem">Struktur Pokja telah diverifikasi. Anda tetap dapat memperbarui data Struktur atau SK jika ada perubahan anggota.</p>
        </div>
    </div>
    ${renderReadonlySummary(sub)}`;
}

function renderDeclinedView(app, sub, wilayah) {
    app.innerHTML = `
    <div><h2 class="dash-section__title">Data Pokja ${wilayah}</h2></div>
    <div class="dash-alert dash-alert--danger" style="display:flex;align-items:flex-start;gap:0.75rem">
        <svg style="width:1.25rem;height:1.25rem;color:#dc2626;margin-top:0.125rem;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div><p style="font-weight:600">Pengajuan Ditolak</p><p style="font-size:0.875rem;margin-top:0.25rem">${sub.declineReason || 'Tidak ada alasan.'}</p></div>
    </div>
    <div style="display:flex;flex-wrap:wrap;align-items:center;gap:0.75rem">
        <button onclick="resubmit('struktur')" class="btn-dash btn-dash--outline" style="font-size:0.875rem">
            <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Struktur
        </button>
        <button onclick="resubmit('sk')" class="btn-dash btn-dash--outline" style="font-size:0.875rem;color:#7c3aed;border-color:#c4b5fd">
            <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Update SK
        </button>
        <button onclick="resubmit('struktur')" class="btn-dash btn-dash--primary" style="margin-left:auto;font-size:0.875rem">
            <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Edit & Ajukan Ulang
        </button>
    </div>
    ${renderReadonlySummary(sub)}`;
}

function editPokja(tab) {
    const { sub } = getMySubmission();
    const wilayah = getWilayahName();
    document.getElementById('pokja-app').innerHTML = buildFormHTML(wilayah, sub);
    if (tab) switchTab(tab);
}

function confirmSubmit() { document.getElementById('submit-confirm-modal').style.display = ''; }
function closeSubmitConfirm() { document.getElementById('submit-confirm-modal').style.display = 'none'; }

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

function resubmit(tab) {
    const subs = getSubmissions();
    const { idx } = getMySubmission();
    if (idx < 0) return;
    subs[idx].status = 'draft'; subs[idx].declineReason = '';
    saveSubmissions(subs);
    editPokja(tab || 'struktur');
}

$(document).ready(function() { init(); });

// ---- SheetJS Dynamic Loader ----
function loadSheetJS() {
    return new Promise((resolve, reject) => {
        if (window.XLSX) { resolve(window.XLSX); return; }
        const s = document.createElement('script');
        s.src = 'https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js';
        s.onload = () => resolve(window.XLSX);
        s.onerror = () => reject(new Error('Gagal memuat library Excel'));
        document.head.appendChild(s);
    });
}

// ---- Export Dummy Data ----
async function exportDummyData() {
    try {
        const XLSX = await loadSheetJS();
        const wilayah = getWilayahName();
        const headers = ['Peran', 'Bidang', 'Jabatan', 'Instansi', 'Nama*', 'Email*', 'Jenis Kelamin* (L/P)', 'No. WhatsApp*', 'No. Instansi*', 'No. Pribadi'];
        const rows = [headers,
            ['Pimpinan', 'Ketua Pokja', 'Ketua Pokja', 'Sekretaris Daerah', 'Budi Santoso', 'ketua@demo.bsan.id', 'L', '6281234567890', '6221345678', '6285678901234'],
            ['Pimpinan', 'Wakil Ketua', 'Wakil Ketua', 'Kepala Bappeda', 'Siti Rahayu', 'wakil@demo.bsan.id', 'P', '6281345678901', '6221456789', ''],
            ['Pimpinan', 'Koordinator', 'Koordinator', 'Kepala Dinas Pendidikan', 'Ahmad Wijaya', 'koordinator@demo.bsan.id', 'L', '6281456789012', '6221567890', '6285789012345'],
            ['Anggota', 'Bidang Pendidikan', 'Anggota', 'Dinas Pendidikan', 'Dewi Lestari', 'pendidikan@demo.bsan.id', 'P', '6281567890123', '6221678901', ''],
            ['Anggota', 'Bidang PPPA', 'Anggota', 'Dinas PPPA', 'Rina Wulandari', 'pppa@demo.bsan.id', 'P', '6281678901234', '6221789012', '6285890123456'],
            ['Anggota', 'Bidang Sosial', 'Anggota', 'Dinas Sosial', 'Hendra Pratama', 'sosial@demo.bsan.id', 'L', '6281789012345', '6221890123', ''],
            ['Anggota', 'Bidang Kesehatan', 'Anggota', 'Dinas Kesehatan', 'Nurul Hidayah', 'kesehatan@demo.bsan.id', 'P', '6281890123456', '6221901234', '6285901234567'],
            ['Anggota', 'Bidang Dukbangga', 'Anggota', 'Dinas Dukbangga', 'Agus Setiawan', 'dukbangga@demo.bsan.id', 'L', '6281901234567', '6222012345', ''],
            ['Anggota', 'Bidang Kominfo', 'Anggota', 'Dinas Kominfo', 'Maya Putri', 'kominfo@demo.bsan.id', 'P', '6282012345678', '6222123456', '6286012345678'],
        ];
        const ws = XLSX.utils.aoa_to_sheet(rows);
        ws['!cols'] = [
            { wch: 12 }, { wch: 22 }, { wch: 18 }, { wch: 26 },
            { wch: 25 }, { wch: 30 }, { wch: 18 }, { wch: 18 }, { wch: 18 }, { wch: 18 },
        ];
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Struktur Pokja');
        XLSX.writeFile(wb, `Data_Contoh_Pokja_${wilayah.replace(/[^a-zA-Z0-9]/g, '_')}.xlsx`);
    } catch (err) {
        alert('Error: ' + err.message);
    }
}

// ---- Export Excel Template ----
async function exportExcelTemplate() {
    try {
        const XLSX = await loadSheetJS();
        const wilayah = getWilayahName();
        const { sub } = getMySubmission();
        const s = sub?.struktur || {};

        // Build rows: header + 3 leaders + 6 default anggota + extra anggota
        const headers = ['Peran', 'Bidang', 'Jabatan', 'Instansi', 'Nama*', 'Email*', 'Jenis Kelamin* (L/P)', 'No. WhatsApp*', 'No. Instansi*', 'No. Pribadi'];

        const rows = [headers];

        // Leader rows
        const leaderKeys = [
            { key: 'ketua', peran: 'Pimpinan', bidang: 'Ketua Pokja', jabatan: 'Ketua Pokja', instansi: 'Sekretaris Daerah' },
            { key: 'wakil', peran: 'Pimpinan', bidang: 'Wakil Ketua', jabatan: 'Wakil Ketua', instansi: 'Kepala Bappeda' },
            { key: 'koordinator', peran: 'Pimpinan', bidang: 'Koordinator', jabatan: 'Koordinator', instansi: 'Kepala Dinas Pendidikan' },
        ];

        leaderKeys.forEach(lk => {
            const d = s[lk.key] || {};
            rows.push([lk.peran, lk.bidang, lk.jabatan, lk.instansi, d.nama || '', d.email || '', d.jenisKelamin || '', d.noWa || '', d.nomorInstansi || '', d.nomorPribadi || '']);
        });

        // Anggota rows
        const anggotaList = s.anggota && s.anggota.length ? s.anggota : defaultAnggota;
        anggotaList.forEach(a => {
            rows.push(['Anggota', a.bidang || '', 'Anggota', INSTANSI_MAP[a.bidang] || 'Dinas terkait', a.nama || '', a.email || '', a.jenisKelamin || '', a.noWa || '', a.nomorInstansi || '', a.nomorPribadi || '']);
        });

        const ws = XLSX.utils.aoa_to_sheet(rows);

        // Set column widths
        ws['!cols'] = [
            { wch: 12 }, // Peran
            { wch: 22 }, // Bidang
            { wch: 18 }, // Jabatan
            { wch: 26 }, // Instansi
            { wch: 25 }, // Nama
            { wch: 30 }, // Email
            { wch: 18 }, // JK
            { wch: 18 }, // WA
            { wch: 18 }, // Instansi No
            { wch: 18 }, // Pribadi
        ];

        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Struktur Pokja');
        XLSX.writeFile(wb, `Template_Pokja_${wilayah.replace(/[^a-zA-Z0-9]/g, '_')}.xlsx`);

    } catch (err) {
        alert('Error: ' + err.message);
    }
}

// ---- Import Excel Modal System ----
let importPendingFile = null;

function openImportModal() {
    importPendingFile = null;
    const modal = document.getElementById('import-excel-modal');
    modal.style.display = '';
    document.getElementById('import-file-info').style.display = 'none';
    document.getElementById('btn-do-import').disabled = true;
    document.getElementById('import-file-input').value = '';
    setupDropzone();
}

function closeImportModal() {
    document.getElementById('import-excel-modal').style.display = 'none';
    importPendingFile = null;
}

function setupDropzone() {
    const dz = document.getElementById('import-dropzone');
    const prevent = (e) => { e.preventDefault(); e.stopPropagation(); };

    dz.addEventListener('dragenter', (e) => { prevent(e); dz.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20'); });
    dz.addEventListener('dragover', (e) => { prevent(e); dz.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20'); });
    dz.addEventListener('dragleave', (e) => { prevent(e); dz.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20'); });
    dz.addEventListener('drop', (e) => {
        prevent(e);
        dz.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        const files = e.dataTransfer.files;
        if (files.length && /\.(xlsx|xls)$/i.test(files[0].name)) {
            importPendingFile = files[0];
            showImportFileInfo(files[0].name);
        } else {
            alert('Pilih file dengan format .xlsx atau .xls');
        }
    });
}

function onImportFileSelected(input) {
    if (input.files && input.files[0]) {
        importPendingFile = input.files[0];
        showImportFileInfo(input.files[0].name);
    }
}

function showImportFileInfo(name) {
    document.getElementById('import-file-info').style.display = '';
    document.getElementById('import-file-name').textContent = name;
    document.getElementById('btn-do-import').disabled = false;
}

function clearImportFile() {
    importPendingFile = null;
    document.getElementById('import-file-info').style.display = 'none';
    document.getElementById('btn-do-import').disabled = true;
    document.getElementById('import-file-input').value = '';
}

async function doImport() {
    if (!importPendingFile) return;
    try {
        const XLSX = await loadSheetJS();
        const data = await importPendingFile.arrayBuffer();
        const wb = XLSX.read(data);
        const ws = wb.Sheets[wb.SheetNames[0]];
        const json = XLSX.utils.sheet_to_json(ws, { header: 1 });

        if (json.length < 2) { alert('File Excel kosong atau formatnya salah.'); return; }

        const dataRows = json.slice(1);
        const str = (v) => v != null ? String(v).trim() : '';

        // First 3 rows = Ketua, Wakil, Koordinator
        const leaders = {};
        const leaderMap = ['ketua', 'wakil', 'koordinator'];
        for (let i = 0; i < Math.min(3, dataRows.length); i++) {
            const r = dataRows[i];
            leaders[leaderMap[i]] = {
                nama: str(r[4]), email: str(r[5]), jenisKelamin: str(r[6]),
                noWa: str(r[7]), nomorInstansi: str(r[8]), nomorPribadi: str(r[9]),
            };
        }

        // Remaining rows = Anggota
        const anggota = [];
        for (let i = 3; i < dataRows.length; i++) {
            const r = dataRows[i];
            if (!r || !str(r[4])) continue;
            const bidang = str(r[1]) || 'Bidang Pendidikan';
            const isDefaultBidang = BIDANG_OPTIONS.some(b => b.value === bidang);
            anggota.push({
                bidang, isExtra: !isDefaultBidang, nama: str(r[4]), jabatan: 'Anggota',
                instansi: INSTANSI_MAP[bidang] || 'Dinas terkait', email: str(r[5]),
                jenisKelamin: str(r[6]), noWa: str(r[7]), nomorInstansi: str(r[8]), nomorPribadi: str(r[9]),
            });
        }

        // Save to localStorage as draft
        const subs = getSubmissions();
        const { idx } = getMySubmission();
        const wilayah = getWilayahName();

        const namaPokja = document.getElementById('nama-pokja')?.value || `Pokja BSAN ${wilayah}`;
        const callCenter = document.getElementById('call-center-pokja')?.value || '';

        const submission = idx >= 0 ? { ...subs[idx] } : { roleType: role, wilayah, status: 'draft', createdAt: new Date().toISOString() };
        submission.namaPokja = namaPokja;
        submission.callCenterPokja = callCenter;
        submission.struktur = { ...leaders, anggota };
        submission.updatedAt = new Date().toISOString();

        if (idx >= 0) subs[idx] = submission; else subs.push(submission);
        saveSubmissions(subs);

        closeImportModal();
        alert(`Berhasil import ${Object.keys(leaders).length} pimpinan dan ${anggota.length} anggota dari Excel!`);
        renderPokjaPage();

    } catch (err) {
        alert('Error membaca file: ' + err.message);
    }
}
</script>
<?= $this->endSection() ?>
