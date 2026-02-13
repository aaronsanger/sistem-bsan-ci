/**
 * data-publik.js - Data Publik page logic
 * Handles table, chart and map views for the Data Publik page
 */
(function () {
    'use strict';

    let provinsiDT, kotkabDT;
    let chartStatus, chartAnggota;
    let map, markers = [];
    let currentProvince = null;

    // Generate demo data from wilayahData
    function generateProvinsiData() {
        const data = [];
        const provinces = Object.keys(wilayahData);
        provinces.forEach((prov, i) => {
            const cities = wilayahData[prov];
            const totalAnggota = Math.floor(Math.random() * 50) + 10;
            const hasSK = Math.random() > 0.5;
            const operatorName = generateRandomName();

            data.push({
                no: i + 1,
                provinsi: prov,
                jumlahKotkab: cities.length,
                totalAnggota,
                statusSK: hasSK ? 'Sudah' : 'Belum',
                operator: operatorName,
                cities: cities.map((city, j) => {
                    const cityHasSK = Math.random() > 0.4;
                    return {
                        no: j + 1,
                        nama: city,
                        nomorSK: cityHasSK ? generateRandomSK() : '-',
                        tanggalSK: cityHasSK ? '2026-01-15' : '-',
                        berakhirSK: cityHasSK ? '2030-01-15' : '-',
                        statusSK: cityHasSK ? 'Aktif' : 'Belum',
                        totalAnggota: Math.floor(Math.random() * 20) + 5,
                        operator: generateRandomName(),
                    };
                }),
            });
        });
        return data;
    }

    const allData = generateProvinsiData();

    // ============ TABLE VIEW ============

    function renderProvinsiTable() {
        let html = '';
        allData.forEach(p => {
            const statusClass = p.statusSK === 'Sudah'
                ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
            html += `<tr class="border-b dark:border-[#3f4739] hover:bg-gray-50 dark:hover:bg-[#1a1414]">
                <td class="px-4 py-3 dark:text-gray-300">${p.no}</td>
                <td class="px-4 py-3 font-medium dark:text-white">${p.provinsi}</td>
                <td class="px-4 py-3 text-center dark:text-gray-300">${p.jumlahKotkab}</td>
                <td class="px-4 py-3 text-center dark:text-gray-300">${p.totalAnggota}</td>
                <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-medium ${statusClass}">${p.statusSK}</span></td>
                <td class="px-4 py-3 text-center dark:text-gray-300">${p.operator}</td>
                <td class="px-4 py-3 text-center">
                    <button onclick="showKotkab('${p.provinsi}')" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">Lihat</button>
                </td>
            </tr>`;
        });
        $('#provinsi-tbody').html(html);
        provinsiDT = $('#provinsi-table').DataTable({
            pageLength: 10,
            order: [[0, 'asc']],
            language: { url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/id.json' },
        });
    }

    window.showKotkab = function (provinceName) {
        currentProvince = provinceName;
        const prov = allData.find(p => p.provinsi === provinceName);
        if (!prov) return;

        if (kotkabDT) { kotkabDT.destroy(); kotkabDT = null; }

        $('#kotkab-title').text(provinceName);
        let html = '';
        prov.cities.forEach(c => {
            const statusClass = c.statusSK === 'Aktif'
                ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
            html += `<tr class="border-b dark:border-[#3f4739] hover:bg-gray-50 dark:hover:bg-[#1a1414]">
                <td class="px-4 py-3 dark:text-gray-300">${c.no}</td>
                <td class="px-4 py-3 font-medium dark:text-white">${c.nama}</td>
                <td class="px-4 py-3 text-center dark:text-gray-300">${c.nomorSK}</td>
                <td class="px-4 py-3 text-center dark:text-gray-300">${c.tanggalSK}</td>
                <td class="px-4 py-3 text-center dark:text-gray-300">${c.berakhirSK}</td>
                <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-medium ${statusClass}">${c.statusSK}</span></td>
                <td class="px-4 py-3 text-center dark:text-gray-300">${c.totalAnggota}</td>
                <td class="px-4 py-3 text-center dark:text-gray-300">${c.operator}</td>
                <td class="px-4 py-3 text-center">
                    <button class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Detail</button>
                </td>
            </tr>`;
        });
        $('#kotkab-tbody').html(html);
        kotkabDT = $('#kotkab-table').DataTable({
            pageLength: 10,
            order: [[0, 'asc']],
            language: { url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/id.json' },
        });
        $('#kotkab-section').removeClass('hidden');
        $('#kotkab-section')[0].scrollIntoView({ behavior: 'smooth' });
    };

    window.closeKotkab = function () {
        $('#kotkab-section').addClass('hidden');
        currentProvince = null;
    };

    // ============ CHART VIEW ============

    function renderCharts() {
        const sudah = allData.filter(p => p.statusSK === 'Sudah').length;
        const belum = allData.filter(p => p.statusSK === 'Belum').length;

        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#e5e7eb' : '#374151';

        // Status Donut
        const ctxStatus = document.getElementById('chart-status').getContext('2d');
        if (chartStatus) chartStatus.destroy();
        chartStatus = new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Sudah SK', 'Belum SK'],
                datasets: [{
                    data: [sudah, belum],
                    backgroundColor: ['#22c55e', '#ef4444'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { color: textColor } },
                },
            },
        });

        // Anggota Bar
        const top10 = [...allData].sort((a, b) => b.totalAnggota - a.totalAnggota).slice(0, 10);
        const ctxAnggota = document.getElementById('chart-anggota').getContext('2d');
        if (chartAnggota) chartAnggota.destroy();
        chartAnggota = new Chart(ctxAnggota, {
            type: 'bar',
            data: {
                labels: top10.map(p => p.provinsi),
                datasets: [{
                    label: 'Jumlah Anggota',
                    data: top10.map(p => p.totalAnggota),
                    backgroundColor: '#3b82f6',
                    borderRadius: 4,
                }],
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: textColor }, grid: { color: isDark ? '#3f4739' : '#e5e7eb' } },
                    y: { ticks: { color: textColor }, grid: { display: false } },
                },
            },
        });
    }

    // ============ MAP VIEW ============

    function renderMap() {
        if (map) return; // already initialized
        map = L.map('map').setView([-2.5, 118.0], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(map);

        allData.forEach(p => {
            const coords = provinceCoords[p.provinsi];
            if (!coords) return;

            const color = p.statusSK === 'Sudah' ? '#22c55e' : '#ef4444';
            const marker = L.circleMarker(coords, {
                radius: 8,
                fillColor: color,
                color: '#fff',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.8,
            }).addTo(map);

            marker.bindPopup(`
                <div style="min-width:180px;">
                    <b>${p.provinsi}</b><br>
                    Kota/Kab: ${p.jumlahKotkab}<br>
                    Anggota: ${p.totalAnggota}<br>
                    Status SK: <span style="color:${color};font-weight:bold;">${p.statusSK}</span>
                </div>
            `);

            markers.push(marker);
        });
    }

    // ============ VIEW SWITCHING ============

    window.setView = function (view) {
        ['table', 'chart', 'map'].forEach(v => {
            const el = document.getElementById('view-' + v);
            const btn = document.getElementById('btn-' + v);
            if (v === view) {
                el.classList.remove('hidden');
                btn.classList.add('bg-blue-700', 'text-white');
                btn.classList.remove('bg-gray-100', 'dark:bg-[#1a1414]', 'text-gray-600', 'dark:text-gray-300');
            } else {
                el.classList.add('hidden');
                btn.classList.remove('bg-blue-700', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-600');
            }
        });

        if (view === 'chart') renderCharts();
        if (view === 'map') {
            setTimeout(() => {
                renderMap();
                map.invalidateSize();
            }, 100);
        }
    };

    // ============ EXPORT CSV ============

    window.exportCSV = function (type) {
        let csv = '';
        if (type === 'provinsi') {
            csv = 'No,Provinsi,Jumlah Kota/Kab,Total Anggota,Status SK,Operator\n';
            allData.forEach(p => {
                csv += `${p.no},"${p.provinsi}",${p.jumlahKotkab},${p.totalAnggota},"${p.statusSK}","${p.operator}"\n`;
            });
        } else if (type === 'kotkab' && currentProvince) {
            const prov = allData.find(p => p.provinsi === currentProvince);
            if (!prov) return;
            csv = 'No,Kota/Kabupaten,Nomor SK,Tanggal SK,Berakhir SK,Status SK,Total Anggota,Operator\n';
            prov.cities.forEach(c => {
                csv += `${c.no},"${c.nama}","${c.nomorSK}","${c.tanggalSK}","${c.berakhirSK}","${c.statusSK}",${c.totalAnggota},"${c.operator}"\n`;
            });
        }

        const blob = new Blob([csv], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `data-${type}-${new Date().toISOString().slice(0, 10)}.csv`;
        a.click();
        URL.revokeObjectURL(url);
    };

    // ============ SUMMARY STATS ============

    function updateStats() {
        const sudah = allData.filter(p => p.statusSK === 'Sudah').length;
        const belum = allData.filter(p => p.statusSK === 'Belum').length;
        const totalKotkab = allData.reduce((sum, p) => sum + p.jumlahKotkab, 0);

        $('#total-prov').text(allData.length);
        $('#total-kotkab').text(totalKotkab);
        $('#total-formed').text(sudah);
        $('#total-unformed').text(belum);
    }

    // ============ INIT ============

    $(document).ready(function () {
        renderProvinsiTable();
        updateStats();
    });

})();
