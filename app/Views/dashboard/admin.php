<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Invite User -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Undang Pengguna</h2>
        <form id="admin-invite-form" class="flex flex-col sm:flex-row gap-4">
            <input type="email" id="admin-email" placeholder="Email" required class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
            <select id="admin-role" class="px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white outline-none">
                <option value="koordinator">Koordinator</option>
                <option value="ketua">Ketua</option>
                <option value="wakil_ketua">Wakil Ketua</option>
                <option value="anggota">Anggota</option>
            </select>
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">Undang</button>
        </form>
        <div id="admin-invite-result" class="mt-4 hidden"></div>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Pengguna</h2>
        <div class="overflow-x-auto">
            <table id="users-table" class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">No</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Nama</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Email</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Role</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody id="users-tbody"></tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        loadUsers();

        $('#admin-invite-form').on('submit', function (e) {
            e.preventDefault();
            $.post('/dashboard/admin/invite', {
                email: $('#admin-email').val(),
                role: $('#admin-role').val(),
            }, function (data) {
                const el = $('#admin-invite-result');
                if (data.success) {
                    el.removeClass('hidden text-red-600').addClass('text-green-600').text('Undangan berhasil dikirim! Token: ' + data.token);
                    $('#admin-email').val('');
                } else {
                    el.removeClass('hidden text-green-600').addClass('text-red-600').text('Gagal: ' + (data.error || 'Error'));
                }
            }, 'json');
        });
    });

    function loadUsers() {
        $.getJSON('/api/admin/users', function (data) {
            if (!Array.isArray(data) || data.length === 0) {
                $('#users-tbody').html('<tr><td colspan="6" class="text-center py-8 text-gray-500">Belum ada data pengguna.</td></tr>');
                return;
            }

            let html = '';
            const roleLabels = { kementerian: 'Kementerian', ketua: 'Ketua', wakil_ketua: 'Wakil Ketua', koordinator: 'Koordinator', anggota: 'Anggota' };
            const statusColors = { aktif: 'bg-green-100 text-green-800', pending: 'bg-yellow-100 text-yellow-800', nonaktif: 'bg-red-100 text-red-800' };

            data.forEach((u, i) => {
                html += `<tr class="border-b dark:border-[#3f4739]">
                    <td class="px-4 py-3 dark:text-gray-300">${i + 1}</td>
                    <td class="px-4 py-3 dark:text-white font-medium">${u.nama_depan || ''} ${u.nama_belakang || ''}</td>
                    <td class="px-4 py-3 dark:text-gray-300">${u.email || ''}</td>
                    <td class="px-4 py-3">
                        <select onchange="updateRole('${u.id}', this.value)" class="px-2 py-1 text-xs border rounded-lg dark:bg-[#1a1414] dark:border-[#3f4739] dark:text-white">
                            ${Object.entries(roleLabels).map(([k, v]) => `<option value="${k}" ${u.role === k ? 'selected' : ''}>${v}</option>`).join('')}
                        </select>
                    </td>
                    <td class="px-4 py-3">
                        <select onchange="updateStatus('${u.id}', this.value)" class="px-2 py-1 text-xs border rounded-lg dark:bg-[#1a1414] dark:border-[#3f4739] dark:text-white">
                            <option value="aktif" ${u.status === 'aktif' ? 'selected' : ''}>Aktif</option>
                            <option value="pending" ${u.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="nonaktif" ${u.status === 'nonaktif' ? 'selected' : ''}>Nonaktif</option>
                        </select>
                    </td>
                    <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium ${statusColors[u.status] || 'bg-gray-100 text-gray-800'}">${u.status}</span></td>
                </tr>`;
            });

            $('#users-tbody').html(html);
            $('#users-table').DataTable({ pageLength: 10, language: { url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/id.json' } });
        });
    }

    function updateRole(userId, role) {
        $.post('/dashboard/admin/update-role', { user_id: userId, role }, function (data) {
            if (!data.success) alert('Gagal mengubah role');
        }, 'json');
    }

    function updateStatus(userId, status) {
        $.post('/dashboard/admin/update-status', { user_id: userId, status }, function (data) {
            if (!data.success) alert('Gagal mengubah status');
        }, 'json');
    }
</script>
<?= $this->endSection() ?>
