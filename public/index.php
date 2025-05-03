<?php

/**
 * Copyright (c) 2025 - Borlotti Project.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Eliel de Paula <elieldepaula@gmail.com>
 * @license     https://www.opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

use Dotenv\Dotenv;
use Borlotti\Core\Bootstrap;

define('BASE_PATH', __DIR__ . '/../');
define('APP_PATH', BASE_PATH . 'src/');

require_once BASE_PATH . 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

define('ENVIRONMENT', $_ENV['APP_ENV'] ?? 'development');

date_default_timezone_set($_ENV['TIMEZONE']);

$configs = [
    'development' => [
        'error_reporting' => -1,
        'display_errors' => 1,
    ],
    'production' => [
        'error_reporting' => E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED,
        'display_errors' => 0,
    ],
];

if (!isset($configs[ENVIRONMENT])) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'The application environment is not set correctly.';
    exit(1);
}

error_reporting($configs[ENVIRONMENT]['error_reporting']);
ini_set('display_errors', $configs[ENVIRONMENT]['display_errors']);

$app = new Bootstrap();
$app->setRoutes(require APP_PATH . 'Etc/Routes.php')
    ->setDependencies(require APP_PATH . 'Etc/Di.php')
    ->setTemplatesPath(APP_PATH)
    ->run();