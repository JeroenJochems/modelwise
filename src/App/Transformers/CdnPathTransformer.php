<?php

namespace App\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class CdnPathTransformer implements Transformer
{
    public function __construct(
        protected ?string $format = '',
    ) {
    }

    public function transform(DataProperty $property, mixed $value): mixed
    {
        return env("CDN_URL").$value.$this->format;
    }
}
