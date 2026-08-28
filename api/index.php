<?php

// 1. Tangkap semua Fatal Error yang menyebabkan layar 500 Vercel
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'DIAGNOSTIC_STATUS' => 'LARAVEL_CRASHED',
            'ERROR_MESSAGE' => $error['message'],
            'FILE_LOCATION' => $error['file'],
            'LINE' => $error['line']
        ]);
        exit;
    }
});

// 2. Jalur Tes Eksekusi Murni (Bypass Laravel)
if (isset($_GET['ping'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'Mesin PHP Vercel menyala dan berfungsi normal.']);
    exit;
}

// 3. Validasi kegagalan build Composer Vercel
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'DIAGNOSTIC_STATUS' => 'MISSING_VENDOR',
        'ERROR_MESSAGE' => 'Folder /vendor tidak ditemukan. Vercel gagal menjalankan composer install.'
    ]);
    exit;
}

// 4. Adaptasi Storage Serverless
putenv('VIEW_COMPILED_PATH=/tmp');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');

// 5. Eksekusi Laravel
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
require __DIR__ . '/../public/index.php';