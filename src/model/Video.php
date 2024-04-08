<?php

namespace Rob\Aluraplay\Model;

use InvalidArgumentException;
use JsonSerializable;

class Video implements JsonSerializable
{
    private ?int $id;
    private string $url;
    private string $title;
    private ?string $imagePath = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?int $id,
        string $url,
        string $title,
        ?string $imagePath = null
    ) {
        $this
            ->defineId($id)
            ->defineUrl($url)
            ->defineTitle($title)
            ->defineImagePath($imagePath);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function defineId(?int $id): Video
    {
        $this->id = $id;
        return $this;
    }

    public function url(): string
    {
        return $this->url;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function defineUrl(string $url): Video
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("url");
        }

        $this->url = $url;

        return $this;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function defineTitle(string $title): Video
    {
        $this->title = $title;
        return $this;
    }

    public function imagePath(?string $prefix = null): ?string
    {
        if ($prefix && $this->imagePath) {
            return "{$prefix}{$this->imagePath}";
        }

        return $this->imagePath;
    }

    public function defineImagePath(?string $imagePath = null): Video
    {
        $this->imagePath = $imagePath;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'imagePath' => $this->imagePath,
        ];
    }
}
