<?php


namespace shop\repositories;


use shop\entities\Card\Card;

class MemoryCardRepository implements CardRepository
{
    private $items = [];

    public function get($id)
    {
        if (!array_key_exists($id, $this->items)) {
            throw new NotFoundException('Card not found.');
        }
        return clone $this->items[$id];
    }

    public function add(Card $card)
    {
        $id = count($this->items);

        $refObj = new \ReflectionObject( $card );
        $refProp = $refObj->getProperty( 'id' );
        $refProp->setAccessible( true );
        $refProp->setValue( $card, $id );
        $refProp->setAccessible( false );

        /*foreach($card->getFilters() as $filter){
            $filterId = $card->getFilters()->indexOf($filter);
            $refObj = new \ReflectionObject( $filter );
            $refProp = $refObj->getProperty( 'id' );
            $refProp->setAccessible( true );
            $refProp->setValue( $filter, $filterId );
            $refProp->setAccessible( false );
        }*/

        $this->items[$id] = $card;
    }

    public function save(Card $card)
    {
        $this->items[$card->getId()] = $card;
    }

    public function remove(Card $card)
    {
        if (array_key_exists($card->getId(), $this->items)) {
            unset($this->items[$card->getId()]);
        }
    }

    /*public function nextId()
    {
        return new Id(Uuid::uuid4()->toString());
    }*/
}