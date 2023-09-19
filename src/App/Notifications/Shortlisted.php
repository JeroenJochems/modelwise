<?php

namespace App\Notifications;

use App\Notifications\SidemailData\SidemailNotification;
use App\Notifications\SidemailData\SidemailRecipient;
use Domain\Profiles\Models\Model;
use Domain\Work\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class Shortlisted extends Notification implements ShouldQueue, SidemailNotification
{
    use Queueable;

    public function __construct(public Application $application) {}

    public function via(object $notifiable): string
    {
        return SidemailChannel::class;
    }

    public function toSideMail(Model|Authenticatable $notifiable): SideMailMessage
    {
        return new SideMailMessage(
            recipient: SidemailRecipient::fromModel($notifiable),
            template: 'shortlisted',
            data: [
                'role' => $this->application->role->name,
                'job' => $this->application->role->job->title,
                'brand' => $this->application->role->job->brand->name,
                'url' => route('applications.show', $this->application),
            ]
        );
    }
}
