<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRenderTrait;

class LoginFormController {
    
    use HtmlRenderTrait;

    public function __construct() {
        
    }

    public function handle(): void {
        if($_SESSION['logado']) {
            header('Location: /');
            return;
        }
        
        echo $this->renderTemplate('login-form');
    }
}