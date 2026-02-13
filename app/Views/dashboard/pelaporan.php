<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pelaporan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola pelaporan pemenuhan aspek dan penanganan pelanggaran</p>
        </div>
        <button onclick="openModeModal()" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Pelaporan
        </button>
    </div>

    <!-- Records Table -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat Pelaporan</h3>
        <div class="overflow-x-auto">
            <table id="pelaporan-table" class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1a1414]">
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">No</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Tipe</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Nama</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Kategori</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Tanggal Kejadian</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pelaporan-tbody"></tbody>
            </table>
        </div>
        <div id="pelaporan-empty" class="hidden text-center py-8 text-gray-500 dark:text-gray-400">
            Belum ada data pelaporan.
        </div>
    </div>
</div>

<!-- Mode Selection Modal -->
<div id="mode-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeModeModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-md shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pilih Jenis Pelaporan</h3>
                <button onclick="closeModeModal()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <button onclick="selectMode('termin')" class="w-full text-left p-4 rounded-xl border-2 border-gray-200 dark:border-[#3f4739] hover:border-blue-500 dark:hover:border-blue-500 transition-colors group">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">Satu Termin</h4>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 ml-13">Pelaporan dilakukan dalam satu termin waktu di akhir tahun</p>
                </button>
                <button onclick="selectMode('insidental')" class="w-full text-left p-4 rounded-xl border-2 border-gray-200 dark:border-[#3f4739] hover:border-blue-500 dark:hover:border-blue-500 transition-colors group">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">Insidental</h4>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 ml-13">Pelaporan bertahap sepanjang tahun — setiap kali pemenuhan aspek dilakukan atau pelanggaran diselesaikan</p>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Satu Termin Modal (placeholder) -->
<div id="termin-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeTerminModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-md shadow-2xl p-8 text-center">
            <div class="w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Pelaporan Satu Termin</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Fitur pelaporan akhir tahun akan tersedia pada periode pelaporan berikutnya.</p>
            <button onclick="closeTerminModal()" class="bg-gray-200 dark:bg-[#3f4739] hover:bg-gray-300 dark:hover:bg-[#4a5243] text-gray-700 dark:text-gray-300 font-medium px-6 py-2.5 rounded-lg transition-colors">Tutup</button>
        </div>
    </div>
</div>

<!-- Insidental Form Modal -->
<div id="insidental-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeInsidentalModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white dark:bg-[#0F0A0A] px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pelaporan Insidental</h3>
                <button onclick="closeInsidentalModal()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="insidental-form" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Pelapor <span class="text-red-500">*</span></label>
                    <input type="text" id="ins-nama" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama pelapor">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Siapa yang Terlibat <span class="text-red-500">*</span></label>
                    <textarea id="ins-terlibat" required rows="2" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Nama pihak yang terlibat"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kapan Terjadi <span class="text-red-500">*</span></label>
                    <input type="date" id="ins-tanggal" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Pelanggaran <span class="text-red-500">*</span></label>
                    <select id="ins-kategori" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih Kategori</option>
                        <option value="Kekerasan Fisik">Kekerasan Fisik</option>
                        <option value="Kekerasan Psikis">Kekerasan Psikis</option>
                        <option value="Kekerasan Seksual">Kekerasan Seksual</option>
                        <option value="Perundungan">Perundungan</option>
                        <option value="Diskriminasi">Diskriminasi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dokumentasi <span class="text-red-500">*</span></label>
                    <input type="file" id="ins-dokumentasi" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG, DOC (maks 10MB)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rekomendasi <span class="text-red-500">*</span></label>
                    <textarea id="ins-rekomendasi" required rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Rekomendasi tindak lanjut"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status <span class="text-gray-400 text-xs">(opsional)</span></label>
                    <select id="ins-status" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih Status</option>
                        <option value="Dihentikan">Dihentikan</option>
                        <option value="Tidak Selesai">Tidak Selesai</option>
                        <option value="Sudah Ditangani">Sudah Ditangani</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeInsidentalModal()" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1a1414] transition-colors font-medium">Batal</button>
                    <button type="submit" class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail View Modal -->
<div id="detail-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeDetailModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-[#0F0A0A] rounded-2xl border border-gray-200 dark:border-[#3f4739] w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white dark:bg-[#0F0A0A] px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Pelaporan</h3>
                <button onclick="closeDetailModal()" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3f4739]">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="detail-content" class="p-6 space-y-3"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const PELAPORAN_KEY = 'bsan_pelaporan';

    function getData() { return JSON.parse(localStorage.getItem(PELAPORAN_KEY) || '[]'); }
    function saveData(d) { localStorage.setItem(PELAPORAN_KEY, JSON.stringify(d)); }

    function openModeModal() { document.getElementById('mode-modal').classList.remove('hidden'); }
    function closeModeModal() { document.getElementById('mode-modal').classList.add('hidden'); }
    function closeTerminModal() { document.getElementById('termin-modal').classList.add('hidden'); }
    function closeInsidentalModal() { document.getElementById('insidental-modal').classList.add('hidden'); }
    function closeDetailModal() { document.getElementById('detail-modal').classList.add('hidden'); }

    function selectMode(mode) {
        closeModeModal();
        if (mode === 'termin') {
            document.getElementById('termin-modal').classList.remove('hidden');
        } else {
            document.getElementById('insidental-form').reset();
            document.getElementById('insidental-modal').classList.remove('hidden');
        }
    }

    function getStatusBadge(status) {
        if (!status) return '<span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">Belum diatur</span>';
        const colors = {
            'Dihentikan': 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
            'Tidak Selesai': 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
            'Sudah Ditangani': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
            'Selesai': 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
        };
        return `<span class="px-2 py-1 rounded-full text-xs font-medium ${colors[status] || ''}">${status}</span>`;
    }

    function renderTable() {
        const data = getData();
        const tbody = document.getElementById('pelaporan-tbody');
        const empty = document.getElementById('pelaporan-empty');

        if (data.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');
        tbody.innerHTML = data.map((r, i) => `
            <tr class="border-b dark:border-[#3f4739]">
                <td class="px-4 py-3 dark:text-gray-300">${i + 1}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium ${r.tipe === 'Insidental' ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300'}">${r.tipe}</span></td>
                <td class="px-4 py-3 dark:text-white font-medium">${r.nama}</td>
                <td class="px-4 py-3 dark:text-gray-300">${r.kategori}</td>
                <td class="px-4 py-3 dark:text-gray-300">${r.tanggal}</td>
                <td class="px-4 py-3">${getStatusBadge(r.status)}</td>
                <td class="px-4 py-3 space-x-2">
                    <button onclick="viewDetail(${i})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">Lihat</button>
                    <button onclick="deleteRecord(${i})" class="text-red-600 hover:text-red-800 dark:text-red-400 text-sm font-medium">Hapus</button>
                </td>
            </tr>
        `).join('');
    }

    function viewDetail(index) {
        const r = getData()[index];
        if (!r) return;
        document.getElementById('detail-content').innerHTML = `
            <div class="space-y-3">
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipe:</span><p class="text-gray-900 dark:text-white">${r.tipe}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pelapor:</span><p class="text-gray-900 dark:text-white">${r.nama}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Pihak Terlibat:</span><p class="text-gray-900 dark:text-white">${r.terlibat}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kejadian:</span><p class="text-gray-900 dark:text-white">${r.tanggal}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori:</span><p class="text-gray-900 dark:text-white">${r.kategori}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Dokumentasi:</span><p class="text-gray-900 dark:text-white">${r.dokumentasi || '-'}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Rekomendasi:</span><p class="text-gray-900 dark:text-white">${r.rekomendasi}</p></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status:</span><div class="mt-1">${getStatusBadge(r.status)}</div></div>
                <div><span class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat:</span><p class="text-gray-900 dark:text-white text-sm">${new Date(r.createdAt).toLocaleString('id-ID')}</p></div>
            </div>
        `;
        document.getElementById('detail-modal').classList.remove('hidden');
    }

    function deleteRecord(index) {
        if (!confirm('Hapus pelaporan ini?')) return;
        const data = getData();
        data.splice(index, 1);
        saveData(data);
        renderTable();
    }

    document.getElementById('insidental-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const file = document.getElementById('ins-dokumentasi').files[0];
        const record = {
            tipe: 'Insidental',
            nama: document.getElementById('ins-nama').value,
            terlibat: document.getElementById('ins-terlibat').value,
            tanggal: document.getElementById('ins-tanggal').value,
            kategori: document.getElementById('ins-kategori').value,
            dokumentasi: file ? file.name : '',
            rekomendasi: document.getElementById('ins-rekomendasi').value,
            status: document.getElementById('ins-status').value || '',
            createdAt: new Date().toISOString()
        };
        const data = getData();
        data.push(record);
        saveData(data);
        closeInsidentalModal();
        renderTable();
    });

    $(document).ready(function() { renderTable(); });
</script>
<?= $this->endSection() ?>
