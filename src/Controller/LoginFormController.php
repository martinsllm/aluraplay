<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRenderTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginFormController implements Controller {
    
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