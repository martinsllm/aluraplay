<?php

namespace Alura\Mvc\Controller;

class LoginFormController implements Controller {

    public function __construct() {
        
    }

    public function handle(): void {
        if($_SESSION['logado']) {
            header('Location: /');
            return;
        }
        
        require_once __DIR__ . '/../../views/login-form.php';
    }
}