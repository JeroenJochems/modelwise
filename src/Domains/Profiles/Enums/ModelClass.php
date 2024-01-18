<?php

namespace Domain\Profiles\Enums;

enum ModelClass: string
{
    case AAA = "AAA - €2000/day+";
    case A = "A - €1000-€2000/day";
    case B = "B - ~€600/day";
    case C = "C - ~€400/day";
    case D = "D - ~€200/day";
}
