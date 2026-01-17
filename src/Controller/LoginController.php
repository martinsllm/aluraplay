<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;
use Alura\Mvc\Service\CsrfTokenService;
use Alura\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface {

    use FlashMessageTrait;

    public function __construct(private UserRepository $repository) {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $queryParsedBody = $request->getParsedBody();

        // Validar token CSRF
        $csrfToken = $queryParsedBody['csrf_token'] ?? '';
        if (!CsrfTokenService::validateToken($csrfToken)) {
            $this->addErrorMessage('Token de segurança inválido. Tente novamente.');
            return new Response(302, ['Location' => '/login']);
        }

        $email = filter_var($queryParsedBody['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($queryParsedBody['password'], FILTER_SANITIZE_STRING);

        $user = $this->repository->fetchUserByEmail($email);
        $correctPassword = password_verify($password, $user['password'] ?? '');

        if($correctPassword){
            if(password_needs_rehash($user['password'], PASSWORD_BCRYPT)) {
                $newHash = password_hash($password, PASSWORD_BCRYPT);
                $this->repository->updatePassword($user['id'], $newHash);
            }
            $_SESSION['logado'] = true;
            // Regenerar token após sucesso
            CsrfTokenService::regenerateToken();
            return new Response(302, ['Location' => '/']);
        } else {
            $this->addErrorMessage("Login ou senha incorretos!");
            return new Response(302, ['Location' => '/login']);
        }
    }
}