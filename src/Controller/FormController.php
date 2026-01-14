<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Helper\HtmlRenderTrait;

class FormController {

    use HtmlRenderTrait;

    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $video = [
            'url' => '',
            'title' => '',
        ];

        if ($id !== false && $id !== null) {
            $video = $this->repository->find($id);
        }

        echo $this->renderTemplate(
            'formulario',
            ['video' => $video]
        );
    }

}