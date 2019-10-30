<?php


namespace shop\entities\Card\Events;


use shop\entities\Card\Card;

class CardEventBase
{
    /**
     * @var Card
     */
    protected $card;
    /**
     * @var string
     */
    protected $message;

    /**
     * @return Card
     */
    public function getCard(){
        return $this->card;
    }

    /**
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }
}