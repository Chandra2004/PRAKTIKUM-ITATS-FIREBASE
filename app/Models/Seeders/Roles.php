<?php

namespace ITATS\PraktikumTeknikSipil\Models\Seeders;

use ITATS\PraktikumTeknikSipil\App\Database;

class Roles
{
    protected static Database $db;

    public static function create(array $data)
    {
        self::$db = Database::getInstance();
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO roles ($columns) VALUES ($placeholders)";
        self::$db->query($sql);

        foreach ($data as $key => $value) {
            self::$db->bind(":$key", $value);
        }

        return self::$db->execute();
    }
    
    public static function where(string $column, $value)
    {
        self::$db = Database::getInstance();
        $sql = "SELECT COUNT(*) as count FROM roles WHERE $column = :value";
        self::$db->query($sql);
        self::$db->bind(':value', $value);
        $result = self::$db->single();

        return new class($result['count']) {
            private int $count;

            public function __construct($count)
            {
                $this->count = $count;
            }

            public function exists(): bool
            {
                return $this->count > 0;
            }
        };
    }
}
