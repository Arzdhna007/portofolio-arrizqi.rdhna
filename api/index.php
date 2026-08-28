<?php

// 1. Paksa semua error tampil di layar web (X-Ray Mode)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Buat direktori rahasia di dalam RAM Vercel agar Laravel bisa bernapas
$tmpViews = '/tmp/storage/framework/views';
if (!is_dir($tmpViews)) {
    mkdir($tmpViews, 0777, true);
}

// 3. Paksa Laravel menggunakan direktori tersebut
putenv('VIEW_COMPILED_PATH=' . $tmpViews);
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');

// 4. Eksekusi mesin utama
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    // Jika masih crash, cetak pesan errornya dalam huruf tebal di web
    echo "<h1 style='color:red;'>Terjadi Error pada Laravel:</h1>";
    echo "<div style='background:#f4f4f4; padding:20px; border:1px solid #ccc;'>";
    echo "<strong>Pesan:</strong> " . $e->getMessage() . "<br><br>";
    echo "<strong>Lokasi:</strong> " . $e->getFile() . " (Baris " . $e->getLine() . ")";
    echo "</div>";
}