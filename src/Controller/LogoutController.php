<?php

namespace Alura\Mvc\Controller;

class LogoutController implements Controller {
    public function handle(): void {
        session_destroy();
        header('Location: /login');
        return;
    }
}