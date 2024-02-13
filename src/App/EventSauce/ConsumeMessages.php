<?php

namespace App\EventSauce;

use EventSauce\EventSourcing\MessageConsumer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConsumeMessages implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private MessageConsumer $consumer, private array $messages)
    {
    }

    public function handle(): void
    {
        foreach ($this->messages as $message) {
            $this->consumer->handle($message);
        }
    }
}
