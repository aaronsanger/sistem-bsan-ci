<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Add Rujukan -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tambah Rujukan</h2>
        <form id="rujukan-form" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                <input type="text" id="ruj-nama" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. WhatsApp</label>
                <input type="text" id="ruj-wa" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                <input type="text" id="ruj-alamat" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                <select id="ruj-kategori" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="psikolog">Psikolog</option>
                    <option value="konselor">Konselor</option>
                    <option value="dokter">Dokter</option>
                    <option value="polisi">Polisi</option>
                    <option value="lsm">LSM</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">Simpan</button>
            </div>
        </form>
        <div id="ruj-alert" class="mt-4 hidden"></div>
    </div>

    <!-- Rujukan Table -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Rujukan</h2>
        <div class="overflow-x-auto">
            <table id="rujukan-table" class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">No</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Nama</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Alamat</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">WhatsApp</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Kategori</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Aksi</th>
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
                    html += `<tr class="border-b dark:border-[#3f4739]">
                        <td class="px-4 py-3 dark:text-gray-300">${i + 1}</td>
                        <td class="px-4 py-3 dark:text-white font-medium">${r.nama}</td>
                        <td class="px-4 py-3 dark:text-gray-300">${r.alamat}</td>
                        <td class="px-4 py-3 dark:text-gray-300">${r.no_whatsapp}</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-xs font-medium">${kategoriLabel[r.kategori] || r.kategori}</span></td>
                        <td class="px-4 py-3">
                            <button onclick="deleteRujukan('${r.id}')" class="text-red-600 dark:text-red-400 hover:underline text-xs">Hapus</button>
                        </td>
                    </tr>`;
                });
            }
            $('#rujukan-tbody').html(html || '<tr><td colspan="6" class="text-center py-8 text-gray-500 dark:text-gray-400">Belum ada data rujukan.</td></tr>');
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
        const el = $('#' + id);
        const colorClass = type === 'success' ? 'text-green-600 bg-green-50 border-green-200' : 'text-red-600 bg-red-50 border-red-200';
        el.removeClass('hidden').attr('class', `mt-4 px-4 py-3 rounded-xl border ${colorClass}`).text(message);
        setTimeout(() => el.addClass('hidden'), 3000);
    }
</script>
<?= $this->endSection() ?>
