<?php

namespace shop\entities\Card\Events;


use shop\entities\Card\Card;

class CardActivate extends CardEventBase
{
    public function __construct(Card $card, \DateTime $date){
        $this->card = $card;
        $this->message = 'Activate ' . $card->getStatus()->getStatusName();
    }
}