<?php

namespace shop\entities\Card\Exceptions;


class CardIsAlreadyUnobtainableException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Card is already unobtainable.');
    }
}