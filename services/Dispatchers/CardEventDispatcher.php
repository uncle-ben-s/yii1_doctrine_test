<?php


namespace services\Dispatchers;

use shop\Dispatchers\EventDispatcher;
use shop\Services\History\History;

class CardEventDispatcher implements EventDispatcher
{
    public function dispatch(array $events)
    {

        foreach ($events as $event) {
            \Yii::app()->DI->container->get(History::class)->create(
                $event->getCard()->getId(),
                substr(strrchr(\get_class($event), '\\'), 1),
                \Yii::app()->user->id,
                $event->getMessage()
            );
        }
    }
}