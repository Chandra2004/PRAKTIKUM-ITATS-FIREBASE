<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Auth;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin\UserManagementController;

class RegisterController {
    private $UserCreate;

    public function __construct() {
        $this->UserCreate = new UserManagementController();
    }

    // VIEW REGISTER
    public function Index() {
        $notification = Helper::get_flash('notification');
        View::render('auth.register',[
            'notification' => $notification,
        ]);
    }

    // REGISTER USER
    public function RegisterUser() {
        return $this->UserCreate->UserCreate();
    }    
}
