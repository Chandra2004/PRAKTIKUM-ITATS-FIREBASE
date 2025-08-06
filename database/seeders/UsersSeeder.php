<?php
namespace Database\Seeders;

use ITATS\PraktikumTeknikSipil\App\Config;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Faker\Factory;
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use ITATS\PraktikumTeknikSipil\Models\Seeders\Users;

class UsersSeeder
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
        // Original 4 users
        $users = [
            [
                'uid' => Helper::generateUUID(10),
                'full_name' => 'Chandra Tri Antomo',
                'phone' => '081234567890',
                'fakultas' => 'FTSP',
                'prodi' => 'Teknik Sipil',
                'semester' => '1',
                'password' => password_hash('28092004', PASSWORD_BCRYPT),
                'gender' => 'Laki-laki',
                'email' => 's@gmail.com',
                'npm_nip' => '06.2024.1.07780',
                'posisi' => 'Ketua Lab Praktikum Uji Bahan',
                'initials' => 'CT',
                'role_uid' => 'SWjtFccjC7',
                'id_card' => Helper::generateUUID(20),
                'status' => 1
            ],
            [
                'uid' => Helper::generateUUID(10),
                'full_name' => 'Farrel Rizna Afrizal',
                'phone' => '098568645654',
                'fakultas' => 'FTSP',
                'prodi' => 'Teknik Sipil',
                'semester' => '1',
                'password' => password_hash('pembimbing123', PASSWORD_BCRYPT),
                'gender' => 'Laki-laki',
                'email' => 'pem@gmail.com',
                'npm_nip' => '06.2024.1.00890',
                'posisi' => 'Pembimbing',
                'initials' => 'FR',
                'role_uid' => 'pY6FXnJj4P',
                'id_card' => Helper::generateUUID(20),
                'status' => 1
            ],
            [
                'uid' => Helper::generateUUID(10),
                'full_name' => 'Norman Dwi Sulistiawan',
                'phone' => '096865689990',
                'fakultas' => 'FTSP',
                'prodi' => 'Teknik Sipil',
                'semester' => '1',
                'password' => password_hash('asisten123', PASSWORD_BCRYPT),
                'gender' => 'Laki-laki',
                'email' => 'as@gmail.com',
                'npm_nip' => '06.2024.1.00899',
                'posisi' => 'Asisten',
                'initials' => 'ND',
                'role_uid' => 'QvnNeZJlxV',
                'id_card' => Helper::generateUUID(20),
                'status' => 1
            ],
            [
                'uid' => Helper::generateUUID(10),
                'full_name' => 'Brian Yudha A P',
                'phone' => '08590901234',
                'fakultas' => 'FTSP',
                'prodi' => 'Teknik Sipil',
                'semester' => '1',
                'password' => password_hash('praktikan123123', PASSWORD_BCRYPT),
                'gender' => 'Laki-laki',
                'email' => 'p@gmail.com',
                'npm_nip' => '06.2024.1.07781',
                'posisi' => 'Praktikan',
                'initials' => 'BY',
                'role_uid' => 'azJw5fNCEX',
                'id_card' => Helper::generateUUID(20),
                'status' => 1
            ],
        ];

        // Initialize Faker
        $faker = Factory::create('id_ID'); // Use Indonesian locale for realistic names

        // Generate 1,000 random users
        $positions = ['Ketua Lab Praktikum Uji Bahan', 'Pembimbing', 'Asisten', 'Praktikan'];
        $role_uids = ['SWjtFccjC7', 'pY6FXnJj4P', 'QvnNeZJlxV', 'azJw5fNCEX'];
        $semesters = ['1', '3', '5', '7'];
        $genders = ['Laki-laki', 'Perempuan'];

        for ($i = 0; $i < 1; $i++) {
            $full_name = $faker->name;
            $name_parts = explode(' ', $full_name);
            $initials = strtoupper(substr($name_parts[0], 0, 1) . (isset($name_parts[1]) ? substr($name_parts[1], 0, 1) : ''));
            $npm_suffix = sprintf('%05d', 10000 + $i); // Generate 5-digit number starting from 10000
            $position_index = $faker->numberBetween(0, 3); // Randomly select position

            $users[] = [
                'uid' => Helper::generateUUID(10),
                'full_name' => $full_name,
                'phone' => '08' . $faker->numerify('##########'), // Random 12-digit phone number
                'fakultas' => 'FTSP',
                'prodi' => 'Teknik Sipil',
                'semester' => $faker->randomElement($semesters),
                'password' => password_hash('user' . $npm_suffix, PASSWORD_BCRYPT), // Unique password
                'gender' => $faker->randomElement($genders),
                'email' => $faker->unique()->email,
                'npm_nip' => '06.2024.2.' . $npm_suffix,
                'posisi' => $positions[$position_index],
                'initials' => $initials,
                'role_uid' => $role_uids[$position_index], // Match role_uid to position
                'id_card' => Helper::generateUUID(20),
                'status' => 1
            ];
        }

        // Insert all users into the database
        foreach ($users as $user) {
            Users::create($user);
        }
    }
}
