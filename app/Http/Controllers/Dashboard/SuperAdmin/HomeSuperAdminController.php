<?php
namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\DashboardController;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin\UserManagementModel;

class HomeSuperAdminController
{
    private $dashboardController;
    private $linkDashboard;
    private $UserModel;

    public function __construct()
    {
        $this->dashboardController = new DashboardController();
        $this->linkDashboard = $this->dashboardController->LinkDashboard();

        $this->UserModel = new UserManagementModel();
    }

    public function Index()
    {
        $notification = Helper::get_flash('notification');
        View::render('dashboard.superadmin.home', [
            'title' => 'Dashboard Home | Praktikum Teknik Sipil ITATS',
            'notification' => $notification,
            'link' => $this->linkDashboard,

            'uid' => $_SESSION['user']['uid'],

            'profilePicture' => $_SESSION['user']['profile_picture'],
            'fullName' => $_SESSION['user']['full_name'],
            'email' => $_SESSION['user']['email'],
            'initials' => $_SESSION['user']['initials'],
            'roleName' => $_SESSION['user']['role_name'],

            'totalUsers' => count($this->UserModel->GetAllUsers()),
        ]);
    }
}
