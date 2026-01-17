<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormController implements RequestHandlerInterface {

    public function __construct(private VideoRepository $repository, private Engine $templates) {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $queryParams = $request->getQueryParams();
        $id = (int) filter_var($queryParams['id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        $video = (object)[
            'url' => '',
            'title' => '',
        ];

        if ($id !== false && $id !== null) {
            $video = $this->repository->find($id);
        }

        return new Response(200, [], $this->templates->render('formulario', ['video' => $video]));
    }

}