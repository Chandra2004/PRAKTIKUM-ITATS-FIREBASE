<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Helpers/helpers.php';

define('ROOT_DIR', __DIR__);

use ITATS\PraktikumTeknikSipil\BladeInit;
use ITATS\PraktikumTeknikSipil\App\Config;
use ITATS\PraktikumTeknikSipil\App\Router;
use ITATS\PraktikumTeknikSipil\App\SessionManager;

//Middleware
use ITATS\PraktikumTeknikSipil\Middleware\AuthMiddleware;
use ITATS\PraktikumTeknikSipil\Middleware\CsrfMiddleware;
use ITATS\PraktikumTeknikSipil\Middleware\WAFMiddleware;
use ITATS\PraktikumTeknikSipil\Middleware\RoleMiddleware;

// Validator Middleware
use ITATS\PraktikumTeknikSipil\Middleware\Validator\RegisterValidator;
use ITATS\PraktikumTeknikSipil\Middleware\Validator\LoginValidator;

// Controllers
use ITATS\PraktikumTeknikSipil\Http\Controllers\Homepage\HomeController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\News\NewsController;

use ITATS\PraktikumTeknikSipil\Http\Controllers\Auth\RegisterController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Auth\LoginController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin\CourseManagementController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin\HomeSuperAdminController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin\ModuleManagementController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin\PaymentManagementController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin\ProfileSuperAdminController;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin\UserManagementController;


SessionManager::startSecureSession();
Config::loadEnv();

header('X-Powered-By: Native-Chandra');
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: no-referrer-when-downgrade');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');

// Jalankan router
CsrfMiddleware::generateToken();

Router::add('GET', '/', HomeController::class, 'Index', [WAFMiddleware::class]);

Router::add('GET', '/news', NewsController::class, 'Index', [WAFMiddleware::class]);
Router::add('GET', '/news/page/{page}', NewsController::class, 'Index', [WAFMiddleware::class]);
Router::add('GET', '/news/{category}/{id}/{slug}', NewsController::class, 'Detail', [WAFMiddleware::class]);

Router::add('GET', '/login', LoginController::class, 'Index', [WAFMiddleware::class]);
Router::add('POST', '/login/auth', LoginController::class, 'LoginUser', [WAFMiddleware::class, CsrfMiddleware::class, LoginValidator::class]);

Router::add('GET', '/register', RegisterController::class, 'Index', [WAFMiddleware::class]);
Router::add('POST', '/register/auth', RegisterController::class, 'RegisterUser', [WAFMiddleware::class, CsrfMiddleware::class, RegisterValidator::class]);

// HOME DASHBOARD
    // SUPER ADMIN
    Router::add('GET', '/dashboard/superadmin', HomeSuperAdminController::class, 'Index', [
        AuthMiddleware::class,
        WAFMiddleware::class,
        [RoleMiddleware::class, ['SuperAdmin']]
    ]);

    // PEMBIMBING
    // Router::add('GET', '/dashboard/pembimbing', HomePembimbingController::class, 'Index', [
    //     AuthMiddleware::class,
    //     WAFMiddleware::class,
    //     [RoleMiddleware::class, ['Pembimbing']]
    // ]);

    // ASISTEN
    // Router::add('GET', '/dashboard/asisten', HomeAsistenController::class, 'Index', [
    //     AuthMiddleware::class,
    //     WAFMiddleware::class,
    //     [RoleMiddleware::class, ['Asisten']]
    // ]);

    // PRAKTIKAN
    // Router::add('GET', '/dashboard/praktikan', HomePraktikanController::class, 'Index', [
    //     AuthMiddleware::class,
    //     WAFMiddleware::class,
    //     [RoleMiddleware::class, ['Praktikan']]
    // ]);

// MENU SUPER ADMIN
    // USER-MANAGEMENT
    Router::add('GET', '/dashboard/superadmin/user-management', UserManagementController::class, 'Index', [
        AuthMiddleware::class,
        WAFMiddleware::class,
        [RoleMiddleware::class, ['SuperAdmin']]
    ]);

        // SEARCH - PAGINATION - LIMIT
        Router::add('POST', '/dashboard/superadmin/user-management', UserManagementController::class, 'Index', [
            AuthMiddleware::class,
            WAFMiddleware::class,
            [RoleMiddleware::class, ['SuperAdmin']]
        ]);

        // CREATE
        Router::add('POST', '/dashboard/superadmin/user-management/create/user', UserManagementController::class, 'UserCreate', [
            AuthMiddleware::class,
            WAFMiddleware::class,
            CsrfMiddleware::class, 
            RegisterValidator::class,
            [RoleMiddleware::class, ['SuperAdmin']]
        ]);
        
        // UPDATE PASSWORD
        Router::add('POST', '/dashboard/superadmin/user-management/update-password/user/{uid}', UserManagementController::class, 'PasswordUpdate', [
            AuthMiddleware::class,
            WAFMiddleware::class,
            CsrfMiddleware::class, 
            RegisterValidator::class,
            [RoleMiddleware::class, ['SuperAdmin']]
        ]);
        
        // UPDATE
        Router::add('POST', '/dashboard/superadmin/user-management/update/user/{uid}', UserManagementController::class, 'UserUpdate', [
            AuthMiddleware::class,
            WAFMiddleware::class,
            CsrfMiddleware::class, 
            RegisterValidator::class,
            [RoleMiddleware::class, ['SuperAdmin']]
        ]);
        
        // DELETE
        Router::add('POST', '/dashboard/superadmin/user-management/delete/{id}/user/{uid}', UserManagementController::class, 'UserDelete', [
            AuthMiddleware::class,
            WAFMiddleware::class,
            CsrfMiddleware::class, 
            RegisterValidator::class,
            [RoleMiddleware::class, ['SuperAdmin']]
        ]);































    










































































// Router::add('GET', '/dashboard/superadmin/payment-management', PaymentManagementController::class, 'Index', [
//     AuthMiddleware::class,
//     WAFMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);

// Router::add('GET', '/dashboard/superadmin/courses-management', CourseManagementController::class, 'Index', [
//     AuthMiddleware::class,
//     WAFMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);

// Router::add('POST', '/dashboard/superadmin/courses-management/create', CourseManagementController::class, 'CourseCreate', [
//     AuthMiddleware::class,
//     WAFMiddleware::class,
//     CsrfMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);

// Router::add('POST', '/dashboard/superadmin/courses-management/update/{uidcourse}', CourseManagementController::class, 'CourseUpdate', [
//     AuthMiddleware::class,
//     WAFMiddleware::class,
//     CsrfMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);

// Router::add('POST', '/dashboard/superadmin/courses-management/delete/{uidcourse}', CourseManagementController::class, 'CourseDelete', [
//     AuthMiddleware::class,
//     WAFMiddleware::class,
//     CsrfMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);

// Router::add('GET', '/dashboard/superadmin/modules-management', ModuleManagementController::class, 'Index', [
//     AuthMiddleware::class,
//     WAFMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);


// // PROFILE SUPER ADMIN
// Router::add('GET', '/dashboard/superadmin/profile', ProfileSuperAdminController::class, 'Index', [
//     AuthMiddleware::class,
//     WAFMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);

// Router::add('POST', '/dashboard/superadmin/profile/update/photo', ProfileSuperAdminController::class, 'UpdatePhoto', [
//     WAFMiddleware::class,
//     AuthMiddleware::class,
//     CsrfMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);

// Router::add('POST', '/dashboard/superadmin/profile/update/data', ProfileSuperAdminController::class, 'UpdateData', [
//     CsrfMiddleware::class,
//     AuthMiddleware::class,
//     WAFMiddleware::class,
//     [RoleMiddleware::class, ['SuperAdmin']]
// ]);


// LOGOUT USER
Router::add('GET', '/logout', LoginController::class, 'Logout', [WAFMiddleware::class]);

BladeInit::init();
Router::run();
