<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Core\Redirector;

class VideoDeleteController extends VideoController
{
    public function delete(): void
    {
        $message = [
            'success' => false,
        ];

        $id = $this->request->get('id', FILTER_VALIDATE_INT);

        if ($id) {
            $message['success'] = $this->repository->delete($id);
        }

        Redirector::redirectTo("/", $message);
    }
    public function processRequest(): void
    {
        $this->onlyUsers();
        
        if ($this->request->method === 'GET') {
            $this->delete();
        }
    }
}
