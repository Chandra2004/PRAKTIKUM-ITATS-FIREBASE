<?php

namespace Database\Seeders;

use ITATS\PraktikumTeknikSipil\App\Config;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Faker\Factory;
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use ITATS\PraktikumTeknikSipil\Models\Seeders\Roles;

class RolesSeeder
{
    private $encryptionKey;

    public function __construct()
    {
        Config::loadEnv();
        $keyString = Config::get('ENCRYPTION_KEY');
        if (!$keyString) {
            throw new \Exception('Encryption key not configured.');
        }
        $this->encryptionKey = Key::loadFromAsciiSafeString($keyString);
    }

    public function run()
    {
        $roles = [
            [
                'uid' => 'SWjtFccjC7',
                'role_name' => 'SuperAdmin',
                'description_role' => 'Kepala Lab (Kalab) dengan akses penuh ke sistem',
            ],
            [
                'uid' => 'pY6FXnJj4P',
                'role_name' => 'Pembimbing',
                'description_role' => 'Dosen Pembimbing (Dospem) yang menilai praktikan',
            ],
            [
                'uid' => 'QvnNeZJlxV',
                'role_name' => 'Asisten',
                'description_role' => 'Asisten Lab (Aslab) yang mengatur jadwal & kelompok',
            ],
            [
                'uid' => 'azJw5fNCEX',
                'role_name' => 'Praktikan',
                'description_role' => 'Peserta yang mengikuti praktikum',
            ],
        ];

        foreach ($roles as $role) {
            Roles::create($role);
        }
    }
}
