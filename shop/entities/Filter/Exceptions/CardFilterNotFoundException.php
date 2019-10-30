<?php

namespace shop\entities\Filter\Exceptions;


class CardFilterNotFoundException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Card Filter not found.');
    }
}