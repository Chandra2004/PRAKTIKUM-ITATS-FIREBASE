<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;

class DashboardController {
    private $link = '/';
    private $userRole;

    public function __construct() {
        $this->userRole = $_SESSION['user']['role_name'] ?? null;
        Helper::validate_user_session();
    }

    public function LinkDashboard() {
        if ($this->userRole == 'Praktikan') {
            return $this->link = '/dashboard/praktikan';
        } else if ($this->userRole == 'SuperAdmin') {
            return $this->link = '/dashboard/superadmin';
        }

        return $this->link;
    }
}