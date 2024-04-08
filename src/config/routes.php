<?php

declare(strict_types=1);

return [
    "GET|/" => \Rob\Aluraplay\Controller\VideoListController::class,
    "GET|/videos/json" => \Rob\Aluraplay\Controller\JsonVideoListController::class,
    "GET|/adicionar-video" => \Rob\Aluraplay\Controller\VideoCreateController::class,
    "POST|/adicionar-video" => \Rob\Aluraplay\Controller\VideoCreateController::class,
    "GET|/editar-video" => \Rob\Aluraplay\Controller\VideoEditController::class,
    "POST|/editar-video" => \Rob\Aluraplay\Controller\VideoEditController::class,
    "GET|/remover-imagem-video" => \Rob\Aluraplay\Controller\VideoRemoveThumbController::class,
    "GET|/excluir-video" => \Rob\Aluraplay\Controller\VideoDeleteController::class,
    "GET|/login" => \Rob\Aluraplay\Controller\LoginFormController::class,
    "POST|/login" => \Rob\Aluraplay\Controller\LoginController::class,
    "GET|/sair" => \Rob\Aluraplay\Controller\LogoutController::class,
    "404" => \Rob\Aluraplay\Controller\NotFoundController::class,
];
