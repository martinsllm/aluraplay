<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class VideoListController implements Controller {


    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle() {
        $videoList = $this->repository->all();
        require_once __DIR__ . '/../../views/list-videos.php';
    }

}