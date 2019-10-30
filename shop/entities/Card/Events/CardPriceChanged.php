<?php

namespace shop\entities\Card\Events;


use shop\entities\Card\Card;
use shop\entities\Card\Price;

class CardPriceChanged extends CardEventBase
{
    public function __construct(Card $card, Price $price){
        $this->card = $card;
        $this->message = 'Changed Price to ' . $price->getValue() . ' ' . $price->getCurrency()->getCode();
    }
}