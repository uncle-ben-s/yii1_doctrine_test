<?php

namespace shop\entities\Filter\Exceptions;


class FilterTypeDoubleException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Filter type is double.');
    }
}