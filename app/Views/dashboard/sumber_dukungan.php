<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Input Sumber Dukungan</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Input data sumber dukungan berdasarkan peran masing-masing</p>
    </div>

    <!-- Section 1: Kementerian (Wajib) -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between bg-red-50 dark:bg-red-900/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Kementerian</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Puspeka & Inspektorat Jenderal</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">Wajib</span>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sumber Dukungan dari Puspeka</label>
                <textarea id="sd-puspeka" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Jelaskan dukungan dari Puspeka..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bukti Dokumen Puspeka</label>
                <input type="file" id="sd-puspeka-file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sumber Dukungan dari Inspektorat Jenderal</label>
                <textarea id="sd-itjen" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Jelaskan dukungan dari Inspektorat Jenderal..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bukti Dokumen Inspektorat Jenderal</label>
                <input type="file" id="sd-itjen-file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
            </div>
        </div>
    </div>

    <!-- Section 2: Koordinator (Wajib) -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between bg-blue-50 dark:bg-blue-900/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Koordinator</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Kepala Dinas Pendidikan</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">Wajib</span>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sumber Dukungan dari Koordinator</label>
                <textarea id="sd-koordinator" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Jelaskan dukungan dari Kepala Dinas Pendidikan..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bukti Dokumen</label>
                <input type="file" id="sd-koordinator-file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
            </div>
        </div>
    </div>

    <!-- Section 3: Anggota Pokja -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between bg-green-50 dark:bg-green-900/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Anggota Pokja</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Seluruh anggota pokja</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">Semua Anggota</span>
        </div>
        <div class="p-6 space-y-6">
            <?php
            $bidangList = [
                'pendidikan' => 'Bidang Pendidikan',
                'pppa' => 'Bidang PPPA',
                'sosial' => 'Bidang Sosial',
                'kesehatan' => 'Bidang Kesehatan',
                'dukbangga' => 'Bidang Dukbangga',
                'kominfo' => 'Bidang Kominfo',
            ];
            foreach ($bidangList as $key => $label):
            ?>
            <div class="border-b border-gray-100 dark:border-[#3f4739] pb-4 last:border-0 last:pb-0">
                <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2"><?= $label ?></h4>
                <textarea id="sd-<?= $key ?>" rows="2" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none text-sm" placeholder="Sumber dukungan dari <?= $label ?>..."></textarea>
                <input type="file" id="sd-<?= $key ?>-file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="mt-2 w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Section 4: Sekolah -->
    <div class="bg-white dark:bg-[#0F0A0A] rounded-xl border border-gray-200 dark:border-[#3f4739] overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-[#3f4739] flex items-center justify-between bg-yellow-50 dark:bg-yellow-900/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Sekolah</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Kepala Sekolah</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300">Sekolah</span>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sumber Dukungan dari Kepala Sekolah</label>
                <textarea id="sd-sekolah" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#3f4739] rounded-lg bg-white dark:bg-[#1a1414] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Jelaskan dukungan dari Kepala Sekolah..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bukti Dokumen</label>
                <input type="file" id="sd-sekolah-file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100">
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button onclick="saveAllData()" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Semua Data
        </button>
    </div>

    <!-- Save Status -->
    <div id="save-status" class="hidden text-center py-3"></div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const SD_KEY = 'bsan_sumber_dukungan';

    const fields = ['puspeka', 'itjen', 'koordinator', 'pendidikan', 'pppa', 'sosial', 'kesehatan', 'dukbangga', 'kominfo', 'sekolah'];

    function loadData() {
        const saved = JSON.parse(localStorage.getItem(SD_KEY) || '{}');
        fields.forEach(f => {
            const el = document.getElementById('sd-' + f);
            if (el && saved[f]) el.value = saved[f];
        });
    }

    function saveAllData() {
        const data = {};
        const files = {};
        fields.forEach(f => {
            const el = document.getElementById('sd-' + f);
            if (el) data[f] = el.value;
            const fileEl = document.getElementById('sd-' + f + '-file');
            if (fileEl && fileEl.files[0]) files[f] = fileEl.files[0].name;
        });
        data.files = files;
        data.updatedAt = new Date().toISOString();
        localStorage.setItem(SD_KEY, JSON.stringify(data));

        const status = document.getElementById('save-status');
        status.classList.remove('hidden');
        status.innerHTML = '<span class="text-green-600 dark:text-green-400 font-medium">✅ Data sumber dukungan berhasil disimpan!</span>';
        setTimeout(() => status.classList.add('hidden'), 3000);
    }

    $(document).ready(function() { loadData(); });
</script>
<?= $this->endSection() ?>
