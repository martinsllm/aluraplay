<?php

return [
    'GET|/' => Alura\Mvc\Controller\VideoListController::class,
    'GET|/novo-video' => Alura\Mvc\Controller\FormController::class,
    'POST|/novo-video' => Alura\Mvc\Controller\NewVideoController::class,
    'GET|/editar-video' => Alura\Mvc\Controller\FormController::class,
    'POST|/editar-video' => Alura\Mvc\Controller\UpdateVideoController::class,
    'GET|/remover-video' => Alura\Mvc\Controller\DeleteVideoController::class,
    'GET|/login' => Alura\Mvc\Controller\LoginFormController::class,
    'POST|/login' => Alura\Mvc\Controller\LoginController::class,
];