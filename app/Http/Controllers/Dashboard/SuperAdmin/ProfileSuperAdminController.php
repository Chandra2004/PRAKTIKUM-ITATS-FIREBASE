<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\SuperAdmin;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\DashboardController;
use ITATS\PraktikumTeknikSipil\Models\Dashboard\ProfileModel;

class ProfileSuperAdminController {
    private $dashboardController;
    private $linkDashboard;
    private $ProfileModel;

    private $fakultas = [
        ['kode' => 'FTI', 'nama' => 'Fakultas Teknologi Industri'],
        ['kode' => 'FTSP', 'nama' => 'Fakultas Teknik Sipil dan Perencanaan'],
        ['kode' => 'FTETI', 'nama' => 'Fakultas Teknik Elektro dan Teknologi Informasi'],
    ];
    
    private $prodi = [
        ['id' => 1, 'fakultas' => 'FTI', 'nama' => 'Teknik Mesin', 'jenjang' => 'S1', 'akreditasi' => 'Baik Sekali'],
        ['id' => 2, 'fakultas' => 'FTI', 'nama' => 'Teknik Industri', 'jenjang' => 'S1', 'akreditasi' => 'Baik Sekali'],
        ['id' => 3, 'fakultas' => 'FTI', 'nama' => 'Teknik Kimia', 'jenjang' => 'S1', 'akreditasi' => 'Baik Sekali'],
        ['id' => 4, 'fakultas' => 'FTI', 'nama' => 'Teknik Pertambangan', 'jenjang' => 'S1', 'akreditasi' => 'Baik Sekali'],
        ['id' => 5, 'fakultas' => 'FTI', 'nama' => 'Teknik Perkapalan', 'jenjang' => 'S1', 'akreditasi' => 'B'],
        ['id' => 6, 'fakultas' => 'FTI', 'nama' => 'Magister Teknik Industri', 'jenjang' => 'S2', 'akreditasi' => 'Baik Sekali'],
        ['id' => 7, 'fakultas' => 'FTSP', 'nama' => 'Teknik Sipil', 'jenjang' => 'S1', 'akreditasi' => 'B'],
        ['id' => 8, 'fakultas' => 'FTSP', 'nama' => 'Arsitektur', 'jenjang' => 'S1', 'akreditasi' => 'B'],
        ['id' => 9, 'fakultas' => 'FTSP', 'nama' => 'Teknik Lingkungan', 'jenjang' => 'S1', 'akreditasi' => 'Baik Sekali'],
        ['id' => 10, 'fakultas' => 'FTSP', 'nama' => 'Magister Teknik Lingkungan', 'jenjang' => 'S2', 'akreditasi' => 'Baik Sekali'],
        ['id' => 11, 'fakultas' => 'FTETI', 'nama' => 'Teknik Elektro', 'jenjang' => 'S1', 'akreditasi' => 'B'],
        ['id' => 12, 'fakultas' => 'FTETI', 'nama' => 'Teknik Informatika', 'jenjang' => 'S1', 'akreditasi' => 'B'],
        ['id' => 13, 'fakultas' => 'FTETI', 'nama' => 'Sistem Informasi', 'jenjang' => 'S1', 'akreditasi' => 'B'],
    ];

    public function __construct() {
        $this->dashboardController = new DashboardController();
        $this->linkDashboard = $this->dashboardController->LinkDashboard();
        $this->ProfileModel = new ProfileModel();
    }

    public function Index() {
        $notification = Helper::get_flash('notification');

        View::render('dashboard.superadmin.profile', [
            'title' => 'Payment Management | Praktikum Teknik Sipil ITATS',
            'notification' => $notification,
            'link' => $this->linkDashboard,
            'id' => $_SESSION['user']['id'],
            'uid' => $_SESSION['user']['uid'],
            'profilePicture' => $_SESSION['user']['profile_picture'],
            'fullName' => $_SESSION['user']['full_name'],
            'phone' => $_SESSION['user']['phone'],
            'fakultasData' => $_SESSION['user']['fakultas'],
            'prodiData' => $_SESSION['user']['prodi'],
            'posisi' => $_SESSION['user']['posisi'],
            'semester' => $_SESSION['user']['semester'],
            'fakultases' => $this->fakultas,
            'prodis' => $this->prodi,
            'gender' => $_SESSION['user']['gender'],
            'email' => $_SESSION['user']['email'],
            'nomorKampus' => $_SESSION['user']['npm_nip'],
            'initials' => $_SESSION['user']['initials'],
            'roleName' => $_SESSION['user']['role_name'],
        ]);
    }

    public function UpdatePhoto() {
        if (!Helper::is_post() && !isset($_POST['_token'])) {
            return Helper::redirect('/dashboard/superadmin/profile', 'error', 'Invalid request method.');
        }
        
        $uid = $_SESSION['user']['uid'];
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_INI_SIZE) {
            return Helper::redirect('/dashboard/superadmin/profile', 'error', 'Ukuran file terlalu besar. Maksimal 2MB.');
        }

        $newPicture = $_FILES['avatar'];
        if (!$newPicture || $newPicture['error'] !== UPLOAD_ERR_OK) {
            return Helper::redirect('/dashboard/superadmin/profile', 'error', 'Tidak ada file yang diunggah atau file rusak.');
        }

        $fileName = $this->processImage($newPicture, $uid);
        if ($fileName instanceof Exception) {
            return Helper::redirect('/dashboard/superadmin/profile', 'error', 'Update photo gagal: ' . $fileName->getMessage());
        }

        try {
            $this->ProfileModel->UpdatePhoto($uid, $fileName);
            $_SESSION['user']['profile_picture'] = $fileName;
            return Helper::redirect('/dashboard/superadmin/profile', 'success', 'Foto profil berhasil diperbarui', 0, [
                'profile_picture_url' => Helper::url('/file.php?file=user-pictures/' . $fileName)
            ]);
        } catch (Exception $e) {
            return Helper::redirect('/dashboard/superadmin/profile', 'error', 'Gagal update DB: ' . $e->getMessage());
        }
    }

    private function processImage($file, $uid = null) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return new Exception("Gagal upload gambar.");
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions)) {
            return new Exception("Ekstensi file tidak didukung.");
        }

        $maxFileSize = 2 * 1024 * 1024; // 2MB
        if ($file['size'] > $maxFileSize) {
            return new Exception("Ukuran file terlalu besar. Maksimal 2MB.");
        }

        $mime = mime_content_type($file['tmp_name']);
        $allowedMimeTypes = ['image/jpeg', 'image/png'];
        if (!in_array($mime, $allowedMimeTypes)) {
            return new Exception("Tipe MIME tidak valid.");
        }

        $uploadDir = ROOT_DIR . '/private-uploads/user-pictures/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid('img_') . '.webp';
        $targetPath = $uploadDir . $fileName;

        $source = null;
        try {
            if ($ext === 'jpg' || $ext === 'jpeg') {
                $source = @imagecreatefromjpeg($file['tmp_name']);
            } elseif ($ext === 'png') {
                $source = @imagecreatefrompng($file['tmp_name']);
            }

            if (!$source) {
                return new Exception("Gagal membaca gambar.");
            }

            $maxWidth = 800;
            $width = imagesx($source);
            $height = imagesy($source);

            if ($width > $maxWidth) {
                $newHeight = intval($height * ($maxWidth / $width));
                $resized = imagecreatetruecolor($maxWidth, $newHeight);
                imagecopyresampled($resized, $source, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                imagedestroy($source);
                $source = $resized;
            }

            if ($ext === 'png') {
                imagealphablending($source, false);
                imagesavealpha($source, true);
            }

            imagewebp($source, $targetPath, 80);
            imagedestroy($source);

            if ($uid) {
                $verifyPicture = $this->ProfileModel->getUserDetail($uid)['profile_picture'];
            
                // Pastikan ada gambar lama dan bukan file default
                if ($verifyPicture && $verifyPicture !== 'default.png') {
                    $oldPath = $uploadDir . $verifyPicture;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }
            

            return $fileName;
        } catch (Exception $e) {
            if ($source) {
                imagedestroy($source);
            }
            return new Exception("Error memproses gambar: " . $e->getMessage());
        }
    }

    public function UpdateData() {
        if (!Helper::is_post() && !isset($_POST['_token']) && !isset($_POST['UpdateData'])) {
            return Helper::redirect('/dashboard/superadmin/profile', 'error', 'Invalid request method.', 0, [
                'fullName' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? ''
            ]);
        }

        $uid = $_SESSION['user']['uid'];
        $data = [
            'full_name' => $_POST['name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'fakultas' => $_POST['fakultas'] ?? '',
            'prodi' => $_POST['prodi'] ?? '',
            'npm_nip' => $_POST['nomorKampus'] ?? '',
            'email' => $_POST['email'] ?? '',
            'posisi' => $_POST['posisi'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'password' => $_POST['password'] ?? '',
            'confirmPassword' => $_POST['confirmPassword'] ?? ''
        ];

        $errors = $this->validateData($data);
        if ($errors) {
            return Helper::redirect('/dashboard/superadmin/profile', 'error', implode(', ', $errors), 0, [
                'fullName' => $data['full_name'],
                'email' => $data['email']
            ]);
        }

        if (!empty($data['password'])) {
            $data['password'] = Helper::hash_password($data['password']);
        } else {
            unset($data['password']);
        }
        unset($data['confirmPassword']);

        try {
            $this->ProfileModel->UpdateData($uid, $data);
            $_SESSION['user']['full_name'] = $data['full_name'];
            $_SESSION['user']['phone'] = $data['phone'];
            $_SESSION['user']['fakultas'] = $data['fakultas'];
            $_SESSION['user']['prodi'] = $data['prodi'];
            $_SESSION['user']['npm_nip'] = $data['npm_nip'];
            $_SESSION['user']['email'] = $data['email'];
            $_SESSION['user']['posisi'] = $data['posisi'];
            $_SESSION['user']['gender'] = $data['gender'];
            return Helper::redirect('/dashboard/superadmin/profile', 'success', 'Data profil berhasil diperbarui.', 0, [
                'fullName' => $data['full_name'],
                'email' => $data['email']
            ]);
        } catch (Exception $e) {
            return Helper::redirect('/dashboard/superadmin/profile', 'error', 'Gagal memperbarui data: ' . $e->getMessage(), 0, [
                'fullName' => $data['full_name'],
                'email' => $data['email']
            ]);
        }
    }
    
    private function validateData($data) {
        $errors = [];

        if (empty($data['full_name'])) $errors[] = 'Nama lengkap wajib diisi.';
        if (empty($data['fakultas'])) $errors[] = 'Fakultas wajib diisi.';
        if (empty($data['prodi'])) $errors[] = 'Program studi wajib diisi.';
        if (empty($data['npm_nip'])) $errors[] = 'NIM/NPM wajib diisi.';
        if (empty($data['email']) || !Helper::is_email($data['email'])) $errors[] = 'Format email tidak valid.';
        if (empty($data['posisi'])) $errors[] = 'Posisi wajib diisi.';
        if (empty($data['gender']) || !in_array($data['gender'], ['Laki-laki', 'Perempuan'])) $errors[] = 'Gender tidak valid.';
        if (!in_array($data['fakultas'], array_column($this->fakultas, 'kode'))) $errors[] = 'Fakultas tidak valid.';

        $isValidProdi = false;
        foreach ($this->prodi as $prodi) {
            if ($prodi['nama'] === $data['prodi'] && $prodi['fakultas'] === $data['fakultas']) {
                $isValidProdi = true;
                break;
            }
        }
        if (!$isValidProdi) $errors[] = $data['prodi'] ? 'Program studi tidak sesuai dengan fakultas.' : 'Program studi tidak valid.';

        if (!empty($data['password'])) {
            if ($data['password'] !== $data['confirmPassword']) $errors[] = 'Password dan konfirmasi password tidak cocok.';
            if (strlen($data['password']) < 8) $errors[] = 'Password minimal 8 karakter.';
        }

        // Periksa duplikasi email, phone, dan npm_nip
        $duplicateErrors = $this->ProfileModel->checkDuplicate($data['email'], $data['phone'], $data['npm_nip'], $_SESSION['user']['uid']);
        $errors = array_merge($errors, $duplicateErrors);

        return $errors;
    }
}
?>