<?php

namespace App\Notifications\SidemailData;

use App\Notifications\SidemailMessage;
use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;

interface SidemailNotification
{
    public function toSideMail(Model|Authenticatable $notifiable): SidemailMessage;
}
