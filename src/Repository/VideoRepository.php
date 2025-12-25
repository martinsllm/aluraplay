<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository {

    public function __construct(private PDO $pdo) {

    }

    public function all(): array {
        $sql = 'SELECT * FROM videos;';
        $statement = $this->pdo->query($sql);
        $videoData = $statement->fetchAll(PDO::FETCH_ASSOC);

        $videos = [];
        foreach ($videoData as $videoItem) {
            $video = new Video(
                $videoItem['title'],
                $videoItem['url']
            );
            $video->setId((int)$videoItem['id']);
            $videos[] = $video;
        }
        return $videos;
    }

    public function add(Video $video): bool {
        try {
            $sql = 'INSERT INTO videos (url, title) VALUES (?, ?);';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $video->url);
            $statement->bindValue(2, $video->title);

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
            $sql = 'UPDATE videos SET url = ?, title = ? WHERE id = ?;';
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $video->url);
            $statement->bindValue(2, $video->title);
            $statement->bindValue(3, $video->id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (\Exception $e) {
            throw new \RuntimeException('Erro ao atualizar o video', $e->getMessage());
        }
    }

}