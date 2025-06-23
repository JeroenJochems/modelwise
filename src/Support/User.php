<?php

namespace Support;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
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

    public function routeNotificationForVonage(Notification $notification): string
    {
        Log::info('Notification is being sent to: ' . $this->phone_number);

        return $this->phone_number;
    }

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
