<?php

namespace shop\repositories;

use shop\entities\Filter\FilterType;

interface FilterTypeRepository
{
    /**
     * @param int $id
     * @return FilterType
     * @throws NotFoundException
     */
    public function get($id);

    /**
     * @return FilterType[]
     * @throws NotFoundException
     */
    public function getAll();

    public function add(FilterType $type);

    /**
     * @param FilterType $type
     * @return FilterType
     */
    public function remove(FilterType $type);

    /**
     * @param int $id
     * @return FilterType
     */
    public function removeById($id);
}