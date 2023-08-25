<?php

namespace App\Notifications;

use Domain\Jobs\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Invite $invite) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('You have been invited to apply for a job.')
                    ->action('View role details', route('roles.show', $this->invite->role));
    }
}
