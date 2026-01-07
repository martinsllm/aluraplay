<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class VideoListController implements Controller {


    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle() {
        session_start();
        if(!array_key_exists('logado', $_SESSION) || !$_SESSION['logado']){
            header('Location: /login');
            return;
        }

        $videoList = $this->repository->all();
        require_once __DIR__ . '/../../views/list-videos.php';
    }

}