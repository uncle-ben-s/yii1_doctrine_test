<?php

namespace shop\repositories\Interfaces;

use shop\entities\User\Role;
use shop\repositories\NotFoundException;

interface IRoleRepository
{
    /**
     * @param int $id
     * @return Role
     * @throws NotFoundException
     */
    public function get($id);

    /**
     * @param string $name
     * @return Role | Null
     * @throws NotFoundException
     */
    public function getByName($name);

    public function add(Role $type);

    public function remove(Role $type);
}