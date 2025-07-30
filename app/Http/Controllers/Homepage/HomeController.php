<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Homepage;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;

class HomeController {
    private $news = [
        ['id' => 1, 'category' => 'Pengumuman', 'date' => '2025-10-01', 'title' => 'Pendaftaran Jurnal Praktikum', 'excerpt' => 'Pendaftaran jurnal praktikum untuk semester ini telah dibuka. Pastikan submit sebelum deadline!', 'slug' => 'pendaftaran-jurnal-praktikum'],
        ['id' => 2, 'category' => 'Jadwal', 'date' => '2025-09-15', 'title' => 'Jadwal Praktikum Baru', 'excerpt' => 'Jadwal praktikum semester ganjil 2025/2026 telah dirilis. Cek sekarang!', 'slug' => 'jadwal-praktikum-baru'],
        ['id' => 3, 'category' => 'Berita', 'date' => '2025-08-30', 'title' => 'Pelatihan Asisten Baru', 'excerpt' => 'Pelatihan untuk asisten praktikum baru akan diadakan bulan depan. Daftar sekarang!', 'slug' => 'pelatihan-asisten-baru'],
        ['id' => 4, 'category' => 'Pengumuman', 'date' => '2025-08-20', 'title' => 'Perubahan Jadwal Praktikum', 'excerpt' => 'Ada perubahan jadwal praktikum untuk minggu ini. Periksa detailnya sekarang.', 'slug' => 'perubahan-jadwal-praktikum'],
        ['id' => 5, 'category' => 'Berita', 'date' => '2025-08-15', 'title' => 'Seminar Teknik Sipil', 'excerpt' => 'Seminar teknik sipil akan diadakan bulan depan. Jangan lewatkan!', 'slug' => 'seminar-teknik-sipil'],
        ['id' => 6, 'category' => 'Jadwal', 'date' => '2025-08-10', 'title' => 'Ujian Praktikum Akhir', 'excerpt' => 'Ujian praktikum akhir akan diadakan pada akhir bulan ini.', 'slug' => 'ujian-praktikum-akhir'],
        ['id' => 7, 'category' => 'Pengumuman', 'date' => '2025-08-05', 'title' => 'Pendaftaran Asisten', 'excerpt' => 'Pendaftaran asisten praktikum dibuka hingga akhir bulan.', 'slug' => 'pendaftaran-asisten'],
        ['id' => 8, 'category' => 'Berita', 'date' => '2025-07-30', 'title' => 'Pameran Proyek Mahasiswa', 'excerpt' => 'Pameran proyek mahasiswa teknik sipil akan diadakan di kampus.', 'slug' => 'pameran-proyek-mahasiswa'],
        ['id' => 9, 'category' => 'Jadwal', 'date' => '2025-07-25', 'title' => 'Jadwal Lab Baru', 'excerpt' => 'Jadwal lab baru untuk semester ini telah diumumkan.', 'slug' => 'jadwal-lab-baru'],
        ['id' => 10, 'category' => 'Pengumuman', 'date' => '2025-07-20', 'title' => 'Pembaruan SOP Lab', 'excerpt' => 'Standar Operasional Prosedur laboratorium telah diperbarui.', 'slug' => 'pembaruan-sop-lab'],
        ['id' => 11, 'category' => 'Berita', 'date' => '2025-07-15', 'title' => 'Kunjungan Industri', 'excerpt' => 'Kunjungan industri untuk mahasiswa teknik sipil akan diadakan.', 'slug' => 'kunjungan-industri'],
        ['id' => 12, 'category' => 'Jadwal', 'date' => '2025-07-10', 'title' => 'Jadwal Ulang Praktikum', 'excerpt' => 'Jadwal ulang praktikum telah dirilis. Cek sekarang!', 'slug' => 'jadwal-ulang-praktikum'],
        ['id' => 13, 'category' => 'Pengumuman', 'date' => '2025-07-05', 'title' => 'Pendaftaran Workshop', 'excerpt' => 'Workshop teknik sipil dibuka untuk pendaftaran.', 'slug' => 'pendaftaran-workshop'],
        ['id' => 14, 'category' => 'Berita', 'date' => '2025-07-01', 'title' => 'Penghargaan Mahasiswa', 'excerpt' => 'Mahasiswa teknik sipil meraih penghargaan nasional.', 'slug' => 'penghargaan-mahasiswa'],
        ['id' => 15, 'category' => 'Jadwal', 'date' => '2025-06-25', 'title' => 'Jadwal Konsultasi', 'excerpt' => 'Jadwal konsultasi dengan dosen telah diumumkan.', 'slug' => 'jadwal-konsultasi'],
        ['id' => 16, 'category' => 'Pengumuman', 'date' => '2025-06-20', 'title' => 'Pembukaan Lab Baru', 'excerpt' => 'Laboratorium baru telah resmi dibuka untuk mahasiswa.', 'slug' => 'pembukaan-lab-baru'],
        ['id' => 17, 'category' => 'Berita', 'date' => '2025-06-15', 'title' => 'Pelatihan Asisten Lab', 'excerpt' => 'Pelatihan lanjutan untuk asisten lab diadakan minggu ini.', 'slug' => 'pelatihan-asisten-lab'],
        ['id' => 18, 'category' => 'Jadwal', 'date' => '2025-06-10', 'title' => 'Jadwal Praktikum Tambahan', 'excerpt' => 'Jadwal praktikum tambahan telah diumumkan.', 'slug' => 'jadwal-praktikum-tambahan'],
        ['id' => 19, 'category' => 'Pengumuman', 'date' => '2025-06-05', 'title' => 'Pengajuan Proposal Penelitian', 'excerpt' => 'Pengajuan proposal penelitian dibuka hingga akhir bulan.', 'slug' => 'pengajuan-proposal-penelitian'],
        ['id' => 20, 'category' => 'Berita', 'date' => '2025-06-01', 'title' => 'Kompetisi Jembatan', 'excerpt' => 'Mahasiswa teknik sipil ikut kompetisi jembatan nasional.', 'slug' => 'kompetisi-jembatan'],
        ['id' => 21, 'category' => 'Jadwal', 'date' => '2025-05-25', 'title' => 'Jadwal Sidang Praktikum', 'excerpt' => 'Jadwal sidang praktikum akhir telah dirilis.', 'slug' => 'jadwal-sidang-praktikum'],
        ['id' => 22, 'category' => 'Pengumuman', 'date' => '2025-05-20', 'title' => 'Pendaftaran Kompetisi Teknik', 'excerpt' => 'Pendaftaran kompetisi teknik sipil dibuka untuk mahasiswa.', 'slug' => 'pendaftaran-kompetisi-teknik'],
        ['id' => 23, 'category' => 'Berita', 'date' => '2025-05-15', 'title' => 'Kolaborasi Industri', 'excerpt' => 'Program kolaborasi dengan industri teknik sipil dimulai.', 'slug' => 'kolaborasi-industri'],
        ['id' => 24, 'category' => 'Jadwal', 'date' => '2025-05-10', 'title' => 'Jadwal Seminar Lab', 'excerpt' => 'Seminar laboratorium akan diadakan minggu depan.', 'slug' => 'jadwal-seminar-lab'],
        ['id' => 36, 'category' => 'Berita', 'date' => '2025-03-25', 'title' => 'Pameran Inovasi Teknik Sipil', 'excerpt' => 'Pameran inovasi mahasiswa teknik sipil diadakan di kampus utama.', 'slug' => 'pameran-inovasi-teknik-sipil'],
        ['id' => 37, 'category' => 'Jadwal', 'date' => '2025-03-20', 'title' => 'Jadwal Konsultasi Proyek Akhir', 'excerpt' => 'Jadwal konsultasi proyek akhir dengan dosen telah diumumkan.', 'slug' => 'jadwal-konsultasi-proyek-akhir'],
        ['id' => 38, 'category' => 'Pengumuman', 'date' => '2025-03-15', 'title' => 'Pendaftaran Seminar Nasional', 'excerpt' => 'Pendaftaran seminar nasional teknik sipil telah dibuka.', 'slug' => 'pendaftaran-seminar-nasional'],
        ['id' => 39, 'category' => 'Berita', 'date' => '2025-03-10', 'title' => 'Penghargaan Proyek Inovatif', 'excerpt' => 'Tim mahasiswa teknik sipil memenangkan penghargaan proyek inovatif.', 'slug' => 'penghargaan-proyek-inovatif'],
        ['id' => 40, 'category' => 'Jadwal', 'date' => '2025-03-05', 'title' => 'Jadwal Ujian Praktikum', 'excerpt' => 'Jadwal ujian praktikum tengah semester telah dirilis.', 'slug' => 'jadwal-ujian-praktikum'],
        ['id' => 41, 'category' => 'Pengumuman', 'date' => '2025-03-01', 'title' => 'Pembaruan Jadwal Lab', 'excerpt' => 'Jadwal laboratorium untuk bulan ini telah diperbarui.', 'slug' => 'pembaruan-jadwal-lab'],
        ['id' => 42, 'category' => 'Berita', 'date' => '2025-02-25', 'title' => 'Kunjungan ke Proyek Jembatan', 'excerpt' => 'Mahasiswa teknik sipil mengunjungi proyek jembatan besar.', 'slug' => 'kunjungan-ke-proyek-jembatan'],
        ['id' => 43, 'category' => 'Jadwal', 'date' => '2025-02-20', 'title' => 'Jadwal Praktikum Tambahan', 'excerpt' => 'Jadwal praktikum tambahan untuk kelompok tertentu diumumkan.', 'slug' => 'jadwal-praktikum-tambahan'],
        ['id' => 44, 'category' => 'Pengumuman', 'date' => '2025-02-15', 'title' => 'Pendaftaran Magang Industri', 'excerpt' => 'Pendaftaran magang industri untuk mahasiswa dibuka.', 'slug' => 'pendaftaran-magang-industri'],
        ['id' => 45, 'category' => 'Berita', 'date' => '2025-02-10', 'title' => 'Seminar Teknologi Beton', 'excerpt' => 'Seminar tentang teknologi beton diadakan bulan ini.', 'slug' => 'seminar-teknologi-beton'],
        ['id' => 46, 'category' => 'Jadwal', 'date' => '2025-02-05', 'title' => 'Jadwal Sidang Proposal', 'excerpt' => 'Jadwal sidang proposal penelitian mahasiswa telah diumumkan.', 'slug' => 'jadwal-sidang-proposal'],
        ['id' => 47, 'category' => 'Pengumuman', 'date' => '2025-02-01', 'title' => 'Pembaruan Peralatan Lab', 'excerpt' => 'Peralatan laboratorium baru telah tersedia untuk praktikum.', 'slug' => 'pembaruan-peralatan-lab'],
        ['id' => 48, 'category' => 'Berita', 'date' => '2025-01-25', 'title' => 'Kompetisi Desain Struktur', 'excerpt' => 'Mahasiswa teknik sipil ikut kompetisi desain struktur nasional.', 'slug' => 'kompetisi-desain-struktur'],
        ['id' => 49, 'category' => 'Jadwal', 'date' => '2025-01-20', 'title' => 'Jadwal Konsultasi Dosen', 'excerpt' => 'Jadwal konsultasi dengan dosen untuk proyek akhir diumumkan.', 'slug' => 'jadwal-konsultasi-dosen'],
        ['id' => 50, 'category' => 'Pengumuman', 'date' => '2025-01-15', 'title' => 'Pendaftaran Pelatihan CAD', 'excerpt' => 'Pelatihan CAD untuk mahasiswa teknik sipil dibuka.', 'slug' => 'pendaftaran-pelatihan-cad'],
        ['id' => 51, 'category' => 'Berita', 'date' => '2025-01-10', 'title' => 'Pameran Teknologi Konstruksi', 'excerpt' => 'Pameran teknologi konstruksi diadakan di kampus.', 'slug' => 'pameran-teknologi-konstruksi'],
        ['id' => 52, 'category' => 'Jadwal', 'date' => '2025-01-05', 'title' => 'Jadwal Ujian Lab', 'excerpt' => 'Jadwal ujian laboratorium akhir semester telah dirilis.', 'slug' => 'jadwal-ujian-lab'],
        ['id' => 53, 'category' => 'Pengumuman', 'date' => '2025-01-01', 'title' => 'Pendaftaran Asisten Lab Baru', 'excerpt' => 'Pendaftaran asisten laboratorium baru dibuka hingga akhir bulan.', 'slug' => 'pendaftaran-asisten-lab-baru'],
        ['id' => 54, 'category' => 'Berita', 'date' => '2024-12-25', 'title' => 'Penghargaan Desain Jembatan', 'excerpt' => 'Mahasiswa teknik sipil memenangkan penghargaan desain jembatan.', 'slug' => 'penghargaan-desain-jembatan'],
        ['id' => 55, 'category' => 'Jadwal', 'date' => '2024-12-20', 'title' => 'Jadwal Praktikum Semester Genap', 'excerpt' => 'Jadwal praktikum semester genap 2024/2025 telah diumumkan.', 'slug' => 'jadwal-praktikum-semester-genap'],
        ['id' => 56, 'category' => 'Pengumuman', 'date' => '2024-12-15', 'title' => 'Pembaruan SOP Praktikum', 'excerpt' => 'Standar Operasional Prosedur praktikum telah diperbarui.', 'slug' => 'pembaruan-sop-praktikum'],
        ['id' => 57, 'category' => 'Berita', 'date' => '2024-12-10', 'title' => 'Kunjungan ke Proyek Bendungan', 'excerpt' => 'Mahasiswa teknik sipil mengunjungi proyek bendungan besar.', 'slug' => 'kunjungan-ke-proyek-bendungan'],
        ['id' => 58, 'category' => 'Jadwal', 'date' => '2024-12-05', 'title' => 'Jadwal Seminar Teknologi', 'excerpt' => 'Seminar teknologi konstruksi akan diadakan minggu depan.', 'slug' => 'jadwal-seminar-teknologi'],
        ['id' => 59, 'category' => 'Pengumuman', 'date' => '2024-12-01', 'title' => 'Pendaftaran Kompetisi Beton', 'excerpt' => 'Pendaftaran kompetisi beton untuk mahasiswa telah dibuka.', 'slug' => 'pendaftaran-kompetisi-beton'],
        ['id' => 60, 'category' => 'Berita', 'date' => '2024-11-25', 'title' => 'Kolaborasi dengan Perusahaan Konstruksi', 'excerpt' => 'Program kolaborasi dengan perusahaan konstruksi dimulai.', 'slug' => 'kolaborasi-dengan-perusahaan-konstruksi'],
        ['id' => 61, 'category' => 'Jadwal', 'date' => '2024-11-20', 'title' => 'Jadwal Ujian Praktikum Tengah Semester', 'excerpt' => 'Jadwal ujian praktikum tengah semester telah dirilis.', 'slug' => 'jadwal-ujian-praktikum-tengah-semester'],
        ['id' => 62, 'category' => 'Pengumuman', 'date' => '2024-11-15', 'title' => 'Pendaftaran Workshop Struktur', 'excerpt' => 'Workshop struktur baja untuk mahasiswa dibuka.', 'slug' => 'pendaftaran-workshop-struktur'],
        ['id' => 63, 'category' => 'Berita', 'date' => '2024-11-10', 'title' => 'Seminar Teknologi Jalan', 'excerpt' => 'Seminar tentang teknologi konstruksi jalan diadakan bulan ini.', 'slug' => 'seminar-teknologi-jalan'],
        ['id' => 64, 'category' => 'Jadwal', 'date' => '2024-11-05', 'title' => 'Jadwal Konsultasi Proyek', 'excerpt' => 'Jadwal konsultasi proyek dengan dosen telah diumumkan.', 'slug' => 'jadwal-konsultasi-proyek'],
        ['id' => 65, 'category' => 'Pengumuman', 'date' => '2024-11-01', 'title' => 'Pembaruan Alat Uji Lab', 'excerpt' => 'Alat uji laboratorium baru telah tersedia untuk praktikum.', 'slug' => 'pembaruan-alat-uji-lab'],
        ['id' => 66, 'category' => 'Berita', 'date' => '2024-10-25', 'title' => 'Kompetisi Desain Bendungan', 'excerpt' => 'Mahasiswa teknik sipil ikut kompetisi desain bendungan nasional.', 'slug' => 'kompetisi-desain-bendungan'],
        ['id' => 67, 'category' => 'Jadwal', 'date' => '2024-10-20', 'title' => 'Jadwal Sidang Penelitian', 'excerpt' => 'Jadwal sidang penelitian mahasiswa telah diumumkan.', 'slug' => 'jadwal-sidang-penelitian'],
        ['id' => 68, 'category' => 'Pengumuman', 'date' => '2024-10-15', 'title' => 'Pendaftaran Pelatihan BIM', 'excerpt' => 'Pelatihan Building Information Modeling dibuka untuk mahasiswa.', 'slug' => 'pendaftaran-pelatihan-bim'],
        ['id' => 69, 'category' => 'Berita', 'date' => '2024-10-10', 'title' => 'Pameran Proyek Inovasi', 'excerpt' => 'Pameran proyek inovasi mahasiswa teknik sipil diadakan.', 'slug' => 'pameran-proyek-inovasi'],
        ['id' => 70, 'category' => 'Jadwal', 'date' => '2024-10-05', 'title' => 'Jadwal Praktikum Khusus', 'excerpt' => 'Jadwal praktikum khusus untuk kelompok tertentu diumumkan.', 'slug' => 'jadwal-praktikum-khusus'],
        ['id' => 71, 'category' => 'Pengumuman', 'date' => '2024-10-01', 'title' => 'Pendaftaran Asisten Baru', 'excerpt' => 'Pendaftaran asisten laboratorium baru dibuka hingga akhir bulan.', 'slug' => 'pendaftaran-asisten-baru'],
        ['id' => 72, 'category' => 'Berita', 'date' => '2024-09-25', 'title' => 'Penghargaan Kompetisi Struktur', 'excerpt' => 'Mahasiswa teknik sipil memenangkan kompetisi struktur nasional.', 'slug' => 'penghargaan-kompetisi-struktur'],
        ['id' => 73, 'category' => 'Jadwal', 'date' => '2024-09-20', 'title' => 'Jadwal Ujian Lab Akhir', 'excerpt' => 'Jadwal ujian laboratorium akhir semester telah dirilis.', 'slug' => 'jadwal-ujian-lab-akhir'],
        ['id' => 74, 'category' => 'Pengumuman', 'date' => '2024-09-15', 'title' => 'Pembaruan Jadwal Praktikum', 'excerpt' => 'Jadwal praktikum untuk bulan ini telah diperbarui.', 'slug' => 'pembaruan-jadwal-praktikum'],
        ['id' => 75, 'category' => 'Berita', 'date' => '2024-09-10', 'title' => 'Kunjungan ke Proyek Terowongan', 'excerpt' => 'Mahasiswa teknik sipil mengunjungi proyek terowongan besar.', 'slug' => 'kunjungan-ke-proyek-terowongan'],
        ['id' => 76, 'category' => 'Jadwal', 'date' => '2024-09-05', 'title' => 'Jadwal Seminar Konstruksi', 'excerpt' => 'Seminar konstruksi berkelanjutan diadakan minggu depan.', 'slug' => 'jadwal-seminar-konstruksi'],
        ['id' => 77, 'category' => 'Pengumuman', 'date' => '2024-09-01', 'title' => 'Pendaftaran Kompetisi Desain', 'excerpt' => 'Pendaftaran kompetisi desain struktur untuk mahasiswa dibuka.', 'slug' => 'pendaftaran-kompetisi-desain'],
        ['id' => 78, 'category' => 'Berita', 'date' => '2024-08-25', 'title' => 'Kolaborasi dengan Industri Jalan', 'excerpt' => 'Program kolaborasi dengan industri konstruksi jalan dimulai.', 'slug' => 'kolaborasi-dengan-industri-jalan'],
        ['id' => 79, 'category' => 'Jadwal', 'date' => '2024-08-20', 'title' => 'Jadwal Konsultasi Penelitian', 'excerpt' => 'Jadwal konsultasi penelitian dengan dosen diumumkan.', 'slug' => 'jadwal-konsultasi-penelitian'],
        ['id' => 80, 'category' => 'Pengumuman', 'date' => '2024-08-15', 'title' => 'Pembaruan Peralatan Lab', 'excerpt' => 'Peralatan laboratorium baru telah tersedia untuk praktikum.', 'slug' => 'pembaruan-peralatan-lab'],
        ['id' => 81, 'category' => 'Berita', 'date' => '2024-08-10', 'title' => 'Seminar Teknologi Struktur', 'excerpt' => 'Seminar teknologi struktur baja diadakan bulan ini.', 'slug' => 'seminar-teknologi-struktur'],
        ['id' => 82, 'category' => 'Jadwal', 'date' => '2024-08-05', 'title' => 'Jadwal Sidang Akhir', 'excerpt' => 'Jadwal sidang akhir mahasiswa telah diumumkan.', 'slug' => 'jadwal-sidang-akhir'],
        ['id' => 83, 'category' => 'Pengumuman', 'date' => '2024-08-01', 'title' => 'Pendaftaran Pelatihan Software', 'excerpt' => 'Pelatihan software teknik sipil dibuka untuk mahasiswa.', 'slug' => 'pendaftaran-pelatihan-software'],
        ['id' => 84, 'category' => 'Berita', 'date' => '2024-07-25', 'title' => 'Pameran Proyek Mahasiswa', 'excerpt' => 'Pameran proyek mahasiswa teknik sipil diadakan di kampus.', 'slug' => 'pameran-proyek-mahasiswa'],
        ['id' => 85, 'category' => 'Jadwal', 'date' => '2024-07-20', 'title' => 'Jadwal Praktikum Semester Baru', 'excerpt' => 'Jadwal praktikum semester baru telah diumumkan.', 'slug' => 'jadwal-praktikum-semester-baru'],
        ['id' => 86, 'category' => 'Pengumuman', 'date' => '2024-07-15', 'title' => 'Pendaftaran Magang Teknik', 'excerpt' => 'Pendaftaran magang teknik untuk mahasiswa dibuka.', 'slug' => 'pendaftaran-magang-teknik'],
        ['id' => 87, 'category' => 'Berita', 'date' => '2024-07-10', 'title' => 'Kompetisi Desain Jalan', 'excerpt' => 'Mahasiswa teknik sipil ikut kompetisi desain jalan nasional.', 'slug' => 'kompetisi-desain-jalan'],
        ['id' => 88, 'category' => 'Jadwal', 'date' => '2024-07-05', 'title' => 'Jadwal Ujian Praktikum', 'excerpt' => 'Jadwal ujian praktikum tengah semester telah dirilis.', 'slug' => 'jadwal-ujian-praktikum'],
        ['id' => 89, 'category' => 'Pengumuman', 'date' => '2024-07-01', 'title' => 'Pembaruan SOP Lab', 'excerpt' => 'Standar Operasional Prosedur laboratorium telah diperbarui.', 'slug' => 'pembaruan-sop-lab'],
        ['id' => 90, 'category' => 'Berita', 'date' => '2024-06-25', 'title' => 'Kunjungan ke Proyek Gedung', 'excerpt' => 'Mahasiswa teknik sipil mengunjungi proyek gedung bertingkat.', 'slug' => 'kunjungan-ke-proyek-gedung'],
        ['id' => 91, 'category' => 'Jadwal', 'date' => '2024-06-20', 'title' => 'Jadwal Seminar Lab Baru', 'excerpt' => 'Seminar laboratorium baru akan diadakan minggu depan.', 'slug' => 'jadwal-seminar-lab-baru'],
        ['id' => 92, 'category' => 'Pengumuman', 'date' => '2024-06-15', 'title' => 'Pendaftaran Workshop Beton', 'excerpt' => 'Workshop teknologi beton untuk mahasiswa dibuka.', 'slug' => 'pendaftaran-workshop-beton'],
        ['id' => 93, 'category' => 'Berita', 'date' => '2024-06-10', 'title' => 'Penghargaan Proyek Mahasiswa', 'excerpt' => 'Mahasiswa teknik sipil memenangkan penghargaan proyek nasional.', 'slug' => 'penghargaan-proyek-mahasiswa'],
        ['id' => 94, 'category' => 'Jadwal', 'date' => '2024-06-05', 'title' => 'Jadwal Konsultasi Dosen', 'excerpt' => 'Jadwal konsultasi dengan dosen untuk proyek diumumkan.', 'slug' => 'jadwal-konsultasi-dosen'],
        ['id' => 95, 'category' => 'Pengumuman', 'date' => '2024-06-01', 'title' => 'Pembaruan Alat Lab', 'excerpt' => 'Alat laboratorium baru telah tersedia untuk praktikum.', 'slug' => 'pembaruan-alat-lab'],
        ['id' => 96, 'category' => 'Berita', 'date' => '2024-05-25', 'title' => 'Seminar Konstruksi Berkelanjutan', 'excerpt' => 'Seminar tentang konstruksi berkelanjutan diadakan bulan ini.', 'slug' => 'seminar-konstruksi-berkelanjutan'],
        ['id' => 97, 'category' => 'Jadwal', 'date' => '2024-05-20', 'title' => 'Jadwal Sidang Penelitian', 'excerpt' => 'Jadwal sidang penelitian mahasiswa telah diumumkan.', 'slug' => 'jadwal-sidang-penelitian'],
        ['id' => 98, 'category' => 'Pengumuman', 'date' => '2024-05-15', 'title' => 'Pendaftaran Pelatihan Struktur', 'excerpt' => 'Pelatihan struktur baja untuk mahasiswa dibuka.', 'slug' => 'pendaftaran-pelatihan-struktur'],
        ['id' => 99, 'category' => 'Berita', 'date' => '2024-05-10', 'title' => 'Kompetisi Desain Gedung', 'excerpt' => 'Mahasiswa teknik sipil ikut kompetisi desain gedung nasional.', 'slug' => 'kompetisi-desain-gedung'],
        ['id' => 100, 'category' => 'Jadwal', 'date' => '2024-05-05', 'title' => 'Jadwal Praktikum Tambahan', 'excerpt' => 'Jadwal praktikum tambahan untuk kelompok tertentu diumumkan.', 'slug' => 'jadwal-praktikum-tambahan'],
        ['id' => 101, 'category' => 'Pengumuman', 'date' => '2024-05-01', 'title' => 'Pendaftaran Asisten Lab', 'excerpt' => 'Pendaftaran asisten laboratorium dibuka hingga akhir bulan.', 'slug' => 'pendaftaran-asisten-lab'],
        ['id' => 102, 'category' => 'Berita', 'date' => '2024-04-25', 'title' => 'Pameran Teknologi Sipil', 'excerpt' => 'Pameran teknologi sipil diadakan di kampus utama.', 'slug' => 'pameran-teknologi-sipil'],
        ['id' => 103, 'category' => 'Jadwal', 'date' => '2024-04-20', 'title' => 'Jadwal Ujian Lab Akhir', 'excerpt' => 'Jadwal ujian laboratorium akhir semester telah dirilis.', 'slug' => 'jadwal-ujian-lab-akhir'],
        ['id' => 104, 'category' => 'Pengumuman', 'date' => '2024-04-15', 'title' => 'Pembaruan Jadwal Lab', 'excerpt' => 'Jadwal laboratorium untuk bulan ini telah diperbarui.', 'slug' => 'pembaruan-jadwal-lab'],
        ['id' => 105, 'category' => 'Berita', 'date' => '2024-04-10', 'title' => 'Kunjungan ke Proyek Jalan Tol', 'excerpt' => 'Mahasiswa teknik sipil mengunjungi proyek jalan tol besar.', 'slug' => 'kunjungan-ke-proyek-jalan-tol'],
        ['id' => 106, 'category' => 'Jadwal', 'date' => '2024-04-05', 'title' => 'Jadwal Seminar Teknologi', 'excerpt' => 'Seminar teknologi konstruksi diadakan minggu depan.', 'slug' => 'jadwal-seminar-teknologi'],
        ['id' => 107, 'category' => 'Pengumuman', 'date' => '2024-04-01', 'title' => 'Pendaftaran Kompetisi Struktur', 'excerpt' => 'Pendaftaran kompetisi struktur untuk mahasiswa dibuka.', 'slug' => 'pendaftaran-kompetisi-struktur'],
        ['id' => 108, 'category' => 'Berita', 'date' => '2024-03-25', 'title' => 'Kolaborasi dengan Industri Bendungan', 'excerpt' => 'Program kolaborasi dengan industri bendungan dimulai.', 'slug' => 'kolaborasi-dengan-industri-bendungan'],
        ['id' => 109, 'category' => 'Jadwal', 'date' => '2024-03-20', 'title' => 'Jadwal Konsultasi Proyek', 'excerpt' => 'Jadwal konsultasi proyek dengan dosen telah diumumkan.', 'slug' => 'jadwal-konsultasi-proyek'],
        ['id' => 110, 'category' => 'Pengumuman', 'date' => '2024-03-15', 'title' => 'Pembaruan Peralatan Lab', 'excerpt' => 'Peralatan laboratorium baru telah tersedia untuk praktikum.', 'slug' => 'pembaruan-peralatan-lab'],
    ];

    public function __construct() {
    }

    // VIEW HOMEPAGE
    public function Index() {
        $news = $this->news;
        $notification = Helper::get_flash('notification');

        $perPage = 3;
        $currentPage = (int) 1;
        $currentPage = max(1, min($currentPage, 1));
        $offset = ($currentPage - 1) * $perPage;
        $paginatedNews = array_slice($news, $offset, $perPage);

        $userRole = isset($_SESSION['user']['role_name']) ? $_SESSION['user']['role_name'] : null;
        $link = '/login';

        if($userRole == 'Praktikan') {
            $link = '/dashboard/praktikan';
        } else if($userRole == 'SuperAdmin') {
            $link = '/dashboard/superadmin';
        }

        View::render('homepage.home', [
            'userRole' => $userRole,
            'link' => $link,
            'notification' => $notification,
            'title' => 'Welcome | Lab Praktikum Teknik Sipil',
            'news' => $paginatedNews
        ]);
    }
}
