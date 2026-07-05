<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_PATH', dirname(__DIR__));
$docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
$rootReal = str_replace('\\', '/', realpath(ROOT_PATH));
define('BASE_URL', rtrim(str_replace($docRoot, '', $rootReal), '/'));

$config = require ROOT_PATH . '/config/config.php';

require_once ROOT_PATH . '/includes/database.php';
require_once ROOT_PATH . '/includes/helpers.php';
require_once ROOT_PATH . '/includes/auth.php';
require_once ROOT_PATH . '/includes/Department.php';
require_once ROOT_PATH . '/includes/HodUser.php';
require_once ROOT_PATH . '/includes/Submission.php';
