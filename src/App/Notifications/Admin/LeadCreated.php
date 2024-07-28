<?php

namespace App\Notifications\Admin;

use App\Mail\CleanMail;
use Domain\Leads\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

class LeadCreated extends Notification
{
    use Queueable;

    public function __construct(public Lead $lead)
    { }

    public function via(object $notifiable): string
    {
        return 'mail';
    }

    public function toMail(object $notifiable): Mailable
    {
        return (new CleanMail(
            'New lead was created',
            [
                $this->lead->first_name." ".$this->lead->last_name,
                $this->lead->email,
                $this->lead->phone,
            ]
        ))->to($notifiable->email);
    }
}
