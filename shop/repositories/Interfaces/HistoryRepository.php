<?php


namespace shop\repositories\Interfaces;

use shop\entities\History\History;
use shop\repositories\NotFoundException;

interface HistoryRepository
{
    /**
     * @param int $id
     * @return History
     * @throws NotFoundException
     */
    public function get($id);
    /**
     * @return History[]
     * @throws NotFoundException
     */
    public function getAll();

    public function add(History $type);
}