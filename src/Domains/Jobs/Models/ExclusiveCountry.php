<?php

namespace Domain\Jobs\Models;

use Illuminate\Database\Eloquent\Model;

class ExclusiveCountry extends Model
{
    protected $table = 'model_exclusive_countries';

    public function model()
    {
        return $this->belongsTo(\Domain\Models\Models\Model::class);
    }
}
