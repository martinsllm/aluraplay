<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoListController implements RequestHandlerInterface {
    
    public function __construct(private VideoRepository $repository, private Engine $templates) {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $videoList = $this->repository->all();
        return new Response(200, [], $this->templates->render('list-videos', ['videoList' => $videoList]));
    }

}