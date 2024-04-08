<?php

namespace Rob\Aluraplay\Controller;

use Rob\Aluraplay\Repositories\VideoRepository;

abstract class VideoController extends Controller
{
    protected VideoRepository $repository;
    public function __construct(VideoRepository $repository = new VideoRepository())
    {
        $this->repository = $repository;
        parent::__construct();
    }
}
