<?php

namespace Alura\Mvc\Service;
use Psr\Http\Message\UploadedFileInterface;

class UploadService {
    public static function uploadFile(UploadedFileInterface $file): ?string {
        if ($file->getError() === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $file->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            if(str_starts_with($mimeType, 'image/')){
                $safeFileName = uniqid('image_') . '_' . basename($file->getClientFilename());
                $file->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                return $safeFileName;
            }
        }
        return null;
    }
}