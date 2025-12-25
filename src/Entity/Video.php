<?php

namespace Alura\Mvc\Entity;

class Video {

    public readonly int $id;
    public readonly string $url;

    public function __construct(
        public readonly string $title,
        string $url
    ) {
       $this->setUrl($url);
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUrl(string $url): void {
        if(filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException("URL inválida: $url");
        }
        $this->url = $url;
    }

}