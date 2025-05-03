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

use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader();

/**
 * Set the path to the application templates. You can also use namespaces on the second parameter.
 */
$loader->addPath(BASE_PATH . 'src/Modules/Web/Views');

return $loader;
