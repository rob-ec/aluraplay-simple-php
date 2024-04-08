<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Rob\Aluraplay\Core\ConnectionCreator;
use Rob\Aluraplay\Model\Video;
use Rob\Aluraplay\Repositories\VideoRepository;

try {
    /**
     * @var array<Video>
     */
    $videos = [
        new Video(
            id: null,
            url: "https://www.youtube.com/embed/11BLV208rqY",
            title: "O Brasil dos Bancos",
            imagePath: null,
        ),
        new Video(
            id: null,
            url: "https://www.youtube.com/embed/3H09RDzA0sw",
            title: "Devin AI, Laravel 11, GPT-4 Turbo liberado, Vazamentos no Github, Midjourney vs Stability #141",
            imagePath: null,
        ),
        new Video(
            id: null,
            url: "https://www.youtube.com/embed/pb4b4_MlNwo",
            title: "INTELIGÊNCIA ARTIFICIAL: TUDO O QUE VOCÊ PRECISA SABER - MIGUEL NICOLELIS - Programa 20 Minutos",
            imagePath: null,
        ),
        new Video(
            id: null,
            url: "https://www.youtube.com/embed/WHdLTiVW8Zc",
            title: "Física quântica e computação quântica para leigos - Fork Podcast #51",
            imagePath: null,
        ),
        new Video(
            id: null,
            url: "https://www.youtube.com/embed/nWQXlYFCX0k",
            title: "Por que a simplicidade é essencial na ciência?",
            imagePath: null,
        ),
    ];

    $connection = ConnectionCreator::create();
    $repository = new VideoRepository($connection);

    $connection->beginTransaction();

    foreach ($videos as $video) {
        $repository->save($video);
    }
    
    $connection->commit();

} catch (InvalidArgumentException $ex) {
    echo "Argumento inválido: " . $ex->getMessage() . PHP_EOL;
} catch (PDOException $ex) {
    echo "Erro na conexão com o banco de dados: " . $ex->getMessage() . PHP_EOL;
} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}
