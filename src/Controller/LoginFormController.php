<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRenderTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginFormController implements RequestHandlerInterface {
    
    use HtmlRenderTrait;

    public function __construct() {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        if($_SESSION['logado']) {
            return new Response(302, ['Location' => '/']);
        }

        return new Response(200, [], $this->renderTemplate('login-form'));
    }
}