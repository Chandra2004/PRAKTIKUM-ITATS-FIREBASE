<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . $path;

// File yang diperbolehkan diakses langsung
$allowedFiles = [
    '/index.php',
    '/file.php'
];

// Folder yang diperbolehkan diakses langsung
$allowedFolder = '/private-uploads/';

// Izinkan akses ke file tertentu
if (in_array($path, $allowedFiles)) {
    return false;
}

// Izinkan akses ke folder private-uploads
if (strpos($path, $allowedFolder) === 0 && file_exists($file)) {
    return false;
}

// Izinkan root (/) → arahkan ke index.php
if ($path === '/' || $path === '') {
    require_once __DIR__ . '/index.php';
    exit;
}

// Jika file ada tapi tidak diizinkan → 403
if (file_exists($file)) {
    http_response_code(403);
    echo "403 Forbidden";
    exit;
}

// Untuk semua request lain arahkan ke index.php
require_once __DIR__ . '/index.php';
