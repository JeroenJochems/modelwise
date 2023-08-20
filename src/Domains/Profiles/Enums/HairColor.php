<?php

namespace Domain\Profiles\Enums;

/** @typescript */
enum HairColor: string
{
    // make cases for these colors:
    // black, brown, blond, white/gray, and rarely red

    case Black = 'Black';
    case Brown = 'Brown';
    case Blond = 'Blond';
    case WhiteGray = 'White/Gray';
    case Red = 'Red';
    case Colored = 'Colored';
    case None = 'None';
    case Other = 'Other';
}
