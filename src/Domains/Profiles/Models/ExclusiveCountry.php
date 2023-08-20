<?php

namespace Domain\Profiles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;
use PrinsFrank\Standards\Country\CountryAlpha2;

class ExclusiveCountry extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    protected $table = 'model_exclusive_countries';

    protected $fillable = [
        'country',
    ];

    protected $casts = [
        'country' => CountryAlpha2::class,
    ];

    public function model()
    {
        return $this->belongsTo(\Domain\Profiles\Models\Model::class);
    }
}
