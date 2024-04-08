<?php

namespace Rob\Aluraplay\Repositories;

use Rob\Aluraplay\Core\ConnectionCreator;
use Rob\Aluraplay\Model\Video;
use PDO;
use PDOException;
use PDOStatement;

/**
 * @throws PDOException
 */
class VideoRepository
{
    private PDO $connection;
    private string $table = 'videos';

    public function __construct(?PDO $connection = null)
    {
        $this->connection = $connection ?? ConnectionCreator::create();
    }

    private function hidratateData(array $videoData): Video
    {
        return new Video(
            id: $videoData['id'],
            url: $videoData['url'],
            title: $videoData['title'],
            imagePath: $videoData['image_path']
        );
    }

    /**
     * @return Video[]
     */
    private function hidratateRows(PDOStatement $stmt): array
    {
        $rows = $stmt->fetchAll();
        $hidratatedContent = [];

        foreach ($rows as $videoData) {
            $hidratatedContent[] = $this->hidratateData($videoData);
        }

        return $hidratatedContent;
    }

    /**
     * @return Video[]
     */
    public function all(): array
    {
        $querySelectAll = "SELECT * FROM {$this->table};";

        $stmt = $this->connection->prepare($querySelectAll);
        $stmt->execute();

        return $this->hidratateRows($stmt);
    }

    public function findByID(int $id): Video
    {
        $querySelectById = "SELECT * FROM {$this->table} WHERE id = :id;";

        $stmt = $this->connection->prepare($querySelectById);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $this->hidratateData($stmt->fetch());
    }

    public function update(Video $video): bool
    {
        $queryUpdateVideo = "UPDATE {$this->table} SET url = :url, title = :title, image_path = :image_path WHERE id = :id;";
        $stmt = $this->connection->prepare($queryUpdateVideo);
        $stmt->bindValue(":id", $video->id(), PDO::PARAM_INT);
        $stmt->bindValue(":url", $video->url());
        $stmt->bindValue(":title", $video->title());
        $stmt->bindValue(":image_path", $video->imagePath());

        return $stmt->execute();
    }

    public function save(Video $video): bool
    {
        $querySaveVideo = "INSERT INTO {$this->table} (url, title, image_path) VALUES (:url, :title, :image_path);";

        $stmt = $this->connection->prepare($querySaveVideo);
        $success = $stmt->execute([
            ":url" => $video->url(),
            ":title" => $video->title(),
            ":image_path" => $video->imagePath(),
        ]);

        if ($success) {
            $id = $this->connection->lastInsertId();
            $video->defineId($id);
        }

        return $success;
    }

    public function delete(int $id): bool
    {
        $queryDeleteVideo = "DELETE FROM {$this->table} WHERE id = :id;";
        $stmt = $this->connection->prepare($queryDeleteVideo);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
