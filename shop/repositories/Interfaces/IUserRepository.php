<?php

namespace shop\repositories\Interfaces;

use shop\entities\User\User;

interface IUserRepository
{
    /**
     * @param int $id
     * @return User
     * @throws NotFoundException
     */
    public function get($id);

    /**
     * @param string $email
     * @return User | Null
     * @throws NotFoundException
     */
    public function getByEmail($email);

    public function add(User $type);

    public function save(User $type);

    public function remove(User $type);
}