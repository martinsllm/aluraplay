<?php

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        $dbPath = __DIR__ . '/../banco.sqlite';
        return new PDO("sqlite:$dbPath");
    },
    \League\Plates\Engine::class => function () {
        $templatesPath = __DIR__ . '/../views';
        return new \League\Plates\Engine($templatesPath);
    },
]);

$container = $builder->build();

return $container;