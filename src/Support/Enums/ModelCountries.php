<?php

namespace Support\Enums;

use PrinsFrank\Standards\BackedEnum;
use PrinsFrank\Standards\Country\CountryAlpha3;
use PrinsFrank\Standards\Country\CountryName;
use PrinsFrank\Standards\Country\CountryNumeric;

enum ModelCountries: string
{
    case Australia                               = 'AU';
    case Austria                                 = 'AT';
    case Belgium                                 = 'BE';
    case Brazil                                  = 'BR';
    case Canada                                  = 'CA';
    case China                                   = 'CN';
    case Denmark                                 = 'DK';
    case France                                  = 'FR';
    case Germany                                 = 'DE';
    case Greece                                  = 'GR';
    case Hong_Kong                               = 'HK';
    case Italy                                   = 'IT';
    case Indonesia                               = 'ID';
    case Japan                                   = 'JP';
    case Luxembourg                              = 'LU';
    case Maldives                                = 'MV';
    case Mexico                                  = 'MX';
    case Netherlands                             = 'NL';
    case Portugal                                = 'PT';
    case South_Africa                            = 'ZA';
    case Spain                                   = 'ES';
    case Sweden                                  = 'SE';
    case Switzerland                             = 'CH';
    case Turkey                                  = 'TR';
    case United_Kingdom                          = 'GB';
    case United_States_of_America                = 'US';

    public function toCountryAlpha3(): CountryAlpha3
    {
        return BackedEnum::fromKey(CountryAlpha3::class, $this->name);
    }

    public function toCountryNumeric(): CountryNumeric
    {
        return BackedEnum::fromKey(CountryNumeric::class, $this->name);
    }

    public function toCountryName(): CountryName
    {
        return BackedEnum::fromKey(CountryName::class, $this->name);
    }

    public function lowerCaseValue(): string
    {
        return strtolower($this->value);
    }
}

