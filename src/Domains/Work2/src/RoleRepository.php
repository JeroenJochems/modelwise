<?php

namespace Domain\Work2;

use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\MessageRepository;

/**
 * @template-extends EventSourcedAggregateRootRepository<RoleAggregate>
 */
class RoleRepository extends EventSourcedAggregateRootRepository
{
    /**
     * @template-extends EventSourcedAggregateRootRepository<RoleAggregate>
     */
    public function __construct(
        MessageRepository $messageRepository,
        ?MessageDispatcher $dispatcher = null,
        ?MessageDecorator $decorator = null,
        ?ClassNameInflector $classNameInflector = null
    ) {
        parent::__construct(
            RoleAggregate::class,
            $messageRepository,
            $dispatcher,
            $decorator,
            $classNameInflector,
        );
    }
}
