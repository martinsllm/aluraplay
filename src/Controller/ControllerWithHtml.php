<?php

namespace Alura\Mvc\Controller;

abstract class ControllerWithHtml implements Controller {

    private const TEMPLATE_PATH = __DIR__ . '/../../views/';

    protected function renderTemplate(string $templateName, array $context=[]): string {
        extract($context);
        require_once  self::TEMPLATE_PATH . $templateName . '.php';
    }
    
}