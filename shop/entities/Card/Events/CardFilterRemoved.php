<?php

namespace shop\entities\Card\Events;


use shop\entities\Card\Card;
use shop\entities\Filter\Filter;

class CardFilterRemoved extends CardEventBase
{
    public function __construct(Card $card, Filter $filter){
        $this->card = $card;
        $this->message = 'Removed Filter "' . $filter->getType()->getName() . '" value => ' . $filter->getValue();
    }
}