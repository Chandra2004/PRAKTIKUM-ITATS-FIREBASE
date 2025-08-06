<?php

namespace ITATS\PraktikumTeknikSipil\Models\Dashboard\SuperAdmin;

use DateTime;
use ITATS\PraktikumTeknikSipil\App\CacheManager;
use ITATS\PraktikumTeknikSipil\App\Database;
use ITATS\PraktikumTeknikSipil\App\Config;
use ITATS\PraktikumTeknikSipil\App\Logging;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use ITATS\PraktikumTeknikSipil\Helpers\Helper;

class ModuleManagementModel extends Database {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function GetAllModules() {
        $this->db->query("
            SELECT modules.*, courses.title_course
            FROM modules
            JOIN courses ON modules.course_uid_module = courses.uid
            ORDER BY modules.created_at ASC
        ");
        return $this->db->resultSet();
    }

    public function ModuleCreate($course, $title, $date, $location, $description) {
        // Validasi input
        if (empty($course) || empty($title)) {
            return 'required_fields_missing';
        }
        if (!empty($date) && !DateTime::createFromFormat('Y-m-d', $date)) {
            return 'invalid_date_format';
        }

        // Cek apakah modul dengan course dan title sudah ada (case-insensitive)
        $this->db->query("
            SELECT COUNT(*) as count 
            FROM modules 
            WHERE course_uid_module = :course_module AND LOWER(title_module) = LOWER(:title_module)
        ");
        $this->db->bind(':course_module', $course);
        $this->db->bind(':title_module', $title);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'module_exists';
        }

        $this->db->query("
            INSERT INTO modules 
            (uid, course_uid_module, title_module, date_module, location_module, description_module) 
            VALUES 
            (:uid, :course_uid_module, :title_module, :date_module, :location_module, :description_module)
        ");

        $this->db->bind(':uid', Helper::generateUUID(10));
        $this->db->bind(':course_uid_module', $course);
        $this->db->bind(':title_module', $title);
        $this->db->bind(':date_module', $date);
        $this->db->bind(':location_module', $location);
        $this->db->bind(':description_module', $description);
        return $this->db->execute();
    }

    public function ModuleUpdate($uid, $course, $title, $date, $location, $description) {
        // Validasi input
        if (empty($uid) || empty($course) || empty($title) || empty($date) || empty($location) || empty($description)) {
            return 'required_fields_missing';
        }
        if (!empty($date) && !DateTime::createFromFormat('Y-m-d', $date)) {
            return 'invalid_date_format';
        }

        // Cek apakah modul dengan course dan title sudah ada (case-insensitive, selain modul yang diupdate)
        $this->db->query("
            SELECT COUNT(*) as count 
            FROM modules 
            WHERE course_uid_module = :course_module AND LOWER(title_module) = LOWER(:title_module) AND uid != :uid
        ");
        $this->db->bind(':course_module', $course);
        $this->db->bind(':title_module', $title);
        $this->db->bind(':uid', $uid);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'module_exists';
        }

        $this->db->query("
            UPDATE modules 
            SET course_uid_module = :course_uid_module,
                title_module = :title_module,
                date_module = :date_module,
                location_module = :location_module,
                description_module = :description_module
            WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        $this->db->bind(':course_uid_module', $course);
        $this->db->bind(':title_module', $title);
        $this->db->bind(':date_module', $date);
        $this->db->bind(':location_module', $location);
        $this->db->bind(':description_module', $description);
        return $this->db->execute();
    }

    public function ModuleDelete($uid) {
        if (empty($uid)) {
            return 'module_not_found';
        }

        $this->db->query("
            SELECT COUNT(*) as count 
            FROM modules 
            WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        $result = $this->db->single();
        if ($result && $result['count'] == 0) {
            return 'module_not_found';
        }

        $this->db->query("
            DELETE FROM modules 
            WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        return $this->db->execute();
    }
}
