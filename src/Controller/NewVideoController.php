<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Service\UploadService;
use Alura\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewVideoController implements Controller {
    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $queryParsedBody = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $url = filter_var($queryParsedBody['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($queryParsedBody['titulo'], FILTER_SANITIZE_STRING);

        if ($url === false || $titulo === false) {
            $this->addErrorMessage('Preencha todos os campos corretamente.');
            return new Response(302, ['Location' => '/novo-video']);
        }
       
        $video = new Video($titulo, $url);
        $uploadedFileName = UploadService::uploadFile($files['image']);
        if($uploadedFileName) {
            $video->setFilePath($uploadedFileName);
        }
        
        if ($this->repository->add($video) === false) {
            $this->addErrorMessage('Erro ao salvar o video.');
            return new Response(302, ['Location' => '/novo-video']);
        } else {
            return new Response(302, ['Location' => '/']);
        }
    }
}