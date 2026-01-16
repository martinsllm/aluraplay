<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Service\UploadService;
use Alura\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateVideoController implements Controller {
    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $queryParams = $request->getQueryParams();
        $files = $request->getUploadedFiles();

        $id = filter_var($queryParams['id'], FILTER_SANITIZE_NUMBER_INT);
        if ($id === false && $id === null) {
            return new Response(302, ['Location' => '/editar-video' . '?id=' . $id]);
        }

        $queryParsedBody = $request->getParsedBody();

        $url = filter_var($queryParsedBody['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($queryParsedBody['titulo'], FILTER_SANITIZE_STRING);

        if ($url === false || $titulo === false) {
            $this->addErrorMessage('Preencha todos os campos corretamente.');
            return new Response(302, ['Location' => '/editar-video' . '?id=' . $id]);
        }

        $video = new Video($titulo, $url);
        
        $uploadedFileName = UploadService::uploadFile($files['image']);
        if($uploadedFileName) {
            $video->setFilePath($uploadedFileName);
        }

        $video->setId($id);

        if ($this->repository->update($video) === false) {
            $this->addErrorMessage('Erro ao atualizar o video');
            return new Response(302, ['Location' => '/editar-video' . '?id=' . $id]);
        } else {
            return new Response(302, ['Location' => '/']);
        }
    }

}