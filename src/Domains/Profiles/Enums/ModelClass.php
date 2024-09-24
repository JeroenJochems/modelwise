<?php

namespace Domain\Profiles\Enums;

enum ModelClass: string
{
    public static function toArray(): array
    {
        foreach (self::cases() as $case) {
            $array[$case->name] = $case->value;
        }
        return $array;
    }

    case Archived = "Archived";
    case People = "People";
    case Talent = "Talent";
    case Top = "Top";
}
