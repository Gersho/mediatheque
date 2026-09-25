<?php
// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: 'mediatheque_db');
define('DB_NAME', getenv('DB_NAME') ?: 'mediatheque_db');
define('DB_USER', getenv('DB_USER') ?: 'mediauser');
define('DB_PASS', getenv('DB_PASS') ?: 'mediapassword123');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

// General Application Configuration
define('BASE_URL', getenv('BASE_URL') ?: 'https://mediatheque.zennoune.fr');
define('APP_NAME', getenv('APP_NAME') ?: 'Médiathèque Lyon 5');
define('APP_VERSION', getenv('APP_VERSION') ?: '1.0.0');

// System Paths
define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CONTROLLER_PATH', ROOT_PATH . '/controllers');
define('MODEL_PATH', ROOT_PATH . '/models');
define('VIEW_PATH', ROOT_PATH . '/views');
define('INCLUDE_PATH', ROOT_PATH . '/includes');
define('CORE_PATH', ROOT_PATH . '/core');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Uploads & Application Options
define('LOG_PATH', ROOT_PATH . '/logs');
define('UPLOAD_URL', (getenv('BASE_URL') ?: 'https://mediatheque.zennoune.fr') . '/uploads/covers');
define('UPLOAD_PATH', ROOT_PATH . '/uploads/covers');
define('UPLOAD_MAX_SIZE', (int)(getenv('UPLOAD_MAX_SIZE') ?: 2097152)); // 2MB default
define('MAX_MEDIA_PER_PAGE', (int)(getenv('MAX_MEDIA_PER_PAGE') ?: 12));
define('DEBUG', filter_var(getenv('DEBUG') ?: true, FILTER_VALIDATE_BOOLEAN));
define('RETURN_DELAY', (int)(getenv('RETURN_DELAY') ?: 14)); // Days
define('SESSION_TIMEOUT', (int)(getenv('SESSION_TIMEOUT') ?: 7200)); // Seconds