<?php

namespace Alura\Mvc\Helper;

trait FlashMessageTrait {

    private function addErrorMessage(string $message): void {
        $_SESSION['erro'] = $message;
    }
   
}