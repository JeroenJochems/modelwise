<?php

namespace Domain\Work2;

use App\Application;
use App\EventSauce\QueuedMessageDispatcher;
use Domain\Work2\Projectors\ModelRoleReadModelProjector;
use Domain\Work2\Reactors\UpdateModelCharacteristics;
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
        $this->app->bind(RoleRepository::class, concrete: function (Application $application) {
            return new RoleRepository(
                messageRepository: new IlluminateMessageRepository(
                    connection: $application->make(DatabaseManager::class)->connection(),
                    tableName: 'work_events',
                    serializer: new ConstructingMessageSerializer(),
                    jsonEncodeOptions: 0,
                    tableSchema: new DefaultTableSchema(),
                    aggregateRootIdEncoder: new StringIdEncoder(),
                    eventIdEncoder: new StringIdEncoder(),
                ),
                dispatcher: new MessageDispatcherChain(
                    new SynchronousMessageDispatcher(
                        new ModelRoleReadModelProjector(),
                        new UpdateModelCharacteristics(),
                    ),
                    new QueuedMessageDispatcher(
                        'default',
//                        new MailReactor(),
                    )
                ),
            );
        });
    }
}
