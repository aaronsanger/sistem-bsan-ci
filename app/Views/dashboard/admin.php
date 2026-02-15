<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Invite User -->
    <div class="dash-card">
        <h2 class="dash-card__title" style="margin-bottom:1rem">Undang Pengguna</h2>
        <form id="admin-invite-form" class="d-flex d-flex--col d-flex--gap-4 sm-flex-row">
            <input type="email" id="admin-email" placeholder="Email" required class="form-input" style="flex:1">
            <select id="admin-role" class="form-select" style="width:auto">
                <option value="koordinator">Koordinator</option>
                <option value="ketua">Ketua</option>
                <option value="wakil_ketua">Wakil Ketua</option>
                <option value="anggota">Anggota</option>
            </select>
            <button type="submit" class="btn-dash btn-dash--primary">Undang</button>
        </form>
        <div id="admin-invite-result" style="margin-top:1rem;display:none"></div>
    </div>

    <!-- Users Table -->
    <div class="dash-card">
        <h2 class="dash-card__title" style="margin-bottom:1rem">Daftar Pengguna</h2>
        <div class="dash-table__wrapper">
            <table id="users-table" class="dash-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
                    el.css('display', '').css('color', '#16a34a').text('Undangan berhasil dikirim! Token: ' + data.token);
                    $('#admin-email').val('');
                } else {
                    el.css('display', '').css('color', '#dc2626').text('Gagal: ' + (data.error || 'Error'));
                }
            }, 'json');
        });
    });

    function loadUsers() {
        $.getJSON('/api/admin/users', function (data) {
            if (!Array.isArray(data) || data.length === 0) {
                $('#users-tbody').html('<tr><td colspan="6" class="dash-table__empty">Belum ada data pengguna.</td></tr>');
                return;
            }

            let html = '';
            const roleLabels = { kementerian: 'Kementerian', ketua: 'Ketua', wakil_ketua: 'Wakil Ketua', koordinator: 'Koordinator', anggota: 'Anggota' };
            const statusBadge = { aktif: 'badge--success', pending: 'badge--warning', nonaktif: 'badge--danger' };

            data.forEach((u, i) => {
                html += `<tr>
                    <td>${i + 1}</td>
                    <td class="dash-table__cell--primary">${u.nama_depan || ''} ${u.nama_belakang || ''}</td>
                    <td>${u.email || ''}</td>
                    <td>
                        <select onchange="updateRole('${u.id}', this.value)" class="form-select form-input--sm">
                            ${Object.entries(roleLabels).map(([k, v]) => `<option value="${k}" ${u.role === k ? 'selected' : ''}>${v}</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <select onchange="updateStatus('${u.id}', this.value)" class="form-select form-input--sm">
                            <option value="aktif" ${u.status === 'aktif' ? 'selected' : ''}>Aktif</option>
                            <option value="pending" ${u.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="nonaktif" ${u.status === 'nonaktif' ? 'selected' : ''}>Nonaktif</option>
                        </select>
                    </td>
                    <td><span class="badge ${statusBadge[u.status] || 'badge--gray'}">${u.status}</span></td>
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
