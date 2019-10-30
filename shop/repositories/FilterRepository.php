<?php

namespace shop\repositories;

use shop\entities\Filter\Filter;

interface FilterRepository
{
    /**
     * @param int $id
     * @return Filter
     * @throws NotFoundException
     */
    public function get($id);
    /**
     * @return Filter[]
     * @throws NotFoundException
     */
    public function getAll();

    public function add(Filter $type);

    public function save(Filter $type);

    public function remove(Filter $type);

    /**
     * @param int $id
     * @return Filter
     */
    public function removeById($id);
}