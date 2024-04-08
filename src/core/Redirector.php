<?php

namespace Rob\Aluraplay\Core;

class Redirector
{
    private static function makeUrl(string $pageName, bool $forceExtension = false): string
    {
        if ($pageName === '/') {
            return $pageName;
        }

        if ($forceExtension) {
            return "{$pageName}.php";
        }

        return $pageName;
    }

    public static function redirectTo(string $page, array $params = []): void
    {
        $url = self::makeUrl($page);

        if (!empty ($params)) {
            $url .= "?" . http_build_query($params);
        }

        header("Location: {$url}");
        exit();
    }

    public static function notFound(): void
    {
        http_response_code(404);
        exit();
    }
}
