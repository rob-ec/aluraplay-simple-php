<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Core\Redirector;
use Rob\Aluraplay\Model\Video;

class VideoCreateController extends VideoController
{
    public function get(): void
    {
        $this->view->load("form-video.php", ["video" => null]);
    }

    public function post(): void
    {
        $message = [
            'success' => false,
        ];

        if ($this->request->issetOnPost("form-video")) {
            $url = $this->request->post('url', FILTER_VALIDATE_URL);
            $title = $this->request->post('titulo');

            if ($url && $title) {
                $video = new Video(
                    id: null,
                    url: $url,
                    title: $title
                );

                if ($image = $this->request->file("image", fileType: 'image')) {
                    $systemImagePath = $_ENV['THUMBNAIL_PATH'] ?? "assets/img/thumbs/";
                    $safeFileName = uniqid("upload_thumb_") . basename($image['name']);
                    $video->defineImagePath($safeFileName);

                    move_uploaded_file($image['tmp_name'], $video->imagePath(prefix: $systemImagePath));
                }

                $message['success'] = $this->repository->save($video);
            }
        }

        Redirector::redirectTo("/", $message);
    }

    public function processRequest(): void
    {
        $this->onlyUsers();

        if ($this->request->method === 'GET') {
            $this->get();
        }

        if ($this->request->method === 'POST') {
            $this->post();
        }
    }
}
