<?php

namespace App\Console\Commands;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Support\User;

class SendTestMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-test-mails {code} {emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $addresses = explode(",", $this->argument('emails'));

        $role = Role::orderBy('id', 'desc')->first();

        foreach ($addresses as $address) {

            Mail::to($address)->send(new CleanMail(
                messageSubject: 'You have been shortlisted',
                messageContent: [
                    "Hi Jeroen,",
                    "Good news: you've been shortlisted for a role.",
                    "Please log in to your account to provide additional information requested by the client.",
                ],
                actionText: 'View additional questions',
                actionUrl: route('roles.show', $role),
                code: $this->argument('code')
            ));

        }
    }
}
