<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Kelola Pokja</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola anggota Kelompok Kerja daerah Anda</p>
        </div>
        <button onclick="openAddModal()" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Pokja
        </button>
    </div>

    <!-- SK Pokja Upload -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Dokumen SK Pokja</h3>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <input type="file" id="sk-pokja-file" accept=".pdf" class="text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
            <button onclick="uploadSK()" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Upload SK</button>
            <span id="sk-status" class="text-sm text-gray-500 dark:text-gray-400"></span>
        </div>
    </div>

    <!-- Pokja Members Table -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Anggota Pokja</h3>
        <div class="overflow-x-auto">
            <table id="pokja-table" class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">No</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Jabatan</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Nama</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Email</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">No. WA</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pokja-tbody"></tbody>
            </table>
        </div>
        <div id="pokja-empty" class="hidden text-center py-8 text-gray-500 dark:text-gray-400">
            Belum ada data anggota Pokja. Klik "Tambah Pokja" untuk menambahkan.
        </div>
    </div>
</div>

<!-- Add Pokja Modal -->
<div id="add-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeAddModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white dark:bg-[#0F0A0A] px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tambah Anggota Pokja</h3>
                <button onclick="closeAddModal()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="add-pokja-form" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jabatan dalam Pokja <span class="text-red-500">*</span></label>
                    <select id="pokja-jabatan" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih Jabatan</option>
                        <option value="Ketua">Ketua — Sekretaris Daerah</option>
                        <option value="Wakil Ketua">Wakil Ketua — Kepala Bappeda</option>
                        <option value="Koordinator">Koordinator — Kepala Dinas Pendidikan</option>
                        <option value="Anggota - Bidang Pendidikan">Anggota — Bidang Pendidikan</option>
                        <option value="Anggota - Bidang PPPA">Anggota — Bidang PPPA</option>
                        <option value="Anggota - Bidang Sosial">Anggota — Bidang Sosial</option>
                        <option value="Anggota - Bidang Kesehatan">Anggota — Bidang Kesehatan</option>
                        <option value="Anggota - Bidang Dukbangga">Anggota — Bidang Dukbangga</option>
                        <option value="Anggota - Bidang Kominfo">Anggota — Bidang Kominfo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="pokja-nama" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama lengkap anggota">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="pokja-email" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="email@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select id="pokja-gender" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Whatsapp <span class="text-gray-400 text-xs">(opsional)</span></label>
                    <input type="tel" id="pokja-wa" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="08xxxxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Call Center Pokja <span class="text-gray-400 text-xs">(opsional)</span></label>
                    <input type="tel" id="pokja-callcenter" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="021-xxxxxxx">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeAddModal()" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1a1414] transition-colors font-medium">Batal</button>
                    <button type="submit" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const POKJA_KEY = 'bsan_pokja_members';

    function getPokjaData() {
        return JSON.parse(localStorage.getItem(POKJA_KEY) || '[]');
    }

    function savePokjaData(data) {
        localStorage.setItem(POKJA_KEY, JSON.stringify(data));
    }

    function openAddModal() {
        document.getElementById('add-modal').classList.remove('hidden');
        document.getElementById('add-pokja-form').reset();
    }

    function closeAddModal() {
        document.getElementById('add-modal').classList.add('hidden');
    }

    function uploadSK() {
        const file = document.getElementById('sk-pokja-file').files[0];
        if (!file) { alert('Pilih file PDF terlebih dahulu.'); return; }
        if (file.type !== 'application/pdf') { alert('Hanya file PDF yang diperbolehkan.'); return; }
        // Store filename in localStorage
        localStorage.setItem('bsan_sk_pokja', JSON.stringify({ name: file.name, date: new Date().toISOString() }));
        document.getElementById('sk-status').textContent = '✅ ' + file.name + ' berhasil diupload';
    }

    function renderTable() {
        const data = getPokjaData();
        const tbody = document.getElementById('pokja-tbody');
        const empty = document.getElementById('pokja-empty');

        if (data.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');
        tbody.innerHTML = data.map((m, i) => `
            <tr class="border-b dark:border-[#3f4739]">
                <td class="px-4 py-3 dark:text-gray-300">${i + 1}</td>
                <td class="px-4 py-3 dark:text-gray-300"><span class="px-2 py-1 rounded-full text-xs font-medium ${m.jabatan.startsWith('Anggota') ? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300'}">${m.jabatan}</span></td>
                <td class="px-4 py-3 dark:text-white font-medium">${m.nama}</td>
                <td class="px-4 py-3 dark:text-gray-300">${m.email}</td>
                <td class="px-4 py-3 dark:text-gray-300">${m.gender}</td>
                <td class="px-4 py-3 dark:text-gray-300">${m.wa || '-'}</td>
                <td class="px-4 py-3">
                    <button onclick="deleteMember(${i})" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">Hapus</button>
                </td>
            </tr>
        `).join('');
    }

    function deleteMember(index) {
        if (!confirm('Hapus anggota ini?')) return;
        const data = getPokjaData();
        data.splice(index, 1);
        savePokjaData(data);
        renderTable();
    }

    document.getElementById('add-pokja-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const member = {
            jabatan: document.getElementById('pokja-jabatan').value,
            nama: document.getElementById('pokja-nama').value,
            email: document.getElementById('pokja-email').value,
            gender: document.getElementById('pokja-gender').value,
            wa: document.getElementById('pokja-wa').value,
            callcenter: document.getElementById('pokja-callcenter').value,
            createdAt: new Date().toISOString()
        };
        const data = getPokjaData();
        data.push(member);
        savePokjaData(data);
        closeAddModal();
        renderTable();
    });

    // Load SK status
    $(document).ready(function() {
        renderTable();
        const sk = JSON.parse(localStorage.getItem('bsan_sk_pokja') || 'null');
        if (sk) {
            document.getElementById('sk-status').textContent = '📄 ' + sk.name;
        }
    });
</script>
<?= $this->endSection() ?>
