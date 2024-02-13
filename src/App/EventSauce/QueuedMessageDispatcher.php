<?php

namespace App\EventSauce;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;
use EventSauce\EventSourcing\MessageDispatcher;

final readonly class QueuedMessageDispatcher implements MessageDispatcher
{
    /**
     * @var MessageConsumer[]
     */
    private array $consumers;

    public function __construct(public string $queue, MessageConsumer ...$consumers)
    {
        $this->consumers = $consumers;
    }

    public function dispatch(Message ...$messages): void
    {
        foreach ($this->consumers as $consumer) {
            dispatch(new ConsumeMessages($consumer, $messages))
                ->onQueue(implode("-", [$this->queue, app()->environment()]));
        }
    }
}
