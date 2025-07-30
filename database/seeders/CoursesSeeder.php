<?php

// namespace Database\Seeders;

// use ITATS\PraktikumTeknikSipil\App\Config;
// use Defuse\Crypto\Crypto;
// use Defuse\Crypto\Key;
// use Faker\Factory;
// use ITATS\PraktikumTeknikSipil\Helpers\Helper;
// use ITATS\PraktikumTeknikSipil\Models\Seeders\Courses;

// class CoursesSeeder {
//     public function run()
//     {
//         $courses = [
//             [
//                 'kode_praktikum' => 'UB',
//                 'judul_praktikum' => 'Uji Bahan 1',
//                 'deskripsi_praktikum' => 'Mempelajari dan menguji sifat-sifat mekanik berbagai material konstruksi seperti beton, baja, dan kayu.',
//                 'owner_praktikum' => 'SWjtFccjC7', // contoh UID dari Ketua Lab
//             ],
//             [
//                 'kode_praktikum' => 'TK',
//                 'judul_praktikum' => 'Teknologi Konstruksi',
//                 'deskripsi_praktikum' => 'Pembahasan teknik konstruksi modern, termasuk metode pelaksanaan dan efisiensi struktur.',
//                 'owner_praktikum' => 'pY6FXnJj4P',
//             ],
//             [
//                 'kode_praktikum' => 'SHM',
//                 'judul_praktikum' => 'Struktur Homogen Material',
//                 'deskripsi_praktikum' => 'Analisis material homogen dan uji kekuatan tekan serta tarik.',
//                 'owner_praktikum' => 'QvnNeZJlxV',
//             ],
//             [
//                 'kode_praktikum' => 'BMB',
//                 'judul_praktikum' => 'Beton Mutu Baik',
//                 'deskripsi_praktikum' => 'Praktikum desain campuran beton dan pengujian slump serta kuat tekan.',
//                 'owner_praktikum' => 'azJw5fNCEX',
//             ],
//             [
//                 'kode_praktikum' => 'LAB',
//                 'judul_praktikum' => 'Laboratorium Bahan',
//                 'deskripsi_praktikum' => 'Pengenalan alat ukur, pengujian kekasaran permukaan dan sifat mekanik.',
//                 'owner_praktikum' => 'SWjtFccjC7',
//             ]
//         ];

//         foreach ($courses as &$course) {
//             $course['uid'] = Helper::generateUUID(10);
//             Courses::create($course);
//         }
//     }
// }
