<?php

namespace Rob\Aluraplay\Controller;

class JsonVideoListController extends VideoController
{
    public function get(): void
    {
        $videos = $this->repository->all();

        echo json_encode($videos);
    }
    public function processRequest(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->get();
    }
}
