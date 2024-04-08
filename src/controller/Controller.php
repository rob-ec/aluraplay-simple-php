<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Core\AppFileLoader;
use Rob\Aluraplay\Core\Redirector;
use Rob\Aluraplay\Web\Request;

abstract class Controller
{
    protected AppFileLoader $view;
    protected Request $request;
    protected string $viewPath = "/src/view";
    
    public function __construct() {
        $this->view = new AppFileLoader(folder: $this->viewPath);
        $this->request = new Request();
    }

    protected function isLogedUser(): bool
    {
        return array_key_exists('loged', $_SESSION) && $_SESSION['loged'] === true;
    }

    protected function onlyUsers(): void
    {
        if (!$this->isLogedUser()) {
            Redirector::redirectTo("/login");
        }
    }

    abstract public function processRequest(): void;
}
