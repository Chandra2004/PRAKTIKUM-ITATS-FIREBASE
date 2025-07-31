<?php

namespace ITATS\PraktikumTeknikSipil\Models\Auth;

use ITATS\PraktikumTeknikSipil\App\CacheManager;
use ITATS\PraktikumTeknikSipil\App\Database;
use ITATS\PraktikumTeknikSipil\App\Config;
use ITATS\PraktikumTeknikSipil\App\Logging;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class LoginModel extends Database {
    // USER LOGIN
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function LoginUser($identyfier, $password) {
        $this->db->query("
            SELECT users.*, roles.role_name AS role_name
            FROM users
            JOIN roles ON users.role_uid = roles.uid
            WHERE (users.email = :email OR users.npm_nip = :npm_nip)
        ");
        $this->db->bind(':email', $identyfier);
        $this->db->bind(':npm_nip', $identyfier);
        $user = $this->db->single();

        if ($user && $user['status'] == '0') {
            return 'status_failed';
        }

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }


        return false;
    }
}