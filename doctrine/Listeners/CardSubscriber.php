<?php

namespace app\doctrine\Listeners;


use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use shop\entities\Card\Card;
use shop\entities\Filter\Filters;
use shop\repositories\Hydrator;

class CardSubscriber implements EventSubscriber
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::postLoad,
        );
    }

    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getObject();

        if ($entity instanceof Card) {
            $data = $this->hydrator->extract($entity, ['filters']);

            $this->hydrator->hydrate($entity, [
                'filters' => new Filters($data['filters'])
            ]);
        }
    }
}