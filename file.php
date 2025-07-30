<?php
    // Cegah akses langsung tanpa parameter
    if (!isset($_GET['file'])) {
        die("Access denied.");
    }

    $filename = basename($_GET['file']);
    $subfolder = dirname($_GET['file']);

    // Folder yang diizinkan
    $allowedFolders = ['dummy', 'user-pictures', 'css', 'js'];
    if ($subfolder === "." || !in_array($subfolder, $allowedFolders)) {
        die("Access denied: Invalid folder.");
    }

    $baseUploadDir = __DIR__ . '/private-uploads/';
    $filepath = $baseUploadDir . $_GET['file'];

    // Dummy fallback sesuai MIME type
    $defaultDummyFile = [
        'image/jpeg'             => $baseUploadDir . 'dummy/dummy.jpg',
        'image/png'              => $baseUploadDir . 'dummy/dummy.jpg',
        'image/webp'             => $baseUploadDir . 'dummy/dummy.jpg',
        'text/css'               => __DIR__ . '/resources/assets/css/empty.css',
        'application/javascript' => __DIR__ . '/resources/assets/js/empty.js',
        'text/javascript'        => __DIR__ . '/resources/assets/js/empty.js',
    ];

    // Validasi path dengan realpath untuk mencegah path traversal
    $realBase = realpath($baseUploadDir);
    $realPath = realpath($filepath);
    if ($realPath === false || strpos($realPath, $realBase) !== 0) {
        die("Access denied: Path traversal detected.");
    }

    // Logging akses
    $logDir = __DIR__ . '/app/Storage/logs/';
    $logFile = $logDir . 'file_access.log';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    function safeLog($message, $logFile) {
        if (file_exists(dirname($logFile)) && is_writable(dirname($logFile))) {
            file_put_contents($logFile, $message, FILE_APPEND);
        }
    }
    safeLog(date('Y-m-d H:i:s') . " - Requested: $filepath\n", $logFile);

    // Ekstensi yang diizinkan
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'css', 'js'];
    $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        safeLog(date('Y-m-d H:i:s') . " - Invalid extension: $ext\n", $logFile);
        die("Invalid file extension.");
    }

    // Jika file tidak ditemukan, fallback
    if (!file_exists($filepath)) {
        $mimeFallback = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'css' => 'text/css',
            'js' => 'application/javascript',
        ][$ext] ?? 'application/octet-stream';

        $filepath = $defaultDummyFile[$mimeFallback] ?? die("File not found.");
        safeLog(date('Y-m-d H:i:s') . " - File not found. Fallback to dummy: $filepath\n", $logFile);
    }

    // Deteksi MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $filepath);
    finfo_close($finfo);

    // Fallback MIME jika tidak terdeteksi
    if (!$mime || $mime === 'text/plain') {
        $mime = match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            'webp'        => 'image/webp',
            'css'         => 'text/css',
            'js'          => 'application/javascript',
            default       => 'application/octet-stream',
        };
    }

    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'text/css',
        'application/javascript',
        'text/javascript',
    ];

    // Validasi akhir MIME
    if (!in_array($mime, $allowedMimeTypes)) {
        safeLog(date('Y-m-d H:i:s') . " - Invalid MIME type: $mime\n", $logFile);
        die("Invalid file type.");
    }

    // Output file
    header("Content-Type: $mime");
    header("Content-Length: " . filesize($filepath));
    readfile($filepath);
    exit;
?>
