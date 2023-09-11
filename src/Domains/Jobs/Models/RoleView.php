<?php

namespace Domain\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class RoleView extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    protected $fillable = [
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }
}
