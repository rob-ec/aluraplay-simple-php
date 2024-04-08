<?php

namespace Rob\Aluraplay\Web;

use finfo;

class Request
{
    public readonly string $path;
    public readonly string $method;

    public function __construct()
    {
        $this->path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        $this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
    }

    /**
     * @param $inputType: One of INPUT_GET , INPUT_POST , INPUT_COOKIE , INPUT_SERVER , or INPUT_ENV
     */
    private function input(
        int $inputType,
        string $varName,
        int $filter = FILTER_DEFAULT,
        int|array $options = 0
    ): mixed {
        return filter_input($inputType, $varName, $filter, $options);
    }

    public function get(?string $varName = null, int $filter = FILTER_DEFAULT, int|array $options = 0): mixed
    {
        if (!$varName) {
            return $_GET;
        }

        return $this->input(INPUT_GET, $varName, $filter, $options);
    }

    public function file(?string $varName = null, string $fileType = 'image', bool $safe = true): ?array
    {
        if (!$varName) {
            return $_FILES;
        }

        if (isset($_FILES[$varName]) && $_FILES[$varName]['name']) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES[$varName]['tmp_name']);

            $isValidType = str_starts_with($mimeType, $fileType);

            if (!$isValidType && $safe) {
                return null;
            }

            return $_FILES[$varName];
        }

        return null;
    }

    public function issetOnGet(string $varName): bool
    {
        return isset($_GET[$varName]);
    }

    public function issetOnPost(string $varName): bool
    {
        return isset($_POST[$varName]);
    }

    public function isset(string $varName): bool
    {
        return isset($_GET[$varName]) || isset($_GET[$varName]);
    }

    public function post(?string $varName = null, int $filter = FILTER_DEFAULT, int|array $options = 0): mixed
    {
        if (!$varName) {
            return $_POST;
        }

        return $this->input(INPUT_POST, $varName, $filter, $options);
    }
}
