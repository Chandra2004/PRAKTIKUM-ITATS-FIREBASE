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

class SessionManagementModel extends Database {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function GetAllSessions() {
        $this->db->query("
        SELECT sessions.*, courses.title_course
        FROM sessions
        JOIN courses ON sessions.course_uid_session = courses.uid
        ORDER BY sessions.created_at ASC
        ");
        return $this->db->resultSet();
    }

    public function SessionCreate($course, $title, $kuota, $timeStart, $timeEnd, $deadline) {
        // Validasi input
        if (!is_numeric($kuota) || (int)$kuota <= 0) {
            return 'invalid_kuota';
        }
        if (!DateTime::createFromFormat('H:i', $timeStart) || !DateTime::createFromFormat('H:i', $timeEnd)) {
            return 'invalid_time_format';
        }
        if (!DateTime::createFromFormat('Y-m-d\TH:i', $deadline)) {
            return 'invalid_deadline_format';
        }

        // cek course & session
        $this->db->query("
            SELECT COUNT(*) as count 
            FROM sessions 
            WHERE course_uid_session = :course AND LOWER(title_session) = LOWER(:title)
        ");
        $this->db->bind(':course', $course);
        $this->db->bind(':title', $title);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'session_exists';
        }

        $this->db->query("
            INSERT INTO sessions 
            (uid, course_uid_session, title_session, kuota_session, time_start_session, time_end_session, deadline_session) 
            VALUES 
            (:uid, :course_uid_session, :title_session, :kuota_session, :time_start_session, :time_end_session, :deadline_session)
        ");
        $this->db->bind(':uid', Helper::generateUUID(10));
        $this->db->bind(':course_uid_session', $course);
        $this->db->bind(':title_session', $title);
        $this->db->bind(':kuota_session', $kuota);
        $this->db->bind(':time_start_session', $timeStart);
        $this->db->bind(':time_end_session', $timeEnd);
        $this->db->bind(':deadline_session', $deadline);

        return $this->db->execute();
    }

    public function SessionUpdate( $uid, $course, $title, $kuota, $timeStart, $timeEnd, $deadline) {
        // Validasi input
        if (empty($uid)) {
            return 'session_not_found';
        }
        if (!is_numeric($kuota) || (int)$kuota <= 0) {
            return 'invalid_kuota';
        }
        if (!DateTime::createFromFormat('H:i', $timeStart) || !DateTime::createFromFormat('H:i', $timeEnd)) {
            return 'invalid_time_format';
        }
        if (!DateTime::createFromFormat('Y-m-d\TH:i', $deadline)) {
            return 'invalid_deadline_format';
        }

        // Cek apakah sesi dengan course dan title sudah ada (selain sesi yang sedang diupdate)
        $this->db->query("
            SELECT COUNT(*) as count 
            FROM sessions 
            WHERE course_uid_session = :course AND LOWER(title_session) = LOWER(:title) AND uid != :uid
        ");
        $this->db->bind(':course', $course);
        $this->db->bind(':title', $title);
        $this->db->bind(':uid', $uid);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'session_exists';
        }

        $this->db->query("
            UPDATE sessions 
            SET course_uid_session = :course_uid_session,
                title_session = :title_session,
                kuota_session = :kuota_session,
                time_start_session = :time_start_session,
                time_end_session = :time_end_session,
                deadline_session = :deadline_session
            WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        $this->db->bind(':course_uid_session', $course);
        $this->db->bind(':title_session', $title);
        $this->db->bind(':kuota_session', (int)$kuota);
        $this->db->bind(':time_start_session', $timeStart);
        $this->db->bind(':time_end_session', $timeEnd);
        $this->db->bind(':deadline_session', $deadline);
        return $this->db->execute();
    }

    public function SessionDelete($uid) {
        if (empty($uid)) {
            return 'session_not_found';
        }

        $this->db->query("
            SELECT COUNT(*) as count 
            FROM sessions 
            WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        $result = $this->db->single();
        if ($result && $result['count'] == 0) {
            return 'session_not_found';
        }

        $this->db->query("
            DELETE FROM sessions 
            WHERE uid = :uid
        ");
        $this->db->bind(':uid', $uid);
        return $this->db->execute();
    }
}
