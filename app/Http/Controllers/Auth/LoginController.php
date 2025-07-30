<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Auth;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Models\Auth\LoginModel;

class LoginController {
    private $LoginModel;

    public function __construct() {
        $this->LoginModel = new LoginModel();
    }

    // LOGIN VIEW
    public function Index() {
        $notification = Helper::get_flash('notification');
        View::render('auth.login', [
            'notification' => $notification
        ]);
    }

    // LOGIN USER
    public function LoginUser() {
        if (!Helper::is_post() || !isset($_POST['_token'])) {
            return Helper::redirect('/login', 'error', 'Invalid request method.');
        }

        $identyfier = filter_input(INPUT_POST, 'identyfier', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

        if (empty($identyfier) || empty($password)) {
            return Helper::redirect('/login', 'error', 'Email and password are required.');
        }

        try {
            $user = $this->LoginModel->LoginUser($identyfier, $password);
            if (!$user) {
                return Helper::redirect('/login', 'error', 'Invalid email or password.');
            }

            // Simpan session user
            $_SESSION['user'] = [
                'id' => $user['id'],
                'uid' => $user['uid'],

                'profile_picture' => $user['profile_picture'],
                'full_name' => $user['full_name'],
                'phone' => $user['phone'],
                'fakultas' => $user['fakultas'],
                'prodi' => $user['prodi'],
                'semester' => $user['semester'],
                'gender' => $user['gender'],
                'email' => $user['email'],
                'npm_nip' => $user['npm_nip'],
                'posisi' => $user['posisi'],

                'initials' => $user['initials'],
                'role_name' => $user['role_name'],
            ];

            $_SESSION['auth_token'] = hash('sha256', $_SESSION['user']['id'] . Config::get('APP_KEY'));

            if ($user['role_name'] === 'SuperAdmin') {
                return Helper::redirect('/dashboard/superadmin', 'success', 'Welcome, ' . $_SESSION['user']['full_name'] . '!');
            }
            if ($user['role_name'] === 'Praktikan') {
                return Helper::redirect('/dashboard/praktikan', 'success', 'Welcome, ' . $_SESSION['user']['full_name'] . '!');
            }
        } catch (Exception $e) {
            return Helper::redirect('/login', 'error', 'Login failed: ' . $e->getMessage());
        }
    }

    // LOGOUT USER
    public function Logout() {
        session_destroy();
        return Helper::redirect('/', 'success', 'Logged out successfully.');
    }
}
