<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;

class DashboardController
{
    private $link = '/';
    private $userRole;

    public function __construct() {
        $this->userRole = $_SESSION['user']['role_name'] ?? null;
    }

    public function LinkDashboard() {
        if ($this->userRole == 'Praktikan') {
            return $this->link = '/dashboard/praktikan';
        } else if ($this->userRole == 'SuperAdmin') {
            return $this->link = '/dashboard/superadmin';
        }

        return $this->link;
    }

    // public function praktikanDashboard() {
    //     $notification = Helper::get_flash('notification');
    //     View::render('dashboard.praktikan.home', [
    //         'title' => 'Dashboard Home | Praktikum Teknik Sipil ITATS',
    //         'notification' => $notification,
    //         'link' => $this->LinkDashboard(),
            
    //         'fullName' => $_SESSION['user']['full_name'],
    //         'email' => $_SESSION['user']['email'],
    //         'initials' => $_SESSION['user']['initials'],
    //         'roleName' => $_SESSION['user']['role_name']
    //     ]);
    // }

    // PAGE SUPER ADMIN
    // public function superAdminDashboard() {
    //     $notification = Helper::get_flash('notification');
    //     View::render('dashboard.superadmin.home', [
    //         'title' => 'Dashboard Home | Praktikum Teknik Sipil ITATS',
    //         'notification' => $notification,
    //         'link' => $this->LinkDashboard(),

    //         'fullName' => $_SESSION['user']['full_name'],
    //         'email' => $_SESSION['user']['email'],
    //         'initials' => $_SESSION['user']['initials'],
    //         'roleName' => $_SESSION['user']['role_name']
    //     ]);
    // }

    // public function superAdminDashboardUserManagement() {
    //     View::render('dashboard.superadmin.users', [
    //         'title' => 'Dashboard Home | Praktikum Teknik Sipil ITATS',
    //         'link' => $this->LinkDashboard(),

    //         'fullName' => $_SESSION['user']['full_name'],
    //         'email' => $_SESSION['user']['email'],
    //         'initials' => $_SESSION['user']['initials'],
    //         'roleName' => $_SESSION['user']['role_name']
    //     ]);
    // }
}