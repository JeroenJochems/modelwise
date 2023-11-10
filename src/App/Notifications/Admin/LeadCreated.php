<?php

namespace App\Notifications\Admin;

use App\Notifications\SidemailChannel;
use App\Notifications\SidemailData\SidemailNotification;
use App\Notifications\SidemailData\SidemailRecipient;
use App\Notifications\SideMailMessage;
use Domain\Leads\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LeadCreated extends Notification implements SidemailNotification
{
    use Queueable;

    public function __construct(public Lead $lead)
    { }

    public function via(object $notifiable): string
    {
        return SidemailChannel::class;
    }

    public function toSidemail(object $notifiable): SideMailMessage
    {
        return new SideMailMessage(
            recipient: new SidemailRecipient(
                $notifiable->email,
                $notifiable->name,
                'en'),
            template: 'lead-created',
            data: [
                'first_name' => $this->lead->first_name,
                'last_name' => $this->lead->last_name,
                'email' => $this->lead->email,
                'phone' => $this->lead->phone,
            ],
        );
    }
}
