<?php

namespace App\Notifications\Admin;

use App\Mail\ClientSubmittedPreference;
use Domain\Jobs\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Support\User;

class ClientSubmittedPrelist extends Notification
{
    use Queueable;

    public function __construct(public Role $role)
    { }

    public function via(object $notifiable): string
    {
        return 'mail';
    }

    public function toMail(User $notifiable)
    {
        return new ClientSubmittedPreference($this->role);
    }
}
