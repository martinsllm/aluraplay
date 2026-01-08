<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;

class LoginController implements Controller {

    public function __construct(private UserRepository $repository) {
        
    }

    public function handle(): void {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $user = $this->repository->fetchUserByEmail($email);
        $correctPassword = password_verify($password, $user['password'] ?? '');

        if($correctPassword){
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}