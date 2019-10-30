<?php

namespace shop\entities\Card\Events;


use shop\entities\Card\Card;

class CardCreated extends CardEventBase
{
    public function __construct(Card $card){
        $this->card = $card;
        $this->message = 'Created Card "' . $card->getName() . '"';
    }
}