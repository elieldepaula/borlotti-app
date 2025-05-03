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

namespace App\Modules\Web\Controllers;

use Models\User;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use function App\Controllers\request;

class AuthController
{
    protected $view;

    public function __construct()
    {
        $this->view = Twig::fromRequest(request());
    }

    public function showLogin(Request $request, Response $response)
    {
        return $this->view->render($response, 'login.twig');
    }

    public function login(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $user = User::where('email', $data['email'])->first();

        if ($user && password_verify($data['password'], $user->password)) {
            // Simples: salva em sessão (você pode usar um middleware depois)
            $_SESSION['user'] = $user->id;
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        }

        return $this->view->render($response, 'login.twig', ['error' => 'Credenciais inválidas']);
    }

    public function showRegister(Request $request, Response $response)
    {
        return $this->view->render($response, 'register.twig');
    }

    public function register(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $user = new User();
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->save();

        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    public function dashboard(Request $request, Response $response)
    {
        if (!isset($_SESSION['user'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }
        return $this->view->render($response, 'dashboard.twig');
    }
}
