<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Core\Redirector;
use Rob\Aluraplay\Model\Video;

class VideoEditController extends VideoController
{
    public function get(): void
    {
        $id = $this->request->get('id', FILTER_VALIDATE_INT);

        if (!$id) {
            Redirector::redirectTo("/");
            return;
        }

        $this->view->load("form-video.php", vars: [
            "video" => $this->repository->findByID($id),
        ]);
    }

    public function put(): void
    {
        $message = [
            'success' => false,
        ];

        if ($this->request->issetOnPost("form-video")) {
            $id = $this->request->post('id', FILTER_VALIDATE_INT);
            $url = $this->request->post('url', FILTER_VALIDATE_URL);
            $title = $this->request->post('titulo');

            if ($id && $url && $title) {
                $video = new Video(
                    id: $id,
                    url: $url,
                    title: $title
                );

                if ($image = $this->request->file("image", fileType: 'image')) {
                    $systemImagePath = $_ENV['THUMBNAIL_PATH'] ?? "assets/img/thumbs/";
                    $safeFileName = uniqid("upload_thumb_") . basename($image['name']);
                    $video->defineImagePath($safeFileName);

                    move_uploaded_file($image['tmp_name'], $video->imagePath(prefix: $systemImagePath));
                }

                $message['success'] = $this->repository->update($video);
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
            $this->put();
        }
    }
}
