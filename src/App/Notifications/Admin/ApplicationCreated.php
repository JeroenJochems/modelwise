<?php

namespace App\Notifications\Admin;

use App\Notifications\SidemailChannel;
use App\Notifications\SidemailData\SidemailNotification;
use App\Notifications\SidemailData\SidemailRecipient;
use App\Notifications\SideMailMessage;
use Domain\Jobs\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationCreated extends Notification implements SidemailNotification
{
    use Queueable;

    public function __construct(public Application $application)
    { }

    public function via(object $notifiable): string
    {
        return SidemailChannel::class;
    }

    public function toSidemail(object $notifiable): SidemailMessage
    {
        return new SideMailMessage(
            recipient: new SidemailRecipient(
                $notifiable->email,
                $notifiable->name,
                'en'),
            template: 'model-applied',
            data: [
                'role' => $this->application->role->name,
                'job' => $this->application->role->job->title,
                'model' => $this->application->model->name,
                'link' => url('/admin/resources/applications/' . $this->application->id),
            ],
        );
    }
}
