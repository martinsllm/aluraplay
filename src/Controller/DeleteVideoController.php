<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class DeleteVideoController implements Controller {
    public function __construct(private VideoRepository $repository){

    }

    public function handle() {
        $id = $_GET['id'] ?? null;

        if ($this->repository->remove($id) === false) {
            header('Location: /?sucesso=0');
        } else {
            header('Location: /?sucesso=1');
        }
    }

}
