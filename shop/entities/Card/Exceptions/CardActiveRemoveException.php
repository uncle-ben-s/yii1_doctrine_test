<?php

namespace shop\entities\Card\Exceptions;


class CardActiveRemoveException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Dont remove active Card.');
    }
}