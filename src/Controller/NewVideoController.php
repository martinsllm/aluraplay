<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class NewVideoController implements Controller {
    public function __construct(private VideoRepository $repository) {
        
    }

    public function handle(){
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $titulo = filter_input(INPUT_POST, 'titulo');

        if ($url === false || $titulo === false) {
            $_SESSION['erro'] = 'Preencha todos os campos corretamente.';
            header('Location: /?sucesso=0');
            exit();
        }
       
        $video = new Video($titulo, $url);
        if($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $safeFileName = uniqid('image_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);

            if(str_starts_with($mimeType, 'image/')) {
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setFilePath($safeFileName);
            }   
        }

        if ($this->repository->add($video) === false) {
            $_SESSION['erro'] = 'Erro ao salvar o video.';
            header('Location: /?sucesso=0');
        } else {
            header('Location: /?sucesso=1');
        }
    }
}