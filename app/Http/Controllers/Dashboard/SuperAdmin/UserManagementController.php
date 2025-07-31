<?php
namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\DashboardController;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin\UserManagementModel;
use Respect\Validation\Rules\Length;

class UserManagementController {
    private $dashboardController;
    private $linkDashboard;
    private $UserManagementModel;

    public function __construct() {
        $this->dashboardController = new DashboardController();
        $this->linkDashboard = $this->dashboardController->LinkDashboard();
        $this->UserManagementModel = new UserManagementModel();
    }

    // VIEW USER MANAGEMENT
    public function Index() {
        $notification = Helper::get_flash('notification');
        $search = $_POST['search'] ?? null;
    
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['limit']) && (int)$_POST['limit'] > 0 ? (int)$_POST['limit'] : 10;
        $offset = ($page - 1) * $limit;
    
        $totalUsers = $this->UserManagementModel->CountUsers($search);
        $totalPages = ceil($totalUsers / $limit);
    
        View::render('dashboard.superadmin.users', [
            'title' => 'User Management | Praktikum Teknik Sipil ITATS',
            'notification' => $notification,
            'link' => $this->linkDashboard,
            'uid' => $_SESSION['user']['uid'],
            'profilePicture' => $_SESSION['user']['profile_picture'],
            'fullName' => $_SESSION['user']['full_name'],
            'email' => $_SESSION['user']['email'],
            'initials' => $_SESSION['user']['initials'],
            'roleName' => $_SESSION['user']['role_name'],
    
            'users' => $this->UserManagementModel->PaginateUsers($search, $limit, $offset),
            'roles' => $this->UserManagementModel->GetAllRoles(),
    
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
            'search' => $search,

            'totalUsers' => count($this->UserManagementModel->GetAllUsers()),
        ]);
    }

    // USER CREATE
    public function UserCreate() {
        if(Helper::is_post() && Helper::is_csrf()) {
            $npmMahasiswa          = filter_input(INPUT_POST, 'npm', FILTER_SANITIZE_SPECIAL_CHARS);
            $fullNameMahasiswa     = filter_input(INPUT_POST, 'full-name', FILTER_SANITIZE_SPECIAL_CHARS);
            $phoneMahasiswa        = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
            $emailMahasiswa        = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $passwordMahasiswa     = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);
            $passwordConfirm       = filter_input(INPUT_POST, 'password-confirm', FILTER_UNSAFE_RAW);
            $role                  = $_POST['role'] ?? 'azJw5fNCEX';

            $roleName = $_SESSION['user']['role_name'] ?? null;
            $isSpa    = Helper::is_ajax(); // Deteksi jika ini request AJAX
        
            // Inisialisasi inisial nama
            $initials = '';
            $words = explode(' ', $fullNameMahasiswa);
            if (!empty($words[0])) $initials .= strtoupper(substr($words[0], 0, 1));
            if (!empty($words[1])) $initials .= strtoupper(substr($words[1], 0, 1));
        
            // Cek password match
            if ($passwordMahasiswa !== $passwordConfirm) {
                if ($isSpa) {
                    return Helper::json(['status' => 'error', 'message' => 'Password tidak cocok.']);
                }
                $redirectUrl = ($roleName === 'SuperAdmin') ? '/dashboard/superadmin/user-management' : '/register';
                return Helper::redirect($redirectUrl, 'error', 'Password tidak cocok.');
            }

            try {
                $result = $this->UserManagementModel->UserCreate(
                    $npmMahasiswa,
                    $fullNameMahasiswa,
                    $phoneMahasiswa,
                    $emailMahasiswa,
                    $passwordMahasiswa,
                    $initials,
                    $role,
                    $roleName
                );
                
                // Tangani error unik
                $errorMessages = [
                    'email_exist_superadmin' => 'Email sudah terdaftar.',
                    'phone_exist_superadmin' => 'Nomor telepon sudah terdaftar.',
                    'npm_exist_superadmin'   => 'NPM sudah terdaftar.',
                    'email_exists'           => 'Email sudah terdaftar.',
                    'phone_exists'           => 'Nomor telepon sudah terdaftar.',
                    'npm_exists'             => 'NPM sudah terdaftar.',
                    false                    => 'Registrasi gagal.'
                ];
                
                if (isset($errorMessages[$result])) {
                    $msg = $errorMessages[$result];
                    $redirectUrl = ($roleName === 'SuperAdmin') ? '/dashboard/superadmin/user-management' : '/register';
        
                    if ($isSpa) {
                        return Helper::json(['status' => 'error', 'message' => $msg]);
                    }
        
                    return Helper::redirect($redirectUrl, 'error', $msg);
                }
                

                if ($roleName === 'SuperAdmin') {
                    return Helper::redirect('/dashboard/superadmin/user-management', 'success', 'User berhasil ditambahkan');
                } else {
                    return Helper::redirect('/login', 'success', 'Registrasi berhasil. Silakan login.');
                }
            } catch (\Exception $e) {
                $redirectUrl = ($roleName === 'SuperAdmin') ? '/dashboard/superadmin/user-management' : '/register';
                $errorMsg = 'Terjadi kesalahan: ' . $e->getMessage();
        
                if ($isSpa) {
                    return Helper::json(['status' => 'error', 'message' => $errorMsg]);
                }
        
                return Helper::redirect($redirectUrl, 'error', $errorMsg);
            }
        }
    }

    // USER UPDATE
    public function UserUpdate($id, $uid) {
        if(Helper::is_post() && $_POST['_token']) {
            if(empty($id) || empty($uid)) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'UID tidak valid');
            }
            
            $fullName = filter_input(INPUT_POST, 'fullName', FILTER_UNSAFE_RAW) ?? '' ;
            $email = filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW) ?? '' ;
            $npm = filter_input(INPUT_POST, 'npm', FILTER_UNSAFE_RAW) ?? '' ;
            $role = filter_input(INPUT_POST, 'role', FILTER_UNSAFE_RAW) ?? '' ;
            $phone = filter_input(INPUT_POST, 'phone', FILTER_UNSAFE_RAW) ?? '' ;
            
            if(empty($fullName) || empty($email) || empty($npm) || empty($role) || empty($phone)) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'Field harus terisi');
            }

            try {
                $result = $this->UserManagementModel->UserUpdate($id, $uid, $fullName, $email, $npm, $role, $phone);
            
                $errorMessages = [
                    'id_not_match' => 'ID user yang anda hapus tidak cocok',
                    'email_exists' => 'Email sudah dipakai oleh pengguna lain',
                    'npm_exists' => 'NPM sudah dipakai oleh pengguna lain',
                    'phone_exists' => 'Nomor telepon sudah dipakai oleh pengguna lain',
                    false => 'Gagal update user',
                ];
            
                if (isset($errorMessages[$result])) {
                    $msg = $errorMessages[$result];
                    return Helper::redirect('/dashboard/superadmin/user-management', 'error', $msg);
                }
            
                return Helper::redirect('/dashboard/superadmin/user-management', 'success', 'User berhasil diperbarui');
            
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }

    // USER UPDATE PASSWORD
    public function UserPasswordUpdate($id, $uid) {
        if(Helper::is_post() && $_POST['_token']) {
            if(empty($id) || empty($uid)) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'UID tidak valid');
            }
            
            $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);
            $passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_UNSAFE_RAW);
            
            if(empty($password) || empty($passwordConfirm)) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'Field harus terisi');
            }

            if($password !== $passwordConfirm) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'Password tidak valid');
            }

            if (strlen($password) < 8) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'Password harus terdiri dari minimal 8 karakter');
            }            

            try {
                $result = $this->UserManagementModel->UserPasswordUpdate($id, $uid, $password);
            
                $errorMessages = [
                    'id_not_match' => 'ID user yang anda hapus tidak cocok',
                    false => 'Gagal update password user',
                ];
            
                if (isset($errorMessages[$result])) {
                    $msg = $errorMessages[$result];
                    return Helper::redirect('/dashboard/superadmin/user-management', 'error', $msg);
                }
            
                return Helper::redirect('/dashboard/superadmin/user-management', 'success', 'Password user berhasil diperbarui');
            
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }

    // USER STATUS
    public function UserStatusUpdate($id, $uid) {
        if (Helper::is_post() && $_POST['_token']) {

            if(empty($id) || empty($uid)) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'UID tidak valid');
            }
            
            $status = isset($_POST['status']) ? '1' : '0';

            try {
                $result = $this->UserManagementModel->UserStatusUpdate($id, $uid, $status);

                $errorMessages = [
                    'id_not_match' => 'ID user yang anda hapus tidak cocok',
                    false => 'Gagal update password user',
                ];
    
                if (isset($errorMessages[$result])) {
                    $msg = $errorMessages[$result];
                    return Helper::redirect('/dashboard/superadmin/user-management', 'error', $msg);
                }
    
                return Helper::redirect('/dashboard/superadmin/user-management', 'success', 'Status user berhasil diperbarui');
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'Error: ' . $e->getMessage());
            }
            return Helper::redirect('/dashboard/superadmin/user-management', 'warning', 'status terkirim. isi status: ' . $status);
        }



        // if (!$uid) {
        //     return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'UID tidak ditemukan');
        // }

    }
    
    // USER DELETE
    public function UserDelete($id, $uid) {
        if(Helper::is_post() && $_POST['_token']) {
            if(empty($id) || empty($uid)) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'UID tidak valid');
            }

            try {
                $result = $this->UserManagementModel->UserDelete($id, $uid);
            
                $errorMessages = [
                    'id_not_match' => 'ID user yang anda hapus tidak cocok',
                    false => 'Gagal menghapus user',
                ];
            
                if (isset($errorMessages[$result])) {
                    $msg = $errorMessages[$result];
                    return Helper::redirect('/dashboard/superadmin/user-management', 'error', $msg);
                }
            
                return Helper::redirect('/dashboard/superadmin/user-management', 'success', 'User berhasil dihapus');
            
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/superadmin/user-management', 'error', 'Error: ' . $e->getMessage());
            }
        }
    }


}