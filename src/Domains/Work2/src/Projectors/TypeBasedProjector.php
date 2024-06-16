<?php

namespace Domain\Work2\Projectors;

use EventSauce\EventSourcing\EventConsumption\EventConsumer;
use EventSauce\EventSourcing\EventConsumption\HandleMethodInflector;
use EventSauce\EventSourcing\EventConsumption\InflectHandlerMethodsFromType;

abstract class TypeBasedProjector extends EventConsumer
{
    protected function handleMethodInflector(): HandleMethodInflector
    {
        return new InflectHandlerMethodsFromType();
    }
}
