<?php

namespace Alura\Mvc\Controller;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Error404Controller implements Controller {
    public function __construct() {
        
    }
    public function handle(ServerRequestInterface $request): ResponseInterface {
        return new Response(404, [], '');
    }
}