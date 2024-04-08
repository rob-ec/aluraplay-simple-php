<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Repositories\UserRepository;

abstract class UserController extends Controller
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository = new UserRepository()) {
        $this->repository = $repository;
        parent::__construct();
    }
}
