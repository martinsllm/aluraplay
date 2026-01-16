<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonVideoListController implements RequestHandlerInterface {
    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $videoList = array_map(
            fn($video) => [
                'title' => $video->title,
                'url' => $video->url,
                'file_path' => '/img/uploads/' . $video->getFilePath()
            ],
            $this->repository->all()
        );
        return new Response(200, ['Content-Type: application/json'], json_encode($videoList));
    }
}