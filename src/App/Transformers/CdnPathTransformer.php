<?php

namespace App\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class CdnPathTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value): mixed
    {
        return env("CDN_URL").$value;
    }
}
