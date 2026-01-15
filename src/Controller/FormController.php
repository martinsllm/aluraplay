<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Helper\HtmlRenderTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FormController implements Controller {

    use HtmlRenderTrait;

    public function __construct(private VideoRepository $repository) {
        
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

        return new Response(200, [], $this->renderTemplate('formulario', ['video' => $video]));
    }

}