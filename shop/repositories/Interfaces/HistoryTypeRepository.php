<?php


namespace shop\repositories\Interfaces;

use shop\entities\History\Type;
use shop\repositories\NotFoundException;

interface HistoryTypeRepository
{
    /**
     * @param int $id
     * @return Type
     * @throws NotFoundException
     */
    public function get($id);
    /**
     * @return Type[]
     * @throws NotFoundException
     */
    public function getAll();

    /**
     * @param string $typeName
     * @return Type
     */
    public function getByName($typeName);

    public function add(Type $type);
}