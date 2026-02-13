/**
 * Data Generation Utilities
 * Vanilla JavaScript version of dataGenerators.ts
 */

/**
 * Seeded random number generator for consistent data generation
 * @param {number} seed - Seed value for reproducibility
 * @returns {Function} Function that returns random numbers between 0-1
 */
function seededRandom(seed) {
    return function () {
        const x = Math.sin(seed++) * 10000;
        return x - Math.floor(x);
    };
}

/**
 * Pokja roles with their status and institution
 */
const POKJA_ROLES = [
    { statusKeanggotaan: 'Ketua', asalInstansi: 'Sekda' },
    { statusKeanggotaan: 'Wakil Ketua', asalInstansi: 'Bappeda' },
    { statusKeanggotaan: 'Koordinator', asalInstansi: 'Dinas Pendidikan' },
    { statusKeanggotaan: 'Anggota Bidang 1', asalInstansi: 'Dinas Pendidikan' },
    { statusKeanggotaan: 'Anggota Bidang 2', asalInstansi: 'Dinas Kesehatan' },
    { statusKeanggotaan: 'Anggota Bidang 3', asalInstansi: 'Dinas Sosial' },
    { statusKeanggotaan: 'Anggota Bidang 4', asalInstansi: 'Kepolisian' },
    { statusKeanggotaan: 'Anggota Bidang 5', asalInstansi: 'Kejaksaan' },
    { statusKeanggotaan: 'Anggota Bidang 6', asalInstansi: 'Kemenag' }
];

/**
 * Sample names for generating random data
 */
const SAMPLE_NAMES = [
    'Ahmad Wijaya', 'Budi Santoso', 'Citra Dewi', 'Dian Pratama',
    'Eka Putri', 'Fajar Hidayat', 'Gita Sari', 'Hendra Kusuma',
    'Indah Permata', 'Joko Widodo', 'Kartika Sari', 'Lukman Hakim',
    'Maya Anggraini', 'Nurul Huda', 'Oscar Putra', 'Putri Wulandari'
];

/**
 * Get a random name from the sample list
 * @returns {string} Random name
 */
function getRandomName() {
    return SAMPLE_NAMES[Math.floor(Math.random() * SAMPLE_NAMES.length)];
}

/**
 * Generate Anggota data with proper Susunan Pokja roles
 * @returns {Array} Array of AnggotaData objects
 */
function generateAnggota() {
    return POKJA_ROLES.map((role, idx) => ({
        no: idx + 1,
        nama: getRandomName(),
        statusKeanggotaan: role.statusKeanggotaan,
        asalInstansi: role.asalInstansi,
        adminPokja: idx === 2 // Koordinator is admin pokja
    }));
}

/**
 * Generate a random date string in DD-MM-YYYY format
 * @param {number} year - Year for the date (default: 2026)
 * @returns {string} Formatted date string
 */
function generateRandomDate(year = 2026) {
    const day = Math.floor(Math.random() * 28) + 1;
    const month = Math.floor(Math.random() * 12) + 1;
    return `${day.toString().padStart(2, '0')}-${month.toString().padStart(2, '0')}-${year}`;
}

/**
 * Generate end date 4 years after start date
 * @param {string} startDate - Start date in DD-MM-YYYY format
 * @returns {string} End date string
 */
function generateEndDate(startDate) {
    const parts = startDate.split('-');
    const year = parseInt(parts[2]) + 4;
    return `${parts[0]}-${parts[1]}-${year}`;
}

/**
 * Indonesian month names
 */
const INDONESIAN_MONTHS = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

/**
 * Format date for Indonesian display
 * @param {Date|string} date - Date object or string
 * @returns {string} Formatted Indonesian date string
 */
function formatDateIndonesian(date) {
    const d = typeof date === 'string' ? new Date(date) : date;
    const day = d.getDate();
    const month = INDONESIAN_MONTHS[d.getMonth()];
    const year = d.getFullYear();
    return `${day} ${month} ${year}`;
}

/**
 * Get current date formatted for Indonesian display
 * @returns {string} Current date in Indonesian format
 */
function getCurrentDateIndonesian() {
    return formatDateIndonesian(new Date());
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        seededRandom,
        POKJA_ROLES,
        getRandomName,
        generateAnggota,
        generateRandomDate,
        generateEndDate,
        formatDateIndonesian,
        getCurrentDateIndonesian
    };
}
