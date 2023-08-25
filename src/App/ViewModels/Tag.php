<?php

namespace App\ViewModels;

/** @typescript */
class Tag
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug
    ) {}

    public static function fromMode(\Spatie\Tags\Tag $tag)
    {
        return new self($tag->id, $tag->name, $tag->slug);
    }
}
