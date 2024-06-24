<?php

namespace Support;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public static function newFactory()
    {
        return UserFactory::new();
    }

    public function canImpersonate()
    {
        return true;
    }

    public function isSuperAdmin()
    {
        return str_starts_with($this->email, 'bas@') || str_starts_with($this->email, 'jeroen@');
    }
}
