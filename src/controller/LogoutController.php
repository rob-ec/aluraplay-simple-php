<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Core\Redirector;

class LogoutController extends UserController
{
    public function get(): void
    {
        unset($_SESSION['loged']);
        Redirector::redirectTo("/");
    }

    public function processRequest(): void
    {
        $this->get();
    }
}
