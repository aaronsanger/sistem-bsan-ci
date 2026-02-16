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
                <label class="form-label">Nama</label>
                <input type="text" id="ruj-nama" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">No. WhatsApp</label>
                <input type="text" id="ruj-wa" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <input type="text" id="ruj-alamat" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select id="ruj-kategori" class="form-select">
                    <option value="psikolog">Psikolog</option>
                    <option value="konselor">Konselor</option>
                    <option value="dokter">Dokter</option>
                    <option value="polisi">Polisi</option>
                    <option value="lsm">LSM</option>
                    <option value="lainnya">Lainnya</option>
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
    let rujukanDT;

    // Check if Pokja is approved for current role (same pattern as pelaporan.php)
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

    // Apply feature gating on page load
    function applyFeatureGate() {
        if (!pokjaApproved) {
            document.getElementById('pokja-gate-banner').style.display = '';
            document.getElementById('rujukan-form-card').style.display = 'none';
        }
    }

    $(document).ready(function () {
        applyFeatureGate();
        loadRujukan();

        $('#rujukan-form').on('submit', function (e) {
            e.preventDefault();
            $.post('/dashboard/rujukan', {
                nama: $('#ruj-nama').val(),
                alamat: $('#ruj-alamat').val(),
                no_whatsapp: $('#ruj-wa').val(),
                kategori: $('#ruj-kategori').val(),
            }, function (data) {
                if (data.success) {
                    showAlert('ruj-alert', 'Rujukan berhasil ditambahkan!', 'success');
                    $('#rujukan-form')[0].reset();
                    loadRujukan();
                } else {
                    showAlert('ruj-alert', 'Gagal: ' + (data.error || 'Terjadi kesalahan'), 'error');
                }
            }, 'json');
        });
    });

    function loadRujukan() {
        $.getJSON('/api/rujukan/list', function (data) {
            if (rujukanDT) rujukanDT.destroy();
            let html = '';
            if (Array.isArray(data)) {
                data.forEach((r, i) => {
                    const kategoriLabel = { psikolog: 'Psikolog', konselor: 'Konselor', dokter: 'Dokter', polisi: 'Polisi', lsm: 'LSM', lainnya: 'Lainnya' };
                    html += `<tr>
                        <td>${i + 1}</td>
                        <td class="dash-table__cell--primary">${r.nama}</td>
                        <td>${r.alamat}</td>
                        <td>${r.no_whatsapp}</td>
                        <td><span class="badge badge--info">${kategoriLabel[r.kategori] || r.kategori}</span></td>
                        <td>
                            ${pokjaApproved ? `<button onclick="deleteRujukan('${r.id}')" style="color:#dc2626;font-size:0.75rem;cursor:pointer;background:none;border:none">Hapus</button>` : '<span style="font-size:0.75rem;color:var(--dash-text-muted)">—</span>'}
                        </td>
                    </tr>`;
                });
            }
            $('#rujukan-tbody').html(html || '<tr><td colspan="6" class="dash-table__empty">Belum ada data rujukan.</td></tr>');
            if (html) {
                rujukanDT = $('#rujukan-table').DataTable({ pageLength: 10, language: { url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/id.json' } });
            }
        });
    }

    function deleteRujukan(id) {
        if (confirm('Yakin ingin menghapus rujukan ini?')) {
            $.post('/dashboard/rujukan/delete', { id }, function (data) {
                if (data.success) loadRujukan();
            }, 'json');
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

