<?php

namespace Alura\Mvc\Controller;

class LoginFormController extends ControllerWithHtml {

    public function __construct() {
        
    }

    public function handle(): void {
        if($_SESSION['logado']) {
            header('Location: /');
            return;
        }
        
        $this->renderTemplate('login-form');
    }
}