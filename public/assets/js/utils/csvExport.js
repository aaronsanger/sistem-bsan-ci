/**
 * CSV Export Utilities
 * Vanilla JavaScript version of csvExport.ts
 */

/**
 * Export Pokja data to CSV file
 * @param {Array} provinsiData - Array of province data
 * @param {Object} options - Export options
 */
function exportPokjaToCSV(provinsiData, options = {}) {
    const {
        includeProvinsi = true,
        includeKabKota = true,
        filename = `data-pokja-lengkap-${new Date().toISOString().split('T')[0]}.csv`
    } = options;

    const csvParts = [];

    // Province data section
    if (includeProvinsi) {
        const provHeaders = ['No', 'Nama Provinsi', 'Status Pokja Provinsi', 'Jumlah Kota/Kab', 'Jumlah Pokja Kota/Kab', 'Persentase'];
        const provRows = provinsiData.map(prov => [
            prov.no,
            prov.nama,
            prov.statusPokja,
            prov.jumlahKotaKab,
            prov.jumlahPokjaKotaKab,
            prov.persentase.toFixed(2) + '%'
        ]);

        csvParts.push('=== DATA POKJA PROVINSI ===');
        csvParts.push('');
        csvParts.push(provHeaders.join(','));
        csvParts.push(...provRows.map(row => row.map(cell => `"${cell}"`).join(',')));
    }

    // Kab/Kota data section
    if (includeKabKota && typeof wilayahData !== 'undefined') {
        const kabHeaders = ['No', 'Nama Provinsi', 'Nama Kab/Kota', 'Status Pokja Kab/Kota', 'Status SK'];
        const kabRows = [];
        let kabNo = 1;

        provinsiData.forEach(prov => {
            const kabupatenList = wilayahData[prov.nama] || [];
            kabupatenList.forEach(kab => {
                const hasPokjaProb = prov.persentase / 100;
                const hasPokja = Math.random() < hasPokjaProb;
                const statusPokja = hasPokja ? "Terbentuk" : (Math.random() < 0.3 ? "Dalam Proses" : "Belum Terbentuk");
                const statusSK = hasPokja ? "Valid" : "-";

                kabRows.push([
                    kabNo++,
                    prov.nama,
                    kab,
                    statusPokja,
                    statusSK
                ]);
            });
        });

        if (includeProvinsi) {
            csvParts.push('');
            csvParts.push('');
        }
        csvParts.push('=== DATA POKJA KABUPATEN/KOTA (514 Wilayah) ===');
        csvParts.push('');
        csvParts.push(kabHeaders.join(','));
        csvParts.push(...kabRows.map(row => row.map(cell => `"${cell}"`).join(',')));
    }

    const csvContent = csvParts.join('\n');
    downloadCSV(csvContent, filename);
}

/**
 * Download CSV content as a file
 * @param {string} content - CSV content
 * @param {string} filename - Download filename
 */
function downloadCSV(content, filename) {
    const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    URL.revokeObjectURL(url);
}

/**
 * Export data as JSON file
 * @param {*} data - Data to export
 * @param {string} filename - Download filename
 */
function exportToJSON(data, filename) {
    const jsonContent = JSON.stringify(data, null, 2);
    const blob = new Blob([jsonContent], { type: 'application/json' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    URL.revokeObjectURL(url);
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        exportPokjaToCSV,
        downloadCSV,
        exportToJSON
    };
}
