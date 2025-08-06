<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin;

use DateTime;
use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\DashboardController;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin\CourseManagementModel;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin\ModuleManagementModel;

class ModuleManagementController {
    private $dashboardController;
    private $linkDashboard;
    private $ModuleManagementModel;
    private $CourseManagementModel;

    public function __construct() {
        $this->dashboardController = new DashboardController();
        $this->linkDashboard =$this->dashboardController->LinkDashboard();
        $this->ModuleManagementModel = new ModuleManagementModel();
        $this->CourseManagementModel = new CourseManagementModel();
    }
    
    public function Index() {
        $notification = Helper::get_flash('notification');
        
        View::render('dashboard.superadmin.module', [
            'title' => 'Module Management | Praktikum Teknik Sipil ITATS',
            'notification' => $notification,
            'link' => $this->linkDashboard,
            
            'uid' => $_SESSION['user']['uid'],
            'profilePicture' => $_SESSION['user']['profile_picture'],
            'fullName' => $_SESSION['user']['full_name'],
            'email' => $_SESSION['user']['email'],
            'initials' => $_SESSION['user']['initials'],
            'roleName' => $_SESSION['user']['role_name'],
            
            'coursesList' => $this->CourseManagementModel->GetAllCourses(),
            'modulesList' => $this->ModuleManagementModel->GetAllModules(),
        ]);
    }

    public function ModuleCreate() {
        if (Helper::is_post() && Helper::is_csrf()) {
            $course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_SPECIAL_CHARS);
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
            $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    
            if (empty($course) || empty($title) || empty($date) || empty($location) || empty($description)) {
                return Helper::redirect('/dashboard/superadmin/module-management', 'error', 'all fields must be filled');
            }
    
            try {
                if (!empty($date) && !DateTime::createFromFormat('Y-m-d', $date)) {
                    return Helper::redirect('/dashboard/superadmin/module-management', 'error', 'Format tanggal tidak valid');
                }
    
                $result = $this->ModuleManagementModel->ModuleCreate(
                    $course,
                    $title,
                    $date,
                    $location,
                    $description
                );
    
                $errorMessages = [
                    'required_fields_missing' => 'Praktikum dan judul modul wajib diisi',
                    'invalid_date_format' => 'Format tanggal tidak valid',
                    'module_exists' => 'Modul dengan judul tersebut sudah ada untuk praktikum ini',
                    false => 'Gagal menambahkan modul',
                ];
    
                if (isset($errorMessages[$result])) {
                    return Helper::redirect('/dashboard/superadmin/module-management', 'error', $errorMessages[$result]);
                }
    
                return Helper::redirect('/dashboard/superadmin/module-management', 'success', 'Modul berhasil ditambahkan');
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/module-management', 'error', 'Error: ' . $e->getMessage());
            }
        }

    }

    public function ModuleUpdate($uid) {
        if (Helper::is_post() && Helper::is_csrf()) {
            $course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    
            if (empty($uid) || empty($course) || empty($title) || empty($date) || empty($location) || empty($description)) {
                return Helper::redirect('/dashboard/superadmin/module-management', 'error', 'All fields must be filled');
            }

            try {
                if (!empty($date) && !DateTime::createFromFormat('Y-m-d', $date)) {
                    return Helper::redirect('/dashboard/superadmin/module-management', 'error', 'Format tanggal tidak valid');
                }
    
                $result = $this->ModuleManagementModel->ModuleUpdate(
                    $uid,
                    $course,
                    $title,
                    $date,
                    $location,
                    $description
                );
    
                $errorMessages = [
                    'required_fields_missing' => 'Praktikum dan judul modul wajib diisi',
                    'invalid_date_format' => 'Format tanggal tidak valid',
                    'module_exists' => 'Modul dengan judul tersebut sudah ada untuk praktikum ini',
                    'module_not_found' => 'Modul tidak ditemukan',
                    false => 'Gagal memperbarui modul',
                ];
    
                if (isset($errorMessages[$result])) {
                    return Helper::redirect('/dashboard/superadmin/module-management', 'error', $errorMessages[$result]);
                }
    
                return Helper::redirect('/dashboard/superadmin/module-management', 'success', 'Modul berhasil diperbarui');
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/module-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }

    public function ModuleDelete($uid) {
        if (Helper::is_post() && Helper::is_csrf()) {
            if (empty($uid)) {
                return Helper::redirect('/dashboard/superadmin/module-management', 'error', 'ID modul tidak valid');
            }

            try {
                $result = $this->ModuleManagementModel->ModuleDelete($uid);
    
                $errorMessages = [
                    'module_not_found' => 'Modul tidak ditemukan',
                    false => 'Gagal menghapus modul',
                ];
    
                if (isset($errorMessages[$result])) {
                    return Helper::redirect('/dashboard/superadmin/module-management', 'error', $errorMessages[$result]);
                }
    
                return Helper::redirect('/dashboard/superadmin/module-management', 'success', 'Modul berhasil dihapus');
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/module-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }
}
