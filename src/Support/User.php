<?php

namespace Support;

use Domain\Models\Actions\SendMail;
use Domain\Models\Data\Mail\MailData;
use Domain\Models\Data\Templates;
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
