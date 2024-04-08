<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Core\Redirector;
use Rob\Aluraplay\Model\Video;

class VideoRemoveThumbController extends VideoController
{
    public function get(): void
    {
        $message = [
            'success' => false,
        ];

        $id = $this->request->get('id', FILTER_VALIDATE_INT);

        if (!$id) {
            Redirector::redirectTo("/");
            return;
        }

        $video = $this->repository->findByID($id);

        if ($video) {
            $video->defineImagePath(null);
            $message['success'] = $this->repository->update($video);
        }

        Redirector::redirectTo("/", $message);
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

                if ($image = $this->request->file("image")) {
                    $systemImagePath = $_ENV['THUMBNAIL_PATH'] ?? "assets/img/thumbs/";
                    $video->defineImagePath(uniqid("thumb_") . $image['name']);

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
