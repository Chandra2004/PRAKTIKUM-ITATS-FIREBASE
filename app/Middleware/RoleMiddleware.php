<?php

namespace ITATS\PraktikumTeknikSipil\Middleware;

use ITATS\PraktikumTeknikSipil\App\Router;
use ITATS\PraktikumTeknikSipil\App\SessionManager;
use ITATS\PraktikumTeknikSipil\Middleware\Middleware;

class RoleMiddleware implements Middleware {
    private $allowedRoles = [];

    public function __construct(array $allowedRoles) {
        $this->allowedRoles = $allowedRoles;
    }

    public function before() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            SessionManager::startSecureSession();
        }

        $userRole = $_SESSION['user']['role_name'] ?? null;

        if (!$userRole || !in_array($userRole, $this->allowedRoles)) {
            Router::handleAbort("Role \"$userRole\" tidak diizinkan");
        }
    }
}
