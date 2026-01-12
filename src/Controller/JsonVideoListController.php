<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class JsonVideoListController implements Controller {
    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle() {
        $videoList = array_map(
            fn($video) => [
                'title' => $video->title,
                'url' => $video->url,
                'file_path' => '/img/uploads/' . $video->getFilePath()
            ],
            $this->repository->all()
        );
        header('Content-Type: application/json');
        echo json_encode($videoList);
    }
}