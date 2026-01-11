<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class DeleteImageController implements Controller {

    public function __construct(private VideoRepository $repository){

    }

    public function handle() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

        $video = $this->repository->find($id);
        $filePath = __DIR__ . '/../../public/img/uploads/' . $video->getFilePath();

        if ($video->getFilePath() && file_exists($filePath)) {
            unlink($filePath);
            $this->repository->removeImage($id);
            header('Location: /?sucesso=1');
        } else {
            $_SESSION['erro'] = "Arquivo não encontrado.";
            header('Location: /?sucesso=0');
        }
    }
}