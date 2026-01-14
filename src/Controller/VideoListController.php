<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Helper\HtmlRenderTrait;

class VideoListController {

    use HtmlRenderTrait;
    
    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle() {
        $videoList = $this->repository->all();
        
        echo $this->renderTemplate(
            'list-videos', 
            ['videoList' => $videoList]
        );
    }

}