<?php


namespace shop\entities\User\Events;


use shop\entities\User\Role;

class RoleCreated
{

    /**
     * RoleCreated constructor.
     * @param Role $param
     */
    public function __construct(Role $param){
    }
}