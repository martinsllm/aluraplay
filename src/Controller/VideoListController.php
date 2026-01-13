<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class VideoListController extends ControllerWithHtml {


    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle() {
        $videoList = $this->repository->all();
        $this->renderTemplate(
            'list-videos', 
            ['videoList' => $videoList]
        );
    }

}