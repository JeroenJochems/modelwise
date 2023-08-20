<?php

namespace Support;

use Domain\Profiles\Actions\SendMail;
use Domain\Profiles\Data\Mail\MailData;
use Domain\Profiles\Data\Templates;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
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
