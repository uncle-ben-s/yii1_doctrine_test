<?php

namespace shop\repositories;


class UserDoubleException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('User email is double.');
    }
}