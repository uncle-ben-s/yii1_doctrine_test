<?php

namespace shop\entities\Card\Exceptions;


class CardIsAlreadyActiveException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Card is already active.');
    }
}