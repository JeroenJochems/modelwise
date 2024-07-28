<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function model() {
        return $this->belongsTo(\Domain\Profiles\Models\Model::class, 'to', 'email');
    }
}
