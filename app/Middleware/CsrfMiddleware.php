<?php
    // namespace ITATS\PraktikumTeknikSipil\Middleware;

    // class CsrfMiddleware implements Middleware {
    //     public static function generateToken() {
    //         if (session_status() !== PHP_SESSION_ACTIVE) {
    //             session_start();
    //         }
    //         if (empty($_SESSION['csrf_token'])) {
    //             $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    //         }
    //         return $_SESSION['csrf_token'];
    //     }

    //     public static function verifyToken($token) {
    //         if (session_status() !== PHP_SESSION_ACTIVE) {
    //             session_start();
    //         }

    //         $sessionToken = $_SESSION['csrf_token'] ?? '';

    //         error_log("SESSION CSRF: " . $sessionToken);
    //         error_log("POST CSRF: " . ($token ?: 'TIDAK ADA'));

    //         return !empty($sessionToken) && !empty($token) && hash_equals($sessionToken, $token);
    //     }

    //     public function before() {
    //         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //             if (session_status() !== PHP_SESSION_ACTIVE) {
    //                 session_start();
    //             }

    //             $token = $_POST['_token'] ?? '';

    //             if (!self::verifyToken($token)) {
    //                 http_response_code(403);
    //                 echo json_encode(["error" => "Invalid CSRF token."]);
    //                 exit;
    //             }
    //         }
    //     }
    // }

    namespace ITATS\PraktikumTeknikSipil\Middleware;

use ITATS\PraktikumTeknikSipil\Helpers\Helper;

    class CsrfMiddleware implements Middleware {
        public static function generateToken() {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }

            return $_SESSION['csrf_token'];
        }

        public static function verifyToken($token) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $sessionToken = $_SESSION['csrf_token'] ?? '';

            error_log("SESSION CSRF: " . $sessionToken);
            error_log("POST CSRF: " . ($token ?: 'TIDAK ADA'));

            return !empty($sessionToken) && !empty($token) && hash_equals($sessionToken, $token);
        }

        public function before() {
            $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

            // Dukung spoofed method (_method)
            if ($method === 'POST' && isset($_POST['_method'])) {
                $method = strtoupper(trim($_POST['_method']));
            }

            // Cek token jika method perlu perlindungan
            if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }

                $token = $_POST['_token'] ?? '';

                if (!self::verifyToken($token)) {
                    http_response_code(403);
                    echo json_encode(["error" => "Invalid CSRF token."]);
                    exit;
                }
            }
        }
    }
?>