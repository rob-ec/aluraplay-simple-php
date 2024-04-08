<?php

namespace Rob\Aluraplay\Controller;

class VideoListController extends VideoController
{
    public function get(): void
    {
        $videos = $this->repository->all();
        $this->view->load("list-videos.php", vars: ["videos" => $videos]);
    }

    public function processRequest(): void
    {
        $this->get();
    }

}
