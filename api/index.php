<?php
// Menyinkronkan struktur direktori Serverless Vercel ke Public Laravel
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
require __DIR__ . '/../public/index.php';