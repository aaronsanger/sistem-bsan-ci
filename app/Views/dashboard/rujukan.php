<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Add Rujukan -->
    <div class="dash-card">
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
    let rujukanDT;

    $(document).ready(function () {
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
                            <button onclick="deleteRujukan('${r.id}')" style="color:#dc2626;font-size:0.75rem;cursor:pointer;background:none;border:none">Hapus</button>
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
