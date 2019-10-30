<?php


namespace shop\repositories\Interfaces;


use shop\entities\Card\Currency;
use shop\repositories\NotFoundException;

interface CurrencyRepository
{
    /**
     * @param int $id
     * @return Currency
     * @throws NotFoundException
     */
    public function get($id);
    /**
     * @return Currency[]
     * @throws NotFoundException
     */
    public function getAll();

    public function add(Currency $type);

    public function save(Currency $type);

    public function remove(Currency $type);

    /**
     * @param int $id
     * @return Currency
     */
    public function removeById($id);
}