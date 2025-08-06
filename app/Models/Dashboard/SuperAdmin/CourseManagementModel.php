<?php

namespace ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin;

use ITATS\PraktikumTeknikSipil\App\CacheManager;
use ITATS\PraktikumTeknikSipil\App\Database;
use ITATS\PraktikumTeknikSipil\App\Config;
use ITATS\PraktikumTeknikSipil\App\Logging;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use ITATS\PraktikumTeknikSipil\Helpers\Helper;

class CourseManagementModel extends Database {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function GetAllCourses() {
        $this->db->query("
            SELECT courses.*, 
                   users.uid AS user_uniqId,
                   users.full_name AS user_fullName
            FROM courses
            JOIN users ON courses.uid_creator_course = users.uid
            ORDER BY created_at DESC
        ");
        return $this->db->resultSet();
    }

    public function GetSuperAdmins() {
        $this->db->query("
            SELECT users.*, 
                   roles.uid AS role_uniqId,
                   roles.role_name AS role_name
            FROM users
            JOIN roles ON users.role_uid = roles.uid 
            WHERE roles.role_name = 'SuperAdmin'
        ");
        return $this->db->resultSet();
    }

    public function CourseCreate($code, $title, $creator, $description) {
        // Cek kode
        $this->db->query("
            SELECT COUNT(*) as count FROM courses WHERE code_course = :code_course
        ");
        $this->db->bind(':code_course', $code);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'code_exists';
        }

        // Cek title
        $this->db->query("
            SELECT COUNT(*) as count FROM courses WHERE title_course = :title_course"
        );
        $this->db->bind(':title_course', $title);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'title_exists';
        }

        $this->db->query("
            INSERT INTO courses 
            (uid, code_course, title_course, description_course, uid_creator_course) 
            VALUES 
            (:uid, :code_course, :title_course, :description_course, :uid_creator_course)
        ");
        $this->db->bind(':uid', Helper::generateUUID(10));
        $this->db->bind(':code_course', $code);
        $this->db->bind(':title_course', $title);
        $this->db->bind(':description_course', $description);
        $this->db->bind(':uid_creator_course', $creator);

        return $this->db->execute();
    }

    public function CourseUpdate($uid, $code, $title, $creator, $description) {
        // Cek kode
        $this->db->query("
            SELECT COUNT(*) as count FROM courses 
            WHERE code_course = :code_course AND uid != :uid
        ");
        $this->db->bind(':uid', $uid);
        $this->db->bind(':code_course', $code);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'code_exists';
        }

        // Cek title
        $this->db->query("
            SELECT COUNT(*) as count FROM courses 
            WHERE BINARY title_course = :title_course AND uid != :uid
        ");
        $this->db->bind(':uid', $uid);
        $this->db->bind(':title_course', $title);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'title_exists';
        }

        $query = "
            UPDATE courses SET 
            code_course = :code_course,
            title_course = :title_course,
            description_course = :description_course,
            uid_creator_course = :uid_creator_course
            WHERE uid = :uid
        ";

        $this->db->query($query);
        $this->db->bind(':uid', $uid);
        $this->db->bind(':code_course', $code);
        $this->db->bind(':title_course', $title);
        $this->db->bind(':description_course', $description);
        $this->db->bind(':uid_creator_course', $creator);

        return $this->db->execute();
    }
    
    public function CourseDelete($uid, $title) {
        $this->db->query("
            SELECT COUNT(*) as count FROM courses 
            WHERE uid = :uid 
            AND BINARY title_course = :title
        ");
        $this->db->bind(':uid', $uid);
        $this->db->bind(':title', $title);
        $result = $this->db->single();
    
        if (!$result || $result['count'] === 0) {
            return 'course_not_match';
        }
    
        // Delete kategori
        $this->db->query("
            DELETE FROM courses WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        return $this->db->execute();
    }
}
