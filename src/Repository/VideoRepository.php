<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository {

    public function __construct(private PDO $pdo) {

    }

    private function hydrateVideo(array $videoData): Video {
        $video = new Video(
            $videoData['title'],
            $videoData['url']
        );
        $video->setId((int)$videoData['id']);
        
        if ($videoData['image_path'] !== null) {
            $video->setFilePath($videoData['image_path']);
        }
        return $video;
    }

    public function find(int $id): Video {
        try {
            $sql = 'SELECT * FROM videos WHERE id = ?;';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $id, PDO::PARAM_INT);
            $statement->execute();
            $video = $statement->fetch(PDO::FETCH_ASSOC);
            return $this->hydrateVideo($video);
        } catch (\Exception $e) {
            throw new \RuntimeException('Erro ao buscar o video:', $e->getMessage());
        }
    }

    public function all(): array {
        $sql = 'SELECT * FROM videos;';
        $statement = $this->pdo->query($sql);
        $videoData = $statement->fetchAll(PDO::FETCH_ASSOC);

        $videos = [];
        foreach ($videoData as $videoItem) {
            $video = $this->hydrateVideo($videoItem);
            $videos[] = $video;
        }
        return $videos;
    }

    public function add(Video $video): bool {
        try {
            $sql = 'INSERT INTO videos (url, title, image_path) VALUES (?, ?, ?);';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $video->url);
            $statement->bindValue(2, $video->title);
            $statement->bindValue(3, $video->getFilePath());

            $result = $statement->execute();
            $id = $this->pdo->lastInsertId();

            $video->setId((int)$id);
            return $result;
        } catch (\Exception $e) {
            throw new \RuntimeException('Erro ao salvar o video', $e->getMessage());
        }
    }

    public function remove(int $id): bool {
        $sql = 'DELETE FROM videos WHERE id = ?;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function update(Video $video): bool {
        try {
            $updateImageSql = '';
            if ($video->getFilePath() !== null) {
                $updateImageSql = ', image_path = :image_path';
            }
            $sql = 'UPDATE videos SET url = :url, title = :title' . $updateImageSql . ' WHERE id = :id;';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':url', $video->url);
            $statement->bindValue(':title', $video->title);
            if ($video->getFilePath() !== null) {
                $statement->bindValue(':image_path', $video->getFilePath());
            }
            $statement->bindValue(':id', $video->id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (\Exception $e) {
            throw new \RuntimeException('Erro ao atualizar o video', $e->getMessage());
        }
    }

    public function removeImage(int $id): bool {
        try {
            $sql = 'UPDATE videos SET image_path = NULL WHERE id = ?;';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (\Exception $e) {
            throw new \RuntimeException('Erro ao remover a imagem do video', $e->getMessage());
        }
    }

}