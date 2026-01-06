<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class LoginFormController implements Controller {

    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle(): void {
        require_once __DIR__ . '/../../views/login-form.php';
    }
}