<?php

namespace App\Notifications;

use App\Mail\CleanMail;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

class Shortlisted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Listing $listing)
    { }

    public function via(object $notifiable): string
    {
        return 'mail';
    }

    public function toMail(Model|Authenticatable $notifiable): Mailable
    {
        return (new CleanMail(
            'You have been shortlisted',
            [
                "Hi {$this->listing->model->first_name},",
                "Good news: you've been shortlisted for the role {$this->listing->role->name} for {$this->listing->role->job->title} ({$this->listing->role->job->brand?->name}).",
                "The client has requested some additional information from you. Please log in to your account to provide this.",
            ],
            'View additional questions',
            route('roles.show', $this->listing->role),
        ))->to($notifiable->email);
    }
}
