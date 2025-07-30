<?php
    namespace ITATS\PraktikumTeknikSipil\Database;

    use ITATS\PraktikumTeknikSipil\App\Database;

    abstract class Migration {
        protected Database $db;

        public function __construct()
        {
            $this->db = Database::getInstance();
        }

        abstract public function up();
        abstract public function down();
    }
?>