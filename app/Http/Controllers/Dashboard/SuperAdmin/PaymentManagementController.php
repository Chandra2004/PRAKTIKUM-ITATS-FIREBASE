<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\DashboardController;

class PaymentManagementController
{
    private $dashboardController;
    private $linkDashboard;

    private $receipts = [
        ['No_Kwitansi' => 'REC123456', 'Diterima_dari' => 'John Doe', 'NPM' => '1234567890', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123457', 'Diterima_dari' => 'Jane Doe', 'NPM' => '1234567891', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123458', 'Diterima_dari' => 'Michael Lee', 'NPM' => '1234567892', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123459', 'Diterima_dari' => 'Laura Tan', 'NPM' => '1234567893', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123460', 'Diterima_dari' => 'Rudi Santoso', 'NPM' => '1234567894', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123461', 'Diterima_dari' => 'Dewi Anjani', 'NPM' => '1234567895', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123462', 'Diterima_dari' => 'Budi Gunawan', 'NPM' => '1234567896', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123463', 'Diterima_dari' => 'Intan Permata', 'NPM' => '1234567897', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123464', 'Diterima_dari' => 'Agus Prabowo', 'NPM' => '1234567898', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123465', 'Diterima_dari' => 'Siti Aminah', 'NPM' => '1234567899', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123466', 'Diterima_dari' => 'Kunto Wibowo', 'NPM' => '1234567800', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        // ... data ke-12 sampai ke-24 dengan pola serupa
        ['No_Kwitansi' => 'REC123480', 'Diterima_dari' => 'Nina Prasetyo', 'NPM' => '1234567814', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000'],
        ['No_Kwitansi' => 'REC123481', 'Diterima_dari' => 'Aditya Nugroho', 'NPM' => '1234567815', 'Untuk_Pembayaran' => 'Biaya Praktikum', 'Jumlah' => 'Rp 1.000.000']
    ];

    public function __construct()
    {
        $this->dashboardController = new DashboardController();
        $this->linkDashboard = $this->dashboardController->LinkDashboard();
    }

    public function Index()
    {
        $notification = Helper::get_flash('notification');
        View::render('dashboard.superadmin.payment', [
            'title' => 'Payment Management | Praktikum Teknik Sipil ITATS',
            'notification' => $notification,
            'link' => $this->linkDashboard,

            'uid' => $_SESSION['user']['uid'],
            'profilePicture' => $_SESSION['user']['profile_picture'],
            'fullName' => $_SESSION['user']['full_name'],
            'email' => $_SESSION['user']['email'],
            'initials' => $_SESSION['user']['initials'],
            'roleName' => $_SESSION['user']['role_name'],

            'receipts' => $this->receipts,
        ]);
    }
}
