<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin;

use DateTime;
use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\DashboardController;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin\CourseManagementModel;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin\ModuleManagementModel;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin\SessionManagementModel;

class CourseManagementController {
    private $dashboardController;
    private $linkDashboard;
    private $CourseManagementModel;
    private $SessionManagementModel;
    private $ModuleManagementModel;

    public function __construct() {
        $this->dashboardController = new DashboardController();
        $this->linkDashboard = $this->dashboardController->LinkDashboard();
        $this->CourseManagementModel = new CourseManagementModel();
        $this->SessionManagementModel = new SessionManagementModel();
        $this->ModuleManagementModel = new ModuleManagementModel();
    }

    public function Index() {
        $notification = Helper::get_flash('notification');

        $page = '';
        if($_SESSION['user']['role_name'] == 'SuperAdmin') {
            $page = 'dashboard.superadmin.course';
        } else if($_SESSION['user']['role_name'] == 'Praktikan') {
            $page = 'dashboard.praktikan.course';
        }

        View::render($page, [
            'title' => 'Courses Management | Praktikum Teknik Sipil ITATS',
            'notification' => $notification,
            'link' => $this->linkDashboard,

            'uid' => $_SESSION['user']['uid'],
            'profilePicture' => $_SESSION['user']['profile_picture'],
            'fullName' => $_SESSION['user']['full_name'],
            'email' => $_SESSION['user']['email'],
            'initials' => $_SESSION['user']['initials'],
            'roleName' => $_SESSION['user']['role_name'],

            'userSuperAdmins' => $this->CourseManagementModel->GetSuperAdmins(),
            'coursesList' => $this->CourseManagementModel->GetAllCourses(),
            'sessionsList' => $this->SessionManagementModel->GetAllSessions(),
            'modulesList' => $this->ModuleManagementModel->GetAllModules(),
        ]);
    }

    public function CourseCreate() {
        if(Helper::is_post() && Helper::is_csrf()) {
            $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS);
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

            if(empty($code) || empty($title) || empty($creator) || empty($description)) {
                return Helper::redirect('/dashboard/superadmin/course-management', 'error', 'All fields must be fill');
            }
            
            try {
                $result = $this->CourseManagementModel->CourseCreate(
                    $code,
                    $title,
                    $creator,
                    $description
                );
    
                $errorMessages = [
                    'code_exists' => 'Code praktikum sudah ada',
                    'title_exists' => 'Judul praktikum sudah ada',
                    false => 'Gagal menambahkan praktikum',
                ];
    
                if (isset($errorMessages[$result])) {
                    $msg = $errorMessages[$result];
                    return Helper::redirect('/dashboard/superadmin/course-management', 'error', $msg);
                }
    
                return Helper::redirect('/dashboard/superadmin/course-management', 'success', 'Praktikum berhasil ditambahkan');
    
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/course-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }

    public function CourseUpdate($uidcourse) {
        if(Helper::is_post() && Helper::is_csrf()) {
            $uid = $uidcourse;
            $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $creator = filter_input(INPUT_POST, 'creator', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    
            if(empty($code) || empty($title) || empty($creator) || empty($description)) {
                return Helper::redirect('/dashboard/superadmin/course-management', 'error', 'All fields must be fill');
            }
            
            try {
                $result = $this->CourseManagementModel->CourseUpdate(
                    $uid,
                    $code,
                    $title,
                    $creator,
                    $description
                );
    
                $errorMessages = [
                    'code_exists' => 'Code praktikum sudah ada',
                    'title_exists' => 'Judul praktikum sudah ada',
                    false => 'Gagal menambahkan praktikum',
                ];
    
                if (isset($errorMessages[$result])) {
                    $msg = $errorMessages[$result];
                    return Helper::redirect('/dashboard/superadmin/course-management', 'error', $msg);
                }
    
                return Helper::redirect('/dashboard/superadmin/course-management', 'success', 'Praktikum berhasil diperbarui');
    
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/course-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }

    public function CourseDelete($uidcourse) {
        if(Helper::is_post() && Helper::is_csrf()) {
            $uid = $uidcourse;
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            
            if(empty($uid) || empty($title)) {
                return Helper::redirect('/dashboard/superadmin/course-management', 'error', 'All fields must be fill');
            }
            
            try {
                $result = $this->CourseManagementModel->CourseDelete(
                    $uid,
                    $title
                );
            
                $errorMessages = [
                    'course_not_match' => 'Nama praktikum yang anda hapus tidak cocok',
                    false => 'Gagal menghapus praktikum',
                ];
            
                if (isset($errorMessages[$result])) {
                    $msg = $errorMessages[$result];
                    return Helper::redirect('/dashboard/superadmin/course-management', 'error', $msg);
                }
            
                return Helper::redirect('/dashboard/superadmin/course-management', 'success', 'Praktikum berhasil dihapus');
            
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/course-management', 'error', 'Error: ' . $e->getMessage());
            }
        }   
    }
}