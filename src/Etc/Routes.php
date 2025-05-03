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

/**
 * Defines the application routes.
 *
 * Definition:
 * 
 * [
 *     'routeName' => [
 *         'path' => '/',
 *         'verb' => 'GET',
 *         'callable' => [App\Controllers\HomeController::class,'index'],
 *         'middleware' => null
 *     ],
 *     'test' => [
 *         'path' => '/test',
 *         'verb' => 'GET',
 *         'callable' => function (\Slim\Psr7\Request $request, \Slim\Psr7\Response $response) {
 *             $response->getBody()->write('Teste 1, 2, 3');
 *             return $response;
 *         },
 *         'middleware' => null
 *     ]
 * ]
 *
 * @return array
 */
return [
    'welcome' => [
        'path' => '/',
        'verb' => 'GET',
        'callable' => [\App\Modules\Web\Controllers\WelcomeController::class,'index'],
        'middleware' => null
    ],
    'examples-lib' => [
        'path' => '/testes',
        'verb' => 'GET',
        'callable' => [\App\Modules\Web\Controllers\WelcomeController::class,'examples'],
        'middleware' => null
    ],
];
