const hariIndo = [
    "Minggu",
    "Senin",
    "Selasa",
    "Rabu",
    "Kamis",
    "Jumat",
    "Sabtu",
];
const bulanIndo = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

export function Jamhaha(id = "time") {
    // Ambil waktu saat ini di zona waktu Asia/Jakarta
    const now = new Date().toLocaleString("en-US", {
        timeZone: "Asia/Jakarta",
    });
    const date = new Date(now);

    // Ambil bagian tanggal
    const hari = hariIndo[date.getDay()];
    const tanggal = date.getDate();
    const bulan = bulanIndo[date.getMonth()];
    const tahun = date.getFullYear();

    // Ambil waktu
    const jam = String(date.getHours()).padStart(2, "0");
    const menit = String(date.getMinutes()).padStart(2, "0");
    const detik = String(date.getSeconds()).padStart(2, "0");

    // Format akhir
    const formattedString = `${hari}, ${tanggal} ${bulan} ${tahun} - ${jam}.${menit}.${detik}`;

    // Tampilkan
    document.getElementById(id).innerHTML = formattedString;
}
