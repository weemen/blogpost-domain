<?php

namespace Weemen\BlogPost\Domain\BlogPost;


use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;

class BlogPostRepository extends EventSourcingRepository
{

    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     * @param array $eventStreamDecorators
     */
    public function __construct(
        EventStoreInterface $eventStore,
        EventBusInterface $eventBus,
        $eventStreamDecorators = array())
    {
        parent::__construct(
            $eventStore,
            $eventBus,
            'Weemen\BlogPost\Domain\BlogPost\BlogPost',
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }
}