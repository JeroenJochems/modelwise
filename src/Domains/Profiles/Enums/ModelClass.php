<?php

namespace Domain\Profiles\Enums;

enum ModelClass: string
{
    public static function toArray(): array
    {
        return array_combine(
            array_column(ModelClass::cases(), "name"),
            array_column(ModelClass::cases(), "value")
        );
    }

    case Archived = "Archived";
    case People = "People";
    case Talent = "Talent";
    case Top = "Top";
}
