<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Service\UploadService;
use Alura\Mvc\Helper\FlashMessageTrait;

class UpdateVideoController implements Controller {
    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false && $id === null) {
            header('Location: /novo-video');
            exit();
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $titulo = filter_input(INPUT_POST, 'titulo');

        if ($url === false || $titulo === false) {
            $this->addErrorMessage('Preencha todos os campos corretamente.');
            header('Location: /novo-video');
            exit();
        }

        $video = new Video($titulo, $url);
        
        $uploadedFileName = UploadService::uploadFile($_FILES['image']);
        if($uploadedFileName) {
            $video->setFilePath($uploadedFileName);
        }

        $video->setId($id);

        if ($this->repository->update($video) === false) {
            $this->addErrorMessage('Erro ao atualizar o video');
            header('Location: /novo-video');
        } else {
            header('Location: /');
        }
    }

}