<?php

namespace Rob\Aluraplay\Core;

class AppFileLoader
{
    private string $rootPath;
    public function __construct(string $loadFrom = null, string $folder = '')
    {
        $path = $loadFrom ?? __DIR__ . "/../..";

        $this->rootPath = "{$path}{$folder}";
    }

    private function pathTo(string $file): string
    {
        return "{$this->rootPath}/{$file}";
    }

    public function load(string $file, $useRequire = true, $vars = null): void
    {
        if ($vars) {
            extract($vars);
        }

        if ($useRequire) {
            require_once $this->pathTo($file);
            return;
        }

        include_once $this->pathTo($file);
    }
}
