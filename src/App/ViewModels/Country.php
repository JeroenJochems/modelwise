<?php

namespace App\ViewModels;

class Country
{
    public function __construct(public string $name, public string $code, public int $phone)
    { }
}
