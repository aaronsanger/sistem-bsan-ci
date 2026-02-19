<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Pokja Not Approved Banner (injected by JS) -->
    <div id="pokja-gate-banner" style="display:none" class="dash-alert dash-alert--warning">
        <div style="display:flex;align-items:flex-start;gap:0.75rem">
            <svg style="width:1.5rem;height:1.5rem;color:#d97706;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <div>
                <p style="font-weight:600;font-size:1rem">Pokja Belum Disetujui</p>
                <p style="font-size:0.875rem;margin-top:0.25rem">Fitur Tambah Rujukan hanya aktif setelah data Pokja disetujui oleh Admin Pusat. Silakan lengkapi dan ajukan data Pokja terlebih dahulu.</p>
                <a href="/dashboard/pokja" class="btn-dash btn-dash--warning" style="display:inline-flex;align-items:center;gap:0.5rem;margin-top:0.75rem;font-size:0.875rem">
                    <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Isi Data Pokja
                </a>
            </div>
        </div>
    </div>

    <!-- Add Rujukan -->
    <div id="rujukan-form-card" class="dash-card">
        <h2 class="dash-card__title" style="margin-bottom:1rem">Tambah Rujukan</h2>
        <form id="rujukan-form" class="dash-grid--2">
            <div class="form-group">
                <label class="form-label">Nama <span style="color:#ef4444">*</span></label>
                <input type="text" id="ruj-nama" required class="form-input" placeholder="Nama lembaga / petugas">
            </div>
            <div class="form-group">
                <label class="form-label">No. WhatsApp <span style="color:#ef4444">*</span></label>
                <input type="tel" id="ruj-wa" required class="form-input" placeholder="08xxxxxxxxxx">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat <span style="color:#ef4444">*</span></label>
                <input type="text" id="ruj-alamat" required class="form-input" placeholder="Alamat lengkap">
            </div>
            <div class="form-group">
                <label class="form-label">Kategori <span style="color:#ef4444">*</span></label>
                <select id="ruj-kategori" required class="form-select">
                    <option value="">Pilih kategori</option>
                    <option value="pokja_bsan">Pokja BSAN Kab/Kota/Provinsi</option>
                    <option value="layanan_kesehatan">Layanan Kesehatan (Puskesmas, RSUD)</option>
                    <option value="layanan_konseling">Layanan Konseling/Psikologi (PIK-R, Puspaga, UPTD PPPA, KPAD)</option>
                    <option value="layanan_disabilitas">Layanan Disabilitas (Unit Layanan Disabilitas)</option>
                    <option value="pendampingan_sosial">Pendampingan Sosial (Dinsos, Babinsa, Bhabinkamtibmas, Peksos)</option>
                    <option value="bimbingan_rohani">Bimbingan Rohani (Tokoh Agama, Organisasi Agama, Tokoh Masyarakat)</option>
                    <option value="bantuan_hukum">Bantuan Hukum & Advokasi (LBH, Advokat, LPSK)</option>
                    <option value="kepolisian">Kepolisian (Polsek, Polres, Polda)</option>
                    <option value="pendampingan_profesi">Pendampingan Profesi (Satgas Perlindungan PTK, PGRI, ABKIN, IBKS, BKD)</option>
                    <option value="layanan_lain">Layanan Lain</option>
                </select>
            </div>
            <div style="grid-column: 1 / -1">
                <button type="submit" class="btn-dash btn-dash--primary">Simpan</button>
            </div>
        </form>
        <div id="ruj-alert" style="margin-top:1rem;display:none"></div>
    </div>

    <!-- Rujukan Table -->
    <div class="dash-card">
        <h2 class="dash-card__title" style="margin-bottom:1rem">Daftar Rujukan</h2>
        <div class="dash-table__wrapper">
            <table id="rujukan-table" class="dash-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Wilayah</th>
                        <th>Alamat</th>
                        <th>WhatsApp</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="rujukan-tbody"></tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const POKJA_SUBMISSIONS_KEY = 'bsan_pokja_submissions';
    const RUJUKAN_KEY = 'bsan_rujukan_data';

    const KATEGORI_LABELS = {
        pokja_bsan: 'Pokja BSAN',
        layanan_kesehatan: 'Layanan Kesehatan',
        layanan_konseling: 'Layanan Konseling/Psikologi',
        layanan_disabilitas: 'Layanan Disabilitas',
        pendampingan_sosial: 'Pendampingan Sosial',
        bimbingan_rohani: 'Bimbingan Rohani',
        bantuan_hukum: 'Bantuan Hukum & Advokasi',
        kepolisian: 'Kepolisian',
        pendampingan_profesi: 'Pendampingan Profesi',
        layanan_lain: 'Layanan Lain',
    };

    let rujukanDT;

    // Phone normalization: any format → 628xxxxxxxxx (same as pokja.php)
    function normalizePhone(val) {
        let digits = val.replace(/[^0-9]/g, '');
        if (digits.startsWith('0')) digits = '62' + digits.substring(1);
        else if (!digits.startsWith('62') && digits.length > 0) digits = '62' + digits;
        return digits;
    }

    function isValidPhoneLength(v) {
        const digits = v.replace(/[^0-9]/g, '');
        return digits.length >= 10 && digits.length <= 13;
    }

    // Get current wilayah name for the logged-in role
    function getMyWilayah() {
        const role = localStorage.getItem('bsan_demo_role') || 'kementerian';
        const provName = localStorage.getItem('bsan_wilayah_prov') || '';
        const kabName = localStorage.getItem('bsan_wilayah_kab') || '';
        if (role === 'dinas_prov') return provName ? `Prov. ${provName}` : 'Provinsi';
        if (role === 'dinas_kab') return kabName || 'Kabupaten/Kota';
        return 'Kementerian Pusat';
    }

    function isAdmin() {
        return (localStorage.getItem('bsan_demo_role') || 'kementerian') === 'kementerian';
    }

    // Check if Pokja is approved for current role
    function isPokjaApproved() {
        const role = localStorage.getItem('bsan_demo_role') || 'kementerian';
        if (role === 'kementerian') return true;
        const subs = JSON.parse(localStorage.getItem(POKJA_SUBMISSIONS_KEY) || '[]');
        const wilayah = getMyWilayah();
        const mySub = subs.find(s => s.roleType === role && s.wilayah === wilayah);
        return mySub && mySub.status === 'approved';
    }

    const pokjaApproved = isPokjaApproved();
    const myWilayah = getMyWilayah();
    const adminRole = isAdmin();

    function applyFeatureGate() {
        if (!pokjaApproved) {
            document.getElementById('pokja-gate-banner').style.display = '';
            document.getElementById('rujukan-form-card').style.display = 'none';
        }
    }

    // localStorage CRUD
    function getRujukan() { return JSON.parse(localStorage.getItem(RUJUKAN_KEY) || '[]'); }
    function saveRujukan(data) { localStorage.setItem(RUJUKAN_KEY, JSON.stringify(data)); }

    // Get only the rujukan visible to current user
    function getVisibleRujukan() {
        const all = getRujukan();
        if (adminRole) return all; // admin sees everything
        return all.filter(r => r.wilayah === myWilayah);
    }

    $(document).ready(function () {
        applyFeatureGate();
        renderRujukan();

        // Live phone normalization on blur (same as pokja)
        $('#ruj-wa').on('blur', function () {
            const raw = this.value.trim();
            if (raw) this.value = normalizePhone(raw);
        });
        // Restrict to digits only on input
        $('#ruj-wa').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('#rujukan-form').on('submit', function (e) {
            e.preventDefault();

            const nama = $('#ruj-nama').val().trim();
            let wa = normalizePhone($('#ruj-wa').val().trim());
            const alamat = $('#ruj-alamat').val().trim();
            const kategori = $('#ruj-kategori').val();

            if (!nama || !wa || !alamat || !kategori) {
                showAlert('ruj-alert', 'Lengkapi semua field wajib.', 'error');
                return;
            }
            if (!isValidPhoneLength(wa)) {
                showAlert('ruj-alert', 'No. WhatsApp harus 10-13 digit.', 'error');
                return;
            }

            const rujukan = getRujukan();
            rujukan.push({
                id: Date.now().toString(),
                nama,
                no_whatsapp: wa,
                alamat,
                kategori,
                wilayah: myWilayah,
                createdAt: new Date().toISOString(),
            });
            saveRujukan(rujukan);

            showAlert('ruj-alert', 'Rujukan berhasil ditambahkan!', 'success');
            this.reset();
            renderRujukan();
        });
    });

    function renderRujukan() {
        const data = getVisibleRujukan();
        if (rujukanDT) { rujukanDT.destroy(); rujukanDT = null; }

        let html = '';
        if (data.length > 0) {
            data.forEach((r, i) => {
                html += `<tr>
                    <td>${i + 1}</td>
                    <td class="dash-table__cell--primary">${r.nama}</td>
                    <td>${r.wilayah || '-'}</td>
                    <td>${r.alamat}</td>
                    <td>${r.no_whatsapp}</td>
                    <td><span class="badge badge--info">${KATEGORI_LABELS[r.kategori] || r.kategori}</span></td>
                    <td>
                        ${pokjaApproved && (adminRole || r.wilayah === myWilayah) ? `<button onclick="deleteRujukan('${r.id}')" style="color:#dc2626;font-size:0.75rem;cursor:pointer;background:none;border:none">Hapus</button>` : '<span style="font-size:0.75rem;color:var(--dash-text-muted)">—</span>'}
                    </td>
                </tr>`;
            });
        }
        $('#rujukan-tbody').html(html || '<tr><td colspan="7" class="dash-table__empty">Belum ada data rujukan.</td></tr>');
        if (html) {
            rujukanDT = $('#rujukan-table').DataTable({
                pageLength: 10,
                order: [[1, 'asc'], [2, 'asc']],
                language: { url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/id.json' }
            });
        }
    }

    function deleteRujukan(id) {
        if (confirm('Yakin ingin menghapus rujukan ini?')) {
            const data = getRujukan().filter(r => r.id !== id);
            saveRujukan(data);
            renderRujukan();
        }
    }

    function showAlert(id, message, type) {
        const el = document.getElementById(id);
        const cls = type === 'success' ? 'dash-alert dash-alert--success' : 'dash-alert dash-alert--danger';
        el.className = cls;
        el.textContent = message;
        el.style.display = '';
        setTimeout(() => el.style.display = 'none', 3000);
    }
</script>
<?= $this->endSection() ?>
