<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Invite Form -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Undang Anggota Pokja</h2>
        <form id="invite-form" class="flex flex-col sm:flex-row gap-4">
            <input type="email" id="invite-email" placeholder="Email anggota" required class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
            <select id="invite-kategori" class="px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="bidang_pendidikan">Bidang Pendidikan</option>
                <option value="bidang_pppa">Bidang PPPA</option>
                <option value="bidang_sosial">Bidang Sosial</option>
                <option value="bidang_kesehatan">Bidang Kesehatan</option>
                <option value="bidang_dukbangga">Bidang Dukbangga</option>
                <option value="bidang_kominfo">Bidang Kominfo</option>
                <option value="kepolisian">Kepolisian</option>
                <option value="tokoh_masyarakat">Tokoh Masyarakat</option>
                <option value="oms_mitra">OMS/Mitra</option>
            </select>
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">Undang</button>
        </form>
        <div id="invite-result" class="mt-4 hidden"></div>
    </div>

    <!-- Pokja Members Table -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Anggota Pokja</h2>
        <div class="overflow-x-auto">
            <table id="pokja-table" class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">No</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Nama</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Email</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Kategori</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Status</th>
                    </tr>
                </thead>
                <tbody id="pokja-tbody"></tbody>
            </table>
        </div>
        <div id="pokja-empty" class="hidden text-center py-8 text-gray-500 dark:text-gray-400">
            Belum ada data anggota Pokja.
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        loadPokja();

        $('#invite-form').on('submit', function (e) {
            e.preventDefault();
            const email = $('#invite-email').val();
            const kategori = $('#invite-kategori').val();

            $.post('/dashboard/pokja/invite', { email, kategori }, function (data) {
                if (data.success) {
                    $('#invite-result').removeClass('hidden text-red-600').addClass('text-green-600')
                        .html('Tautan undangan: <code class="bg-gray-100 dark:bg-[#1a1414] px-2 py-1 rounded text-xs">' + data.link + '</code>');
                    $('#invite-email').val('');
                } else {
                    $('#invite-result').removeClass('hidden text-green-600').addClass('text-red-600')
                        .text('Gagal: ' + (data.error || 'Terjadi kesalahan'));
                }
            }, 'json');
        });
    });

    function loadPokja() {
        $.getJSON('/api/pokja/list', function (data) {
            if (!data || data.length === 0 || data.error) {
                $('#pokja-empty').removeClass('hidden');
                return;
            }

            let html = '';
            let no = 1;
            data.forEach(pokja => {
                if (pokja.pokja_anggota) {
                    pokja.pokja_anggota.forEach(anggota => {
                        const profile = anggota.profiles || {};
                        const statusClass = pokja.status === 'approved' ? 'bg-green-100 text-green-800' : pokja.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800';
                        html += `<tr class="border-b dark:border-[#3f4739]">
                            <td class="px-4 py-3 dark:text-gray-300">${no++}</td>
                            <td class="px-4 py-3 dark:text-white font-medium">${profile.nama_depan || ''} ${profile.nama_belakang || ''}</td>
                            <td class="px-4 py-3 dark:text-gray-300">${profile.email || ''}</td>
                            <td class="px-4 py-3 dark:text-gray-300">${anggota.kategori || ''}</td>
                            <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium ${statusClass}">${pokja.status}</span></td>
                        </tr>`;
                    });
                }
            });

            if (html) {
                $('#pokja-tbody').html(html);
                $('#pokja-table').DataTable({ pageLength: 10, language: { url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/id.json' } });
            } else {
                $('#pokja-empty').removeClass('hidden');
            }
        });
    }
</script>
<?= $this->endSection() ?>
