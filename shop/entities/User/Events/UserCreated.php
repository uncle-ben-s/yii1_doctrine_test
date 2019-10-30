<?php

namespace shop\entities\User\Events;

use shop\entities\User\User;

class UserCreated
{
    /**
     * UserCreated constructor.
     * @param User $user
     */
    public function __construct(User $user){
    }
}