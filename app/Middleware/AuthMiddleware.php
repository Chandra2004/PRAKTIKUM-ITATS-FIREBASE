<?php
    namespace ITATS\PraktikumTeknikSipil\Middleware;

    use ITATS\PraktikumTeknikSipil\App\Config;
    use ITATS\PraktikumTeknikSipil\App\SessionManager;
    use ITATS\PraktikumTeknikSipil\Helpers\Helper;

    class AuthMiddleware implements Middleware {
        public function before() {
            if (session_status() === PHP_SESSION_NONE) {
                SessionManager::startSecureSession();
            }

            if (!isset($_SESSION['user']['id']) || !isset($_SESSION['auth_token'])) {
                Helper::redirect('/login', 'error', 'You must be logged in to access this page.');
                exit();
            }

            // Validasi token autentikasi
            $storedToken = $_SESSION['auth_token'];
            $expectedToken = hash('sha256', $_SESSION['user']['id'] . Config::get('APP_KEY'));
            if (!hash_equals($storedToken, $expectedToken)) {
                error_log("AuthMiddleware: Token mismatch - Stored: $storedToken, Expected: $expectedToken");
                SessionManager::destroySession();
                Helper::redirect('/login', 'error', 'Invalid authentication token.');
                exit();
            }

            if (empty($_SESSION['auth_token']) || empty($_SESSION['user']['id'])) {
                SessionManager::destroySession();
                Helper::redirect('/login', 'error', 'You must be logged in to access this page.');
                exit();
            }
        }
    }
?>