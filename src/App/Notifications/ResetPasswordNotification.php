<?php

namespace App\Notifications;

use App\Mail\CleanMail;
use App\Notifications\SidemailData\SidemailNotification;
use App\Notifications\SidemailData\SidemailRecipient;
use Domain\Profiles\Models\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;
use Support\User;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $token) {}

    public function via(object $notifiable): string
    {
        return SidemailChannel::class;
    }

    public function toMail(Model|User $notifiable): Mailable
    {
        return (new CleanMail(
            'Password reset',
            [
                "You are receiving this email because we received a password reset request for your account.",
            ],
            'Reset password',
            route("password.reset", ['email' => urlencode($notifiable->email), 'token' => $this->token]),
        ))->to($notifiable->email);
    }
}
