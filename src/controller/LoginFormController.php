<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Core\Redirector;
use Rob\Aluraplay\Repositories\UserRepository;

class LoginFormController extends Controller
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository = null)
    {
        $this->repository = $repository ?? new UserRepository();
        parent::__construct();
    }

    public function get(): void
    {
        $this->view->load('form-login.php');
    }

    public function processRequest(): void
    {
        if ($this->isLogedUser()) {
            Redirector::redirectTo("/");
        }

        if ($this->request->method === 'GET') {
            $this->get();
        }
    }
}
