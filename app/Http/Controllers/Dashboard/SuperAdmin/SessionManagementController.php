<?php
namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin;
use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\DashboardController;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin\{CourseManagementModel, SessionManagementModel};
use DateTime;
use Exception;

class SessionManagementController {
    private $dashboardController;
    private $linkDashboard;
    private $SessionManagementModel;
    private $CourseManagementModel;

    public function __construct() {
        $this->dashboardController = new DashboardController();
        $this->linkDashboard = $this->dashboardController->LinkDashboard();
        $this->SessionManagementModel = new SessionManagementModel();
        $this->CourseManagementModel = new CourseManagementModel();
    }
    
    public function Index() {
        $notification = Helper::get_flash('notification');
        
        View::render('dashboard.superadmin.session', [
            'title' => 'Session Management | Praktikum Teknik Sipil ITATS',
            'notification' => $notification,
            'link' => $this->linkDashboard,
            'uid' => $_SESSION['user']['uid'],
            'profilePicture' => $_SESSION['user']['profile_picture'],
            'fullName' => $_SESSION['user']['full_name'],
            'email' => $_SESSION['user']['email'],
            'initials' => $_SESSION['user']['initials'],
            'roleName' => $_SESSION['user']['role_name'],
            'coursesList' => $this->CourseManagementModel->GetAllCourses(),
            'sessionsList' => $this->SessionManagementModel->GetAllSessions(),
        ]);
    }

    public function SessionCreate() {
        if (!Helper::is_post()) {
            return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Invalid request method');
        }
        if (!Helper::is_csrf()) {
            return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'CSRF validation failed');
        }

        $course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_SPECIAL_CHARS);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $kuota = filter_input(INPUT_POST, 'kuota', FILTER_VALIDATE_INT);
        $timeStart = filter_input(INPUT_POST, 'timeStart', FILTER_SANITIZE_SPECIAL_CHARS);
        $timeEnd = filter_input(INPUT_POST, 'timeEnd', FILTER_SANITIZE_SPECIAL_CHARS);
        $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($course) || empty($title) || empty($kuota) || empty($deadline) || empty($timeStart) || empty($timeEnd)) {
            return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Semua kolom wajib diisi');
        }
        if ($kuota <= 0) {
            return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Kuota harus lebih dari 0');
        }

        try {
            $timeStartFormat = DateTime::createFromFormat('H:i', $timeStart);
            $timeEndFormat = DateTime::createFromFormat('H:i', $timeEnd);
            $deadlineFormat = DateTime::createFromFormat('Y-m-d\TH:i', $deadline);

            if (!$timeStartFormat || !$timeEndFormat) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Format waktu tidak valid');
            }
            if (!$deadlineFormat) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Format deadline tidak valid');
            }
            if ($timeEndFormat <= $timeStartFormat) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Waktu akhir tidak boleh lebih awal dari waktu mulai');
            }

            $result = $this->SessionManagementModel->SessionCreate(
                $course,
                $title,
                $kuota,
                $timeStart,
                $timeEnd,
                $deadline
            );

            $errorMessages = [
                'session_exists' => 'Sesi praktikum sudah ada',
                'invalid_kuota' => 'Kuota tidak valid',
                'invalid_time_format' => 'Format waktu tidak valid',
                'invalid_deadline_format' => 'Format deadline tidak valid',
                false => 'Gagal menambahkan sesi praktikum',
            ];

            if (isset($errorMessages[$result])) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', $errorMessages[$result]);
            }

            return Helper::redirect('/dashboard/superadmin/session-management', 'success', 'Sesi berhasil ditambahkan');
        } catch (Exception $e) {
            return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Error: ' . $e->getMessage());
        }
    }

    public function SessionUpdate($uid) {
        if(Helper::is_post() && Helper::is_csrf()) {
            $course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $kuota = filter_input(INPUT_POST, 'kuota', FILTER_VALIDATE_INT) ?? '';
            $timeStart = filter_input(INPUT_POST, 'timeStart', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $timeEnd = filter_input(INPUT_POST, 'timeEnd', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    
            if (empty($uid) || empty($course) || empty($title) || empty($kuota) || empty($deadline) || empty($timeStart) || empty($timeEnd)) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Semua kolom wajib diisi');
            }
            if ($kuota <= 0) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Kuota harus lebih dari 0');
            }

            try {
                $timeStartFormat = DateTime::createFromFormat('H:i', $timeStart);
                $timeEndFormat = DateTime::createFromFormat('H:i', $timeEnd);
                $deadlineFormat = DateTime::createFromFormat('Y-m-d\TH:i', $deadline);
    
                if (!$timeStartFormat || !$timeEndFormat) {
                    return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Format waktu tidak valid');
                }
                if (!$deadlineFormat) {
                    return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Format deadline tidak valid');
                }
                if ($timeEndFormat <= $timeStartFormat) {
                    return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Waktu akhir tidak boleh lebih awal dari waktu mulai');
                }
    
                $result = $this->SessionManagementModel->SessionUpdate(
                    $uid,
                    $course,
                    $title,
                    $kuota,
                    $timeStart,
                    $timeEnd,
                    $deadline
                );
    
                $errorMessages = [
                    'session_exists' => 'Sesi praktikum dengan judul ini sudah ada untuk kursus tersebut',
                    'session_not_found' => 'Sesi tidak ditemukan',
                    'invalid_kuota' => 'Kuota tidak valid',
                    'invalid_time_format' => 'Format waktu tidak valid',
                    'invalid_deadline_format' => 'Format deadline tidak valid',
                    false => 'Gagal memperbarui sesi praktikum',
                ];
    
                if (isset($errorMessages[$result])) {
                    return Helper::redirect('/dashboard/superadmin/session-management', 'error', $errorMessages[$result]);
                }
    
                return Helper::redirect('/dashboard/superadmin/session-management', 'success', 'Sesi berhasil diperbarui');
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }

    public function SessionDelete($uid) {
        if(Helper::is_post() && Helper::is_csrf()) {
            if (empty($uid)) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'ID sesi tidak valid');
            }

            try {
                $result = $this->SessionManagementModel->SessionDelete($uid);
    
                $errorMessages = [
                    'session_not_found' => 'Sesi tidak ditemukan',
                    false => 'Gagal menghapus sesi praktikum',
                ];
    
                if (isset($errorMessages[$result])) {
                    return Helper::redirect('/dashboard/superadmin/session-management', 'error', $errorMessages[$result]);
                }
    
                return Helper::redirect('/dashboard/superadmin/session-management', 'success', 'Sesi berhasil dihapus');
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/session-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }
}