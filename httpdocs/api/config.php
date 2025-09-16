<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'km616q2x_Sql1234567_1');
define('DB_USER', 'km616q2x_picco');
define('DB_PASS', 'FLstudio2025!');
define('SITE_URL', 'https://pictotune.com');
define('SITE_NAME', 'PictoTune');
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('AUDIO_DIR', __DIR__ . '/../audio/');
define('JWT_SECRET', '12e4e8c4e2826b347bbe2f514a7690a98cf8b65681eb0c1f5e4589e586f6ccc8');
define('CREDITS_PER_GENERATION', 10);
define('MAX_FILE_SIZE', 10 * 1024 * 1024);

// API Keys (da configurare)
define('STABILITY_API_KEY', '');
define('MUBERT_API_KEY', '');
define('GUMROAD_SECRET', '');

date_default_timezone_set('Europe/Rome');
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');