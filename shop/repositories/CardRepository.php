<?php


namespace shop\repositories;


use shop\entities\Card\Card;

interface CardRepository
{
    /**
     * @param int $id
     * @return Card
     * @throws NotFoundException
     */
    public function get($id);

    public function add(Card $card);

    public function save(Card $card);

    public function remove(Card $card);
}