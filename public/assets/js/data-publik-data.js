/**
 * BSAN Data Publik - Complete Data & Logic
 * Converted from TSX version
 */

// ========================================
// WILAYAH DATA (38 Provinces, 514 Kab/Kota)
// ========================================
const wilayahData = {
    "D.K.I. Jakarta": ["Kab. Adm. Kep. Seribu", "Kota Jakarta Pusat", "Kota Jakarta Utara", "Kota Jakarta Barat", "Kota Jakarta Selatan", "Kota Jakarta Timur"],
    "Jawa Barat": ["Kab. Bogor", "Kab. Sukabumi", "Kab. Cianjur", "Kab. Bandung", "Kab. Garut", "Kab. Tasikmalaya", "Kab. Ciamis", "Kab. Kuningan", "Kab. Cirebon", "Kab. Majalengka", "Kab. Sumedang", "Kab. Indramayu", "Kab. Subang", "Kab. Purwakarta", "Kab. Karawang", "Kab. Bekasi", "Kab. Bandung Barat", "Kab. Pangandaran", "Kota Bogor", "Kota Sukabumi", "Kota Bandung", "Kota Cirebon", "Kota Bekasi", "Kota Depok", "Kota Cimahi", "Kota Tasikmalaya", "Kota Banjar"],
    "Jawa Tengah": ["Kab. Cilacap", "Kab. Banyumas", "Kab. Purbalingga", "Kab. Banjarnegara", "Kab. Kebumen", "Kab. Purworejo", "Kab. Wonosobo", "Kab. Magelang", "Kab. Boyolali", "Kab. Klaten", "Kab. Sukoharjo", "Kab. Wonogiri", "Kab. Karanganyar", "Kab. Sragen", "Kab. Grobogan", "Kab. Blora", "Kab. Rembang", "Kab. Pati", "Kab. Kudus", "Kab. Jepara", "Kab. Demak", "Kab. Semarang", "Kab. Temanggung", "Kab. Kendal", "Kab. Batang", "Kab. Pekalongan", "Kab. Pemalang", "Kab. Tegal", "Kab. Brebes", "Kota Magelang", "Kota Surakarta", "Kota Salatiga", "Kota Semarang", "Kota Pekalongan", "Kota Tegal"],
    "D.I. Yogyakarta": ["Kab. Kulon Progo", "Kab. Bantul", "Kab. Gunungkidul", "Kab. Sleman", "Kota Yogyakarta"],
    "Jawa Timur": ["Kab. Pacitan", "Kab. Ponorogo", "Kab. Trenggalek", "Kab. Tulungagung", "Kab. Blitar", "Kab. Kediri", "Kab. Malang", "Kab. Lumajang", "Kab. Jember", "Kab. Banyuwangi", "Kab. Bondowoso", "Kab. Situbondo", "Kab. Probolinggo", "Kab. Pasuruan", "Kab. Sidoarjo", "Kab. Mojokerto", "Kab. Jombang", "Kab. Nganjuk", "Kab. Madiun", "Kab. Magetan", "Kab. Ngawi", "Kab. Bojonegoro", "Kab. Tuban", "Kab. Lamongan", "Kab. Gresik", "Kab. Bangkalan", "Kab. Sampang", "Kab. Pamekasan", "Kab. Sumenep", "Kota Kediri", "Kota Blitar", "Kota Malang", "Kota Probolinggo", "Kota Pasuruan", "Kota Mojokerto", "Kota Madiun", "Kota Surabaya", "Kota Batu"],
    "Aceh": ["Kab. Aceh Selatan", "Kab. Aceh Tenggara", "Kab. Aceh Timur", "Kab. Aceh Tengah", "Kab. Aceh Barat", "Kab. Aceh Besar", "Kab. Pidie", "Kab. Aceh Utara", "Kab. Simeulue", "Kab. Aceh Singkil", "Kab. Bireuen", "Kab. Aceh Barat Daya", "Kab. Gayo Lues", "Kab. Aceh Jaya", "Kab. Nagan Raya", "Kab. Aceh Tamiang", "Kab. Bener Meriah", "Kab. Pidie Jaya", "Kota Banda Aceh", "Kota Sabang", "Kota Lhokseumawe", "Kota Langsa", "Kota Subulussalam"],
    "Sumatera Utara": ["Kab. Tapanuli Tengah", "Kab. Tapanuli Utara", "Kab. Tapanuli Selatan", "Kab. Nias", "Kab. Langkat", "Kab. Karo", "Kab. Deli Serdang", "Kab. Simalungun", "Kab. Asahan", "Kab. Labuhanbatu", "Kab. Dairi", "Kab. Toba", "Kab. Mandailing Natal", "Kab. Nias Selatan", "Kab. Pakpak Bharat", "Kab. Humbang Hasundutan", "Kab. Samosir", "Kab. Serdang Bedagai", "Kab. Batu Bara", "Kab. Padang Lawas Utara", "Kab. Padang Lawas", "Kab. Labuhanbatu Selatan", "Kab. Labuhanbatu Utara", "Kab. Nias Utara", "Kab. Nias Barat", "Kota Medan", "Kota Pematangsiantar", "Kota Sibolga", "Kota Tanjung Balai", "Kota Binjai", "Kota Tebing Tinggi", "Kota Padang Sidempuan", "Kota Gunungsitoli"],
    "Sumatera Barat": ["Kab. Pesisir Selatan", "Kab. Solok", "Kab. Sijunjung", "Kab. Tanah Datar", "Kab. Padang Pariaman", "Kab. Agam", "Kab. Lima Puluh Kota", "Kab. Pasaman", "Kab. Kepulauan Mentawai", "Kab. Dharmasraya", "Kab. Solok Selatan", "Kab. Pasaman Barat", "Kota Padang", "Kota Solok", "Kota Sawahlunto", "Kota Padang Panjang", "Kota Bukittinggi", "Kota Payakumbuh", "Kota Pariaman"],
    "Riau": ["Kab. Kampar", "Kab. Indragiri Hulu", "Kab. Bengkalis", "Kab. Indragiri Hilir", "Kab. Pelalawan", "Kab. Rokan Hulu", "Kab. Rokan Hilir", "Kab. Siak", "Kab. Kuantan Singingi", "Kab. Kepulauan Meranti", "Kota Pekanbaru", "Kota Dumai"],
    "Jambi": ["Kab. Kerinci", "Kab. Merangin", "Kab. Sarolangun", "Kab. Batanghari", "Kab. Muaro Jambi", "Kab. Tanjung Jabung Barat", "Kab. Tanjung Jabung Timur", "Kab. Bungo", "Kab. Tebo", "Kota Jambi", "Kota Sungai Penuh"],
    "Sumatera Selatan": ["Kab. Ogan Komering Ulu", "Kab. Ogan Komering Ilir", "Kab. Muara Enim", "Kab. Lahat", "Kab. Musi Rawas", "Kab. Musi Banyuasin", "Kab. Banyuasin", "Kab. Ogan Komering Ulu Selatan", "Kab. Ogan Komering Ulu Timur", "Kab. Ogan Ilir", "Kab. Empat Lawang", "Kab. Penukal Abab Lematang Ilir", "Kab. Musi Rawas Utara", "Kota Palembang", "Kota Prabumulih", "Kota Pagar Alam", "Kota Lubuk Linggau"],
    "Bengkulu": ["Kab. Bengkulu Selatan", "Kab. Rejang Lebong", "Kab. Bengkulu Utara", "Kab. Kaur", "Kab. Seluma", "Kab. Mukomuko", "Kab. Lebong", "Kab. Kepahiang", "Kab. Bengkulu Tengah", "Kota Bengkulu"],
    "Lampung": ["Kab. Lampung Selatan", "Kab. Lampung Tengah", "Kab. Lampung Utara", "Kab. Lampung Barat", "Kab. Tulang Bawang", "Kab. Tanggamus", "Kab. Lampung Timur", "Kab. Way Kanan", "Kab. Pesawaran", "Kab. Pringsewu", "Kab. Mesuji", "Kab. Tulang Bawang Barat", "Kab. Pesisir Barat", "Kota Bandar Lampung", "Kota Metro"],
    "Kepulauan Bangka Belitung": ["Kab. Bangka", "Kab. Belitung", "Kab. Bangka Selatan", "Kab. Bangka Tengah", "Kab. Bangka Barat", "Kab. Belitung Timur", "Kota Pangkalpinang"],
    "Kepulauan Riau": ["Kab. Bintan", "Kab. Karimun", "Kab. Natuna", "Kab. Lingga", "Kab. Kepulauan Anambas", "Kota Batam", "Kota Tanjung Pinang"],
    "Banten": ["Kab. Pandeglang", "Kab. Lebak", "Kab. Tangerang", "Kab. Serang", "Kota Tangerang", "Kota Cilegon", "Kota Serang", "Kota Tangerang Selatan"],
    "Bali": ["Kab. Jembrana", "Kab. Tabanan", "Kab. Badung", "Kab. Gianyar", "Kab. Klungkung", "Kab. Bangli", "Kab. Karangasem", "Kab. Buleleng", "Kota Denpasar"],
    "Nusa Tenggara Barat": ["Kab. Lombok Barat", "Kab. Lombok Tengah", "Kab. Lombok Timur", "Kab. Sumbawa", "Kab. Dompu", "Kab. Bima", "Kab. Sumbawa Barat", "Kab. Lombok Utara", "Kota Mataram", "Kota Bima"],
    "Nusa Tenggara Timur": ["Kab. Kupang", "Kab. Timor Tengah Selatan", "Kab. Timor Tengah Utara", "Kab. Belu", "Kab. Alor", "Kab. Flores Timur", "Kab. Sikka", "Kab. Ende", "Kab. Ngada", "Kab. Manggarai", "Kab. Sumba Timur", "Kab. Sumba Barat", "Kab. Lembata", "Kab. Rote Ndao", "Kab. Manggarai Barat", "Kab. Nagekeo", "Kab. Sumba Tengah", "Kab. Sumba Barat Daya", "Kab. Manggarai Timur", "Kab. Sabu Raijua", "Kab. Malaka", "Kota Kupang"],
    "Kalimantan Barat": ["Kab. Sambas", "Kab. Mempawah", "Kab. Sanggau", "Kab. Ketapang", "Kab. Sintang", "Kab. Kapuas Hulu", "Kab. Bengkayang", "Kab. Landak", "Kab. Sekadau", "Kab. Melawi", "Kab. Kayong Utara", "Kab. Kubu Raya", "Kota Pontianak", "Kota Singkawang"],
    "Kalimantan Tengah": ["Kab. Kotawaringin Barat", "Kab. Kotawaringin Timur", "Kab. Kapuas", "Kab. Barito Selatan", "Kab. Barito Utara", "Kab. Katingan", "Kab. Seruyan", "Kab. Sukamara", "Kab. Lamandau", "Kab. Gunung Mas", "Kab. Pulang Pisau", "Kab. Murung Raya", "Kab. Barito Timur", "Kota Palangka Raya"],
    "Kalimantan Selatan": ["Kab. Tanah Laut", "Kab. Kotabaru", "Kab. Banjar", "Kab. Barito Kuala", "Kab. Tapin", "Kab. Hulu Sungai Selatan", "Kab. Hulu Sungai Tengah", "Kab. Hulu Sungai Utara", "Kab. Tabalong", "Kab. Tanah Bumbu", "Kab. Balangan", "Kota Banjarmasin", "Kota Banjarbaru"],
    "Kalimantan Timur": ["Kab. Paser", "Kab. Kutai Kartanegara", "Kab. Berau", "Kab. Kutai Barat", "Kab. Kutai Timur", "Kab. Penajam Paser Utara", "Kab. Mahakam Ulu", "Kota Balikpapan", "Kota Samarinda", "Kota Bontang"],
    "Kalimantan Utara": ["Kab. Bulungan", "Kab. Malinau", "Kab. Nunukan", "Kab. Tana Tidung", "Kota Tarakan"],
    "Sulawesi Utara": ["Kab. Bolaang Mongondow", "Kab. Minahasa", "Kab. Kepulauan Sangihe", "Kab. Kepulauan Talaud", "Kab. Minahasa Selatan", "Kab. Minahasa Utara", "Kab. Minahasa Tenggara", "Kab. Bolaang Mongondow Utara", "Kab. Kep. Siau Tagulandang Biaro", "Kab. Bolaang Mongondow Timur", "Kab. Bolaang Mongondow Selatan", "Kota Manado", "Kota Bitung", "Kota Tomohon", "Kota Kotamobagu"],
    "Sulawesi Tengah": ["Kab. Banggai", "Kab. Poso", "Kab. Donggala", "Kab. Tolitoli", "Kab. Buol", "Kab. Morowali", "Kab. Banggai Kepulauan", "Kab. Parigi Moutong", "Kab. Tojo Una Una", "Kab. Sigi", "Kab. Banggai Laut", "Kab. Morowali Utara", "Kota Palu"],
    "Sulawesi Selatan": ["Kab. Kepulauan Selayar", "Kab. Bulukumba", "Kab. Bantaeng", "Kab. Jeneponto", "Kab. Takalar", "Kab. Gowa", "Kab. Sinjai", "Kab. Bone", "Kab. Maros", "Kab. Pangkajene dan Kepulauan", "Kab. Barru", "Kab. Soppeng", "Kab. Wajo", "Kab. Sidenreng Rappang", "Kab. Pinrang", "Kab. Enrekang", "Kab. Luwu", "Kab. Tana Toraja", "Kab. Luwu Utara", "Kab. Luwu Timur", "Kab. Toraja Utara", "Kota Makassar", "Kota Parepare", "Kota Palopo"],
    "Sulawesi Tenggara": ["Kab. Kolaka", "Kab. Konawe", "Kab. Muna", "Kab. Buton", "Kab. Konawe Selatan", "Kab. Bombana", "Kab. Wakatobi", "Kab. Kolaka Utara", "Kab. Konawe Utara", "Kab. Buton Utara", "Kab. Kolaka Timur", "Kab. Konawe Kepulauan", "Kab. Muna Barat", "Kab. Buton Tengah", "Kab. Buton Selatan", "Kota Kendari", "Kota Bau Bau"],
    "Gorontalo": ["Kab. Gorontalo", "Kab. Boalemo", "Kab. Bone Bolango", "Kab. Pohuwato", "Kab. Gorontalo Utara", "Kota Gorontalo"],
    "Sulawesi Barat": ["Kab. Mamuju", "Kab. Polewali Mandar", "Kab. Majene", "Kab. Mamasa", "Kab. Pasangkayu", "Kab. Mamuju Tengah"],
    "Maluku": ["Kab. Maluku Tengah", "Kab. Maluku Tenggara", "Kab. Kepulauan Tanimbar", "Kab. Buru", "Kab. Seram Bagian Timur", "Kab. Seram Bagian Barat", "Kab. Kepulauan Aru", "Kab. Maluku Barat Daya", "Kab. Buru Selatan", "Kota Ambon", "Kota Tual"],
    "Maluku Utara": ["Kab. Halmahera Barat", "Kab. Halmahera Tengah", "Kab. Halmahera Utara", "Kab. Halmahera Selatan", "Kab. Kepulauan Sula", "Kab. Halmahera Timur", "Kab. Pulau Morotai", "Kab. Pulau Taliabu", "Kota Ternate", "Kota Tidore Kepulauan"],
    "Papua": ["Kab. Jayapura", "Kab. Kepulauan Yapen", "Kab. Biak Numfor", "Kab. Sarmi", "Kab. Keerom", "Kab. Mamberamo Raya", "Kab. Supiori", "Kab. Waropen", "Kota Jayapura"],
    "Papua Barat": ["Kab. Manokwari", "Kab. Manokwari Selatan", "Kab. Pegunungan Arfak", "Kab. Teluk Wondama", "Kab. Teluk Bintuni", "Kab. Fak Fak", "Kab. Kaimana"],
    "Papua Tengah": ["Kab. Nabire", "Kab. Puncak Jaya", "Kab. Paniai", "Kab. Mimika", "Kab. Dogiyai", "Kab. Deiyai", "Kab. Intan Jaya", "Kab. Puncak"],
    "Papua Pegunungan": ["Kab. Jayawijaya", "Kab. Pegunungan Bintang", "Kab. Yahukimo", "Kab. Tolikara", "Kab. Nduga", "Kab. Lanny Jaya", "Kab. Mamberamo Tengah", "Kab. Yalimo"],
    "Papua Selatan": ["Kab. Merauke", "Kab. Boven Digoel", "Kab. Mappi", "Kab. Asmat"],
    "Papua Barat Daya": ["Kab. Sorong", "Kab. Sorong Selatan", "Kab. Raja Ampat", "Kab. Tambrauw", "Kab. Maybrat", "Kota Sorong"]
};

// Random names for generating anggota
const randomNames = ["Ahmad", "Budi", "Candra", "Dewi", "Eko", "Fitri", "Gunawan", "Hendra", "Irwan", "Joko", "Kartini", "Lukman", "Maya", "Nurul", "Oki", "Putu", "Rizki", "Sari", "Taufik", "Wahyu"];
const randomLastNames = ["Wijaya", "Suryanto", "Pratama", "Kusuma", "Hidayat", "Santoso", "Purnomo", "Setiawan", "Hartono", "Susanto"];

// Pokja roles
const pokjaRoles = [
    { statusKeanggotaan: "Ketua", asalInstansi: "Sekretaris Daerah" },
    { statusKeanggotaan: "Wakil Ketua", asalInstansi: "Kepala Bappeda" },
    { statusKeanggotaan: "Koordinator", asalInstansi: "Kepala Dinas Pendidikan" },
    { statusKeanggotaan: "Bidang Pendidikan", asalInstansi: "Dinas Pendidikan" },
    { statusKeanggotaan: "Bidang Kesehatan", asalInstansi: "Dinas Kesehatan" },
    { statusKeanggotaan: "Bidang PPPA", asalInstansi: "Dinas PPPA" },
    { statusKeanggotaan: "Bidang Dukbangga", asalInstansi: "Bappeda" },
    { statusKeanggotaan: "Bidang Sosial", asalInstansi: "Dinas Sosial" },
    { statusKeanggotaan: "Bidang Kominfo", asalInstansi: "Dinas Kominfo" }
];

// ========================================
// HELPER FUNCTIONS
// ========================================

function seededRandom(seed) {
    return function () {
        seed = (seed * 9301 + 49297) % 233280;
        return seed / 233280;
    };
}

function getRandomName() {
    const firstName = randomNames[Math.floor(Math.random() * randomNames.length)];
    const lastName = randomLastNames[Math.floor(Math.random() * randomLastNames.length)];
    return `${firstName} ${lastName}`;
}

function generateNomorSK(index) {
    const randomNum = Math.floor(Math.random() * 900) + 100;
    return `${randomNum}/SK/BSAN/${index}/2026`;
}

function generateTanggalSK() {
    const day = Math.floor(Math.random() * 28) + 1;
    const month = Math.floor(Math.random() * 12) + 1;
    return `${day.toString().padStart(2, '0')}-${month.toString().padStart(2, '0')}-2026`;
}

function generateTanggalBerakhirSK(tanggalSK) {
    const parts = tanggalSK.split('-');
    return `${parts[0]}-${parts[1]}-2030`;
}

function generateAnggota() {
    return pokjaRoles.map((role, idx) => ({
        no: idx + 1,
        nama: getRandomName(),
        statusKeanggotaan: role.statusKeanggotaan,
        asalInstansi: role.asalInstansi,
        adminPokja: idx === 2
    }));
}

// ========================================
// GENERATE KOTA/KAB DATA
// ========================================
function generateKotaKab(provinsiNama, provIdx) {
    const cityList = wilayahData[provinsiNama] || [];
    const random = seededRandom(provIdx * 1000);

    return cityList.map((nama, i) => {
        const hasPokja = random() > 0.15;
        const tanggalSK = generateTanggalSK();
        const tanggalBerakhirSK = hasPokja ? generateTanggalBerakhirSK(tanggalSK) : "-";
        const statusPokja = hasPokja ? (random() > 0.2 ? "Disetujui" : "Pending") : "Belum Ada";
        const statusSK = hasPokja ? "Valid" : "-";

        return {
            no: i + 1,
            nama,
            pokjaKotaKab: hasPokja,
            jumlahAnggota: hasPokja ? 9 : 0,
            anggota: hasPokja ? generateAnggota() : [],
            nomorSK: hasPokja ? generateNomorSK(provIdx * 100 + i) : "-",
            tanggalSK: hasPokja ? tanggalSK : "-",
            tanggalBerakhirSK,
            statusSK,
            statusPokja,
            operatorDinas: hasPokja ? getRandomName() : "-",
            lastUpdate: hasPokja ? `${tanggalSK} ${8 + (i % 10)}:${(10 + (i % 50)).toString().padStart(2, '0')}:00` : "-"
        };
    });
}

// ========================================
// GENERATE PROVINCE DATA
// ========================================
function generateProvinceData() {
    const provinces = [
        { kode: "01", nama: "D.K.I. Jakarta" },
        { kode: "02", nama: "Jawa Barat" },
        { kode: "03", nama: "Jawa Tengah" },
        { kode: "04", nama: "D.I. Yogyakarta" },
        { kode: "05", nama: "Jawa Timur" },
        { kode: "06", nama: "Aceh" },
        { kode: "07", nama: "Sumatera Utara" },
        { kode: "08", nama: "Sumatera Barat" },
        { kode: "09", nama: "Riau" },
        { kode: "10", nama: "Jambi" },
        { kode: "11", nama: "Sumatera Selatan" },
        { kode: "12", nama: "Lampung" },
        { kode: "13", nama: "Kalimantan Barat" },
        { kode: "14", nama: "Kalimantan Tengah" },
        { kode: "15", nama: "Kalimantan Selatan" },
        { kode: "16", nama: "Kalimantan Timur" },
        { kode: "17", nama: "Sulawesi Utara" },
        { kode: "18", nama: "Sulawesi Tengah" },
        { kode: "19", nama: "Sulawesi Selatan" },
        { kode: "20", nama: "Sulawesi Tenggara" },
        { kode: "21", nama: "Maluku" },
        { kode: "22", nama: "Bali" },
        { kode: "23", nama: "Nusa Tenggara Barat" },
        { kode: "24", nama: "Nusa Tenggara Timur" },
        { kode: "25", nama: "Papua" },
        { kode: "26", nama: "Bengkulu" },
        { kode: "27", nama: "Maluku Utara" },
        { kode: "28", nama: "Banten" },
        { kode: "29", nama: "Kepulauan Bangka Belitung" },
        { kode: "30", nama: "Gorontalo" },
        { kode: "31", nama: "Kepulauan Riau" },
        { kode: "32", nama: "Papua Barat" },
        { kode: "33", nama: "Sulawesi Barat" },
        { kode: "34", nama: "Kalimantan Utara" },
        { kode: "36", nama: "Papua Tengah" },
        { kode: "37", nama: "Papua Selatan" },
        { kode: "38", nama: "Papua Pegunungan" },
        { kode: "39", nama: "Papua Barat Daya" }
    ];

    return provinces.map((prov, idx) => {
        const kotaKab = generateKotaKab(prov.nama, idx);
        const jumlahPokja = kotaKab.filter(k => k.pokjaKotaKab).length;
        const random = seededRandom(idx * 500);
        const tanggalSK = generateTanggalSK();
        const tanggalBerakhirSK = generateTanggalBerakhirSK(tanggalSK);
        const statusPokja = random() > 0.3 ? "Disetujui" : "Pending";

        return {
            no: parseInt(prov.kode, 10),
            nama: prov.nama,
            pokjaProvinsi: statusPokja === "Disetujui" ? 1 : 0,
            jumlahKotaKab: kotaKab.length,
            jumlahPokjaKotaKab: jumlahPokja,
            persentase: kotaKab.length > 0 ? (jumlahPokja / kotaKab.length) * 100 : 0,
            statusPokja,
            nomorSK: generateNomorSK(idx),
            tanggalSK,
            tanggalBerakhirSK,
            statusSK: "Valid",
            operatorDinas: getRandomName(),
            lastUpdate: `${tanggalSK} ${8 + (idx % 10)}:${(10 + (idx % 50)).toString().padStart(2, '0')}:00`,
            kotaKab,
            anggota: generateAnggota()
        };
    });
}

// ========================================
// CALCULATE TOTALS
// ========================================
function calculateTotals(provinsiData) {
    const pokjaProvinsi = provinsiData.filter(p => p.statusPokja === "Disetujui").length;
    const jumlahKotaKab = provinsiData.reduce((sum, p) => sum + p.jumlahKotaKab, 0);
    const jumlahPokjaKotaKab = provinsiData.reduce((sum, p) => sum + p.jumlahPokjaKotaKab, 0);
    const persentase = jumlahKotaKab > 0 ? (jumlahPokjaKotaKab / jumlahKotaKab) * 100 : 0;

    return { pokjaProvinsi, jumlahKotaKab, jumlahPokjaKotaKab, persentase };
}
