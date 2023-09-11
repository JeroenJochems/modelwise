<?php

namespace App\Notifications;

use App\Notifications\SidemailData\SidemailNotification;
use App\Notifications\SidemailData\SidemailRecipient;
use Domain\Jobs\Models\Invite;
use Domain\Profiles\Models\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class InviteCreated extends Notification implements ShouldQueue, SidemailNotification
{
    use Queueable;

    public function __construct(public Invite $invite) {}

    public function via(object $notifiable): string
    {
        return SidemailChannel::class;
    }

    public function toSideMail(Model|Authenticatable $notifiable): SideMailMessage
    {
        return new SideMailMessage(
            recipient: SidemailRecipient::fromModel($notifiable),
            template: 'invited',
            data: [
                'role' => $this->invite->role->name,
                'job' => $this->invite->role->job->title,
                'brand' => $this->invite->role->job->brand->name,
                'url' => route('roles.show', $this->invite->role),
                'date' => $this->invite->role->end_date
                    ? $this->invite->role->start_date->format('F j'). ' till '.$this->invite->role->end_date->format('F j')
                    : $this->invite->role->start_date->format('F j')
            ]
        );
    }
}
