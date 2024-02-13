<?php

namespace Domain\Work2;

use App\Application;
use App\EventSauce\QueuedMessageDispatcher;
use CashCards\CashCardRepository;
use CashCards\Projectors\CashCardsReadModelProjector;
use EventSauce\EventSourcing\MessageDispatcherChain;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\IdEncoding\StringIdEncoder;
use EventSauce\MessageRepository\IlluminateMessageRepository\IlluminateMessageRepository;
use EventSauce\MessageRepository\TableSchema\DefaultTableSchema;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class WorkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CashCardRepository::class, concrete: function (Application $application) {
            return new CashCardRepository(
                messageRepository: new IlluminateMessageRepository(
                    connection: $application->make(DatabaseManager::class)->connection(),
                    tableName: 'cashcard_events',
                    serializer: new ConstructingMessageSerializer(),
                    jsonEncodeOptions: 0,
                    tableSchema: new DefaultTableSchema(),
                    aggregateRootIdEncoder: new StringIdEncoder(),
                    eventIdEncoder: new StringIdEncoder(),
                ),
                dispatcher:
                new MessageDispatcherChain(
                    new SynchronousMessageDispatcher(
                        new CashCardsReadModelProjector(),
                    ),
                ),
            );
        });
    }
}
