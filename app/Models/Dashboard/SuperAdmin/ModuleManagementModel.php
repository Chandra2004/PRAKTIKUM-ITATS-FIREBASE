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
            ORDER BY modules.created_at DESC
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
            WHERE course_uid = :course AND LOWER(title) = LOWER(:title)
        ");
        $this->db->bind(':course', $course);
        $this->db->bind(':title', $title);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'module_exists';
        }

        $this->db->query("
            INSERT INTO modules 
            (uid, course_uid_module, title_module, date_module, location_module, description_module) 
            VALUES 
            (:uid, :course_uid, :title, :date, :location, :description)
        ");

        $this->db->bind(':uid', Helper::generateUUID(10));
        $this->db->bind(':course_uid', $course);
        $this->db->bind(':title', $title);
        $this->db->bind(':date', $date ?: null);
        $this->db->bind(':location', $location ?: null);
        $this->db->bind(':description', $description ?: null);
        return $this->db->execute();
    }
}
