<?php

namespace App\Notifications;

use App\Notifications\SidemailData\SidemailNotification;
use App\Notifications\SidemailData\SidemailRecipient;
use Domain\Profiles\Models\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue, SidemailNotification
{
    use Queueable;

    public function __construct(public string $token) {}

    public function via(object $notifiable): string
    {
        return SidemailChannel::class;
    }

    public function toSideMail(Model|Authenticatable $notifiable): SideMailMessage
    {
        return new SideMailMessage(
            recipient: SidemailRecipient::fromModel($notifiable),
            template: 'reset-password',
            data: [
                'reset_password_url' => route("password.reset", ['email' => urlencode($notifiable->email), 'token' => $this->token]),
            ]
        );
    }
}
