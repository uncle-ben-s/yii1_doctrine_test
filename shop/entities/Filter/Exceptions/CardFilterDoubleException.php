<?php

namespace shop\entities\Filter\Exceptions;


class CardFilterDoubleException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Card filter is double.');
    }
}