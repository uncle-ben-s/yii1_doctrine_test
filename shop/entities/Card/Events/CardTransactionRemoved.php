<?php


namespace shop\entities\Card\Events;


use shop\entities\Card\Card;
use shop\entities\Storage\Transaction;

class CardTransactionRemoved extends CardEventBase
{

    /**
     * CardTransactionRemoved constructor.
     * @param Card $card
     * @param Transaction $transaction
     */
    public function __construct(Card $card, Transaction $transaction){
        $this->card = $card;
        $this->message = 'Removed Transaction ' . $transaction->getType()->getName() . ' amount = ' . $transaction->getAmount();
    }
}