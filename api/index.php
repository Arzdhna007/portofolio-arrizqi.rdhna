<?php

// 1. Memaksa Laravel membuang log ke sistem Vercel (bukan ke file)
putenv('LOG_CHANNEL=stderr');

// 2. Memaksa penyimpanan cache dan sesi ke memori/cookie
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');

// 3. Memaksa kompilasi HTML Blade ke folder /tmp (satu-satunya folder yang diizinkan Vercel)
putenv('VIEW_COMPILED_PATH=/tmp');

// 4. Sinkronisasi direktori root
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
require __DIR__ . '/../public/index.php';