<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class DeleteVideoController implements Controller {
    public function __construct(private VideoRepository $repository){

    }

    public function handle() {
        $id = $_GET['id'] ?? null;

        $video = $this->repository->find($id);

        if (!$video || $this->repository->remove($id) === false) {
            $_SESSION['erro'] = 'Não foi possível excluir o vídeo.';
            header('Location: /?sucesso=0');
        } else {
            header('Location: /?sucesso=1');
        }
    }

}
