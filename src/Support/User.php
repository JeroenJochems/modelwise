<?php

namespace Support;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public function canAccessFilament(): bool
    {
        return true;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
