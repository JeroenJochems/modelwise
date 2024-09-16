<?php

namespace Domain\Profiles\Enums;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
enum Ethnicity: string
{
    public static function toArray(): array
    {
        foreach (self::cases() as $case) {
            $array[$case->value] = __("enums.ethnicity.{$case->value}");
        }
        return $array;
    }

    case Asian = 'asian';
    case Black = 'black';
    case Hispanic = 'hispanic';
    case Indigenous = 'indigenous';
    case MiddleEastern = 'middle-eastern';
    case Mixed = 'mixed';
    case NativeAmerican = 'native-american';
    case Pacific = 'pacific-islander';
    case White = 'white';
    case Other = 'other';

}
