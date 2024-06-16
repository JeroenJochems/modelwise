<?php

namespace App\Notifications;

use App\Notifications\SidemailData\SidemailNotification;
use App\Notifications\SidemailData\SidemailRecipient;
use Domain\Profiles\Models\Model;
use Domain\Work\Models\Rejection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class Rejected extends Notification implements ShouldQueue, SidemailNotification
{
    use Queueable;

    public function __construct(public Rejection $rejection, public string $subject, public string $message) {}

    public function via(object $notifiable): string
    {
        return SidemailChannel::class;
    }

    public function toSideMail(Model|Authenticatable $notifiable): SideMailMessage
    {
        return new SideMailMessage(
            recipient: SidemailRecipient::fromModel($notifiable),
            template: 'rejected',
            data: [
                'subject' => $this->subject,
                'role' => $this->rejection->application->role->name,
                'job' => $this->rejection->application->role->job->title,
                'brand' => $this->rejection->application->role->job->brand->name,
                'message' => $this->message,
            ]
        );
    }
}
