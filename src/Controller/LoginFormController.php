<?php

namespace Alura\Mvc\Controller;

class LoginFormController implements Controller {

    public function __construct() {
        
    }

    public function handle(): void {
        require_once __DIR__ . '/../../views/login-form.php';
    }
}