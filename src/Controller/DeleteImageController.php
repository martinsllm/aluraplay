<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteImageController implements RequestHandlerInterface {

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
        if(!$video) {
            $this->addErrorMessage('Não foi possível remover a capa.');
            return new Response(302, ['Location' => '/']);
        }

        $filePath = __DIR__ . '/../../public/img/uploads/' . $video->getFilePath();

        if ($video->getFilePath() && file_exists($filePath)) {
            unlink($filePath);
            $this->repository->removeImage($id);
            return new Response(302, ['Location' => '/']);
        } else {
            $this->addErrorMessage("Arquivo não encontrado.");
            return new Response(302, ['Location' => '/']);
        }
    }
}