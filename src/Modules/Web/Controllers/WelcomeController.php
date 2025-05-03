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

use App\Models\User;
use Borlotti\Core\Api\DateInterface;
use Borlotti\Core\Api\EncryptInterface;
use Borlotti\Core\Api\JsonInterface;
use Borlotti\Core\Api\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class WelcomeController extends BaseController
{

    /**
     * Class constructor.
     *
     * @param User $user
     * @param LoggerInterface $logger
     * @param EncryptInterface $encrypt
     * @param JsonInterface $json
     * @param DateInterface $date
     * @param SessionInterface $session
     */
    public function __construct(
        protected User $user,
        protected LoggerInterface $logger,
        protected EncryptInterface $encrypt,
        protected JsonInterface $json,
        protected DateInterface $date,
        protected SessionInterface $session
    ) {
        parent::__construct();
    }

    public function index(Request $request, Response $response): ResponseInterface
    {
        try {
            $result = $this->user->find(1);
            return $this->render('welcome/index.twig', ['user' => $result], $request, $response);
        } catch ( \Exception $e) {
            $this->logger->error($e->getMessage());
            $response->getBody()->write($e->getMessage());
            return $response;
        }
    }

    public function examples(Request $request, Response $response): ResponseInterface
    {

        $output = [];

        //--------------------------------------------------------------------------------------------------------------
        // Encrypt
        //--------------------------------------------------------------------------------------------------------------

        // Gera uma chave segura
        $key = 'minha-senha-secreta';

        // Criptografa dados
        $token = $this->encrypt->encrypt('texto confidencial', $key);

        // Descriptografa
        $original = $this->encrypt->decrypt($token, $key);

        // Hash de senha
        $hash = $this->encrypt->hash('minhaSenha123');
        $valido = $this->encrypt->verify('minhaSenha123', $hash);

        $output['key'] = $key;
        $output['token'] = $token;
        $output['original'] = $original;
        $output['hash'] = $hash;
        $output['valido'] = $valido;

        //--------------------------------------------------------------------------------------------------------------
        // Json
        //--------------------------------------------------------------------------------------------------------------

        try {

            $json = $this->json->encode(['foo' => 'bar', 'loren' => 'ipsum']);
            $output['json'] = $json;

            $array = $this->json->decode($json);
            $output['array'] = $array;

        } catch (\Exception $e) {
            $output['json_error'] = $e->getMessage();
        }

        //--------------------------------------------------------------------------------------------------------------
        // Date
        //--------------------------------------------------------------------------------------------------------------

        $now = $this->date->now();

        $output['data_atual'] = $now->format('Y-m-d H:i:s');
        $output['data_formatada'] = $this->date->fromTimestamp(1704063600)->format('d/m/Y H:i');
        $output['data_timestamp'] = $this->date->toTimestamp('2025-05-01 15:30:00');
        $output['data_localizada_pt'] = $this->date->formatLocalized('2025-05-01 15:30:00', 'pt_BR');
        $output['data_localizada_fr'] = $this->date->formatLocalized('2025-05-01 15:30:00', 'fr_FR');

        //--------------------------------------------------------------------------------------------------------------
        // Session
        //--------------------------------------------------------------------------------------------------------------

        // $this->session->useDatabaseHandler();

        $output['session_id'] = $this->session->getId();

        $this->session->set('user_id', 123);
        $id = $this->session->get('user_id');
        $output['user_id_recuperado'] = $id;

        $this->session->flash('success', 'Usuário salvo com sucesso');
        $output['flash_message'] = $this->session->getFlash('success');

        $this->session->regenerate(); // troca o ID de sessão
        $this->session->destroy();    // encerra a sessão

        $this->logger->info('Exemplos executados com sucesso!');

        return $this->render('welcome/examples.twig', $output, $request, $response);
    }
}