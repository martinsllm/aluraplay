<?php

namespace Alura\Mvc\Service;

class UploadService {
    public static function uploadFile(array $file): ?string {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $safeFileName = uniqid('image_') . '_' . basename($file['name']);
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file['tmp_name']);

            if (str_starts_with($mimeType, 'image/')) {
                move_uploaded_file(
                    $file['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                return $safeFileName;
            }
        }
        return null;
    }
}