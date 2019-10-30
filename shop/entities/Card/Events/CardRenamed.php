<?php

namespace shop\entities\Card\Events;

use shop\entities\Card\Card;

class CardRenamed extends CardEventBase
{
    public function __construct(Card $card){
        $this->card = $card;
        $this->message = 'Renamed Card to ' . $card->getName();
    }
}