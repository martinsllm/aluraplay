<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Helper\FlashMessageTrait;

class DeleteImageController implements Controller {

    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository){

    }

    public function handle() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

        $video = $this->repository->find($id);
        if(!$video) {
            $this->addErrorMessage('Não foi possível remover a capa.');
            header('Location: /');
            exit();
        }

        $filePath = __DIR__ . '/../../public/img/uploads/' . $video->getFilePath();

        if ($video->getFilePath() && file_exists($filePath)) {
            unlink($filePath);
            $this->repository->removeImage($id);
            header('Location: /');
        } else {
            $this->addErrorMessage("Arquivo não encontrado.");
            header('Location: /');
        }
    }
}