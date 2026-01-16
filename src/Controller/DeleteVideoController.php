<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteVideoController implements RequestHandlerInterface {

    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository){

    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_SANITIZE_STRING);
        if(!$id) {
            $this->addErrorMessage('ID inválido.');
            return new Response(302, ['Location' => '/']);
        }

        $video = $this->repository->find($id);

        if (!$video || $this->repository->remove($id) === false) {
            $this->addErrorMessage('Não foi possível excluir o vídeo.');
            return new Response(302, ['Location' => '/']);
        } else {
            return new Response(302, ['Location' => '/']);
        }
    }

}
