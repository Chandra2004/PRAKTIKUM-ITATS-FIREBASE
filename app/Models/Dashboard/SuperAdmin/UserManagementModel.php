<?php

namespace ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin;

use ITATS\PraktikumTeknikSipil\App\CacheManager;
use ITATS\PraktikumTeknikSipil\App\Database;
use ITATS\PraktikumTeknikSipil\App\Config;
use ITATS\PraktikumTeknikSipil\App\Logging;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use PDO;

class UserManagementModel extends Database {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // ROLES READ
    public function GetAllRoles() {
        $this->db->query("
            SELECT * FROM roles
        ");
        return $this->db->resultSet();
    }

    // USERS READ
    public function GetAllUsers($search = null) {
        $sql = "
            SELECT users.*, 
                   roles.uid AS role_uniqId,
                   roles.role_name AS role_name
            FROM users
            JOIN roles ON users.role_uid = roles.uid
        ";
    
        if ($search) {
            $sql .= " 
                WHERE 
                    roles.role_name LIKE :search1 OR 
                    users.full_name LIKE :search2 OR 
                    users.phone LIKE :search3 OR 
                    users.npm_nip LIKE :search4
            ";
        }
    
        $sql .= " ORDER BY users.created_at DESC";
    
        $this->db->query($sql);
    
        if ($search) {
            $searchWildcard = '%' . $search . '%';
            $this->db->bind(':search1', $searchWildcard);
            $this->db->bind(':search2', $searchWildcard);
            $this->db->bind(':search3', $searchWildcard);
            $this->db->bind(':search4', $searchWildcard);
        }
    
        return $this->db->resultSet();
    }

    // USERS COUNT
    public function CountUsers($search = null) {
        $sql = "
            SELECT COUNT(*) as total FROM users 
            JOIN roles ON users.role_uid = roles.uid
        ";
    
        if ($search) {
            $sql .= "
                WHERE 
                    roles.role_name LIKE :search1 OR 
                    users.full_name LIKE :search2 OR 
                    users.phone LIKE :search3 OR 
                    users.npm_nip LIKE :search4
            ";
        }
    
        $this->db->query($sql);
    
        if ($search) {
            $searchWildcard = '%' . $search . '%';
            $this->db->bind(':search1', $searchWildcard);
            $this->db->bind(':search2', $searchWildcard);
            $this->db->bind(':search3', $searchWildcard);
            $this->db->bind(':search4', $searchWildcard);
        }
    
        return $this->db->single()['total'] ?? 0;
    }
    
    // USERS PAGINATED
    public function PaginateUsers($search = null, $limit = 10, $offset = 0) {
        $sql = "
            SELECT users.*, 
                   roles.uid AS role_uniqId,
                   roles.role_name AS role_name
            FROM users
            JOIN roles ON users.role_uid = roles.uid
        ";
    
        if ($search) {
            $sql .= " 
                WHERE 
                    roles.role_name LIKE :search1 OR 
                    users.full_name LIKE :search2 OR 
                    users.phone LIKE :search3 OR 
                    users.npm_nip LIKE :search4
            ";
        }
    
        $sql .= " ORDER BY users.created_at DESC LIMIT :limit OFFSET :offset";
    
        $this->db->query($sql);
    
        if ($search) {
            $searchWildcard = '%' . $search . '%';
            $this->db->bind(':search1', $searchWildcard);
            $this->db->bind(':search2', $searchWildcard);
            $this->db->bind(':search3', $searchWildcard);
            $this->db->bind(':search4', $searchWildcard);
        }
    
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
    
        return $this->db->resultSet();
    }   
    
    // USER CREATE
    public function UserCreate($npmMahasiswa, $fullNameMahasiswa, $phoneMahasiswa, $emailMahasiswa, $passwordMahasiswa, $initials, $role, $roleName) {
        // Cek email
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE email = :email");
        $this->db->bind(':email', $emailMahasiswa);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            if(!empty($roleName == 'SuperAdmin')) {
                return 'email_exist_superadmin';
            } else {
                return 'email_exists';
            }
        }

        // Cek nomor telepon
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE phone = :phone");
        $this->db->bind(':phone', $phoneMahasiswa);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            if(!empty($roleName == 'SuperAdmin')) {
                return 'phone_exist_superadmin';
            } else {
                return 'phone_exists';
            }
        }

        // Cek NPM
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE npm_nip = :npm");
        $this->db->bind(':npm', $npmMahasiswa);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            if(!empty($roleName == 'SuperAdmin')) {
                return 'npm_exist_superadmin';
            } else {
                return 'npm_exists';
            }
        }

        // Insert User
        $passwordMahasiswa = password_hash($passwordMahasiswa, PASSWORD_BCRYPT);

        $this->db->query("INSERT INTO users (uid, full_name, phone, email, password, npm_nip, role_uid, initials) VALUES (:uid, :full_name, :phone, :email, :password, :npm_nip, :role_uid, :initials)");
        $this->db->bind(':uid', Helper::generateUUID(10));
        $this->db->bind(':full_name', $fullNameMahasiswa);
        $this->db->bind(':phone', $phoneMahasiswa);
        $this->db->bind(':email', $emailMahasiswa);
        $this->db->bind(':password', $passwordMahasiswa);
        $this->db->bind(':npm_nip', $npmMahasiswa);
        $this->db->bind(':role_uid', $role);
        $this->db->bind(':initials', $initials);


        return $this->db->execute();
    }


    // USER DELETE
    public function UserDelete($id, $uid) {
        $this->db->query("
            SELECT COUNT(*) as count FROM users 
            WHERE id = :id 
            AND uid = :uid
        ");
        $this->db->bind(':id', $id);
        $this->db->bind(':uid', $uid);
        $result = $this->db->single();
    
        if (!$result || $result['count'] === 0) {
            return 'id_not_match';
        }
    
        // Delete kategori
        $this->db->query("
            DELETE FROM users WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        return $this->db->execute();
    }
}