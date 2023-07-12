<?php

namespace Domain\Jobs\Models;

use Illuminate\Database\Eloquent\Model;
use PrinsFrank\Standards\Country\CountryAlpha2;

class ExclusiveCountry extends Model
{
    protected $table = 'model_exclusive_countries';

    protected $fillable = [
        'country',
    ];

    protected $casts = [
        'country' => CountryAlpha2::class,
    ];

    public function model()
    {
        return $this->belongsTo(\Domain\Models\Models\Model::class);
    }
}
