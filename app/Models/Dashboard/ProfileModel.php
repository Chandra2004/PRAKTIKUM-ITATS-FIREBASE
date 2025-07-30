<?php

namespace ITATS\PraktikumTeknikSipil\Models\Dashboard;

use ITATS\PraktikumTeknikSipil\App\CacheManager;
use ITATS\PraktikumTeknikSipil\App\Database;
use ITATS\PraktikumTeknikSipil\App\Config;
use ITATS\PraktikumTeknikSipil\App\Logging;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class ProfileModel extends Database {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getUserDetail($uid) {
        $this->db->query("
            SELECT * FROM users WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        return $this->db->single();    
    }

    public function UpdatePhoto($uid, $profilePicture) {
        $query = "
            UPDATE users SET 
            profile_picture = :profile_picture 
            WHERE uid = :uid
        ";
        $this->db->query($query);
        $this->db->bind(':profile_picture', $profilePicture);
        $this->db->bind(':uid', $uid);
        return $this->db->execute();
    }

    public function UpdateData($uid, $data) {
        $query = "UPDATE users SET 
            full_name = :full_name,
            phone = :phone,
            fakultas = :fakultas,
            prodi = :prodi,
            npm_nip = :npm_nip,
            email = :email,
            posisi = :posisi,
            gender = :gender" . (isset($data['password']) ? ", password = :password" : "") . "
            WHERE uid = :uid";

        $this->db->query($query);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':fakultas', $data['fakultas']);
        $this->db->bind(':prodi', $data['prodi']);
        $this->db->bind(':npm_nip', $data['npm_nip']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':posisi', $data['posisi']);
        $this->db->bind(':gender', $data['gender']);
        if (isset($data['password'])) {
            $this->db->bind(':password', $data['password']);
        }
        $this->db->bind(':uid', $uid);
        return $this->db->execute();
    }

    public function checkDuplicate($email, $phone, $npm_nip, $uid) {
        $errors = [];

        // Periksa duplikasi email
        $this->db->query("
            SELECT COUNT(*) as count FROM users 
            WHERE email = :email AND uid != :uid
        ");
        $this->db->bind(':email', $email);
        $this->db->bind(':uid', $uid);
        if ($this->db->single()['count'] > 0) {
            $errors[] = 'Email sudah digunakan oleh pengguna lain.';
        }

        // Periksa duplikasi phone
        if (!empty($phone)) { // Hanya periksa jika phone tidak kosong
            $this->db->query("
                SELECT COUNT(*) as count FROM users 
                WHERE phone = :phone AND uid != :uid
            ");
            $this->db->bind(':phone', $phone);
            $this->db->bind(':uid', $uid);
            if ($this->db->single()['count'] > 0) {
                $errors[] = 'Nomor telepon sudah digunakan oleh pengguna lain.';
            }
        }

        // Periksa duplikasi npm_nip
        $this->db->query("
            SELECT COUNT(*) as count FROM users 
            WHERE npm_nip = :npm_nip AND uid != :uid
        ");
        $this->db->bind(':npm_nip', $npm_nip);
        $this->db->bind(':uid', $uid);
        if ($this->db->single()['count'] > 0) {
            $errors[] = 'NIM/NPM sudah digunakan oleh pengguna lain.';
        }

        return $errors;
    }
}
?>