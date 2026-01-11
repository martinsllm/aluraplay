<?php

use Alura\Mvc\Controller\VideoListController;
use Alura\Mvc\Controller\FormController;
use Alura\Mvc\Controller\NewVideoController;
use Alura\Mvc\Controller\LoginController;
use Alura\Mvc\Controller\UpdateVideoController;
use Alura\Mvc\Controller\DeleteVideoController;
use Alura\Mvc\Controller\Error404Controller;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Repository\UserRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideoRepository($pdo);
$userRepository = new UserRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php';
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

session_start();
session_regenerate_id();
$isLoginRoute = $pathInfo === '/login';
if(!array_key_exists('logado', $_SESSION) && !$isLoginRoute){
    header('Location: /login');
    return;
}

$key = "$httpMethod|$pathInfo";

if(array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];

    if($isLoginRoute && $httpMethod === 'POST') {
        $controller = new LoginController($userRepository);
    } else {
        $controller = new $controllerClass($videoRepository);
    }
} else {
    $controller = new Error404Controller();
}

$controller->handle();

