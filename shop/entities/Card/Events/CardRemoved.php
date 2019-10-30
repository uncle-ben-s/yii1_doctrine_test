<?php

namespace shop\entities\Card\Events;


use shop\entities\Card\Card;

class CardRemoved extends CardEventBase
{
    public function __construct(Card $card){
        $this->card = $card;
        $this->message = 'Removed Card ' . $card->getName();
    }
}