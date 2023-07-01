<?php

namespace Domain\Jobs\Models;


use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function shortlisted_models()
    {
        return $this->belongsToMany(\Domain\Models\Models\Model::class, 'shortlisted_models');
    }
}
