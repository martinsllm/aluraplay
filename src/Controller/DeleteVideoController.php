<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Helper\FlashMessageTrait;

class DeleteVideoController implements Controller {

    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository){

    }

    public function handle() {
        $id = $_GET['id'] ?? null;

        $video = $this->repository->find($id);

        if (!$video || $this->repository->remove($id) === false) {
            $this->addErrorMessage('Não foi possível excluir o vídeo.');
            header('Location: /');
        } else {
            header('Location: /');
        }
    }

}
