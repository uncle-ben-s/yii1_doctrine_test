<?php

namespace shop\entities\Card\Events;


use shop\entities\Card\Card;

class CardDeactivate extends CardEventBase
{
    public function __construct(Card $card, \DateTime $date){
        $this->card = $card;
        $this->message = 'Card deactivated status ' . $card->getStatus()->getStatusName();
    }
}