<?php

namespace Alura\Mvc\Controller;

use Nyholm\Psr7\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginFormController implements RequestHandlerInterface {

    public function __construct(private Engine $templates) {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        if($_SESSION['logado']) {
            return new Response(302, ['Location' => '/']);
        }

        return new Response(200, [], $this->templates->render('login-form'));
    }
}