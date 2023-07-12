<?php

namespace App\Transformers;

class EnumArray
{
    public static function transform($cases)
    {
        return collect($cases)->map(function ($country) {
            return [
                'code' => $country->value,
                'name' => str_replace("_", " ", $country->name)
            ];
        })->toArray();
    }
}
