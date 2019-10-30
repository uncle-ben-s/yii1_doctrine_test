<?php


namespace shop\repositories;


class RoleDoubleException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Role is double.');
    }
}