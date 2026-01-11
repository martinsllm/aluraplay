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
            if(password_needs_rehash($user['password'], PASSWORD_BCRYPT)) {
                $newHash = password_hash($password, PASSWORD_BCRYPT);
                $this->repository->updatePassword($user['id'], $newHash);
            }
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            $_SESSION['erro'] = "Login ou senha incorretos!";
            header('Location: /login?sucesso=0');
        }
    }
}