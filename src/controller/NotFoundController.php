<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Core\Redirector;

class NotFoundController extends Controller
{
    public function processRequest(): void
    {
        Redirector::notFound();
    }
}
