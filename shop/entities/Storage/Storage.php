<?php
namespace shop\entities\Storage;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use shop\entities\Storage\Transaction\Type;

class Storage extends ArrayCollection
{
    /**
     * @param Transaction[] $elements
     * @return Storage
     */
    public static function fromItems($elements)
    {
        return new self($elements);
    }

    public static function fromDoctrine(PersistentCollection $collection)
    {
        return new self($collection);
    }

    /**
     * Storage constructor.
     * @param Transaction[]|PersistentCollection $collection
     */
    public function __construct($collection)
    {
//        if (!$collection) {
//            throw new TransactionNotFoundException();
//        }

        $this->clear();

        foreach ($collection as $item) {
            $this->add($item);
        }
    }

    /**
     * @param Transaction $element
     */
    public function add($element)
    {
        if($element->getType()->getName() === Type::REMOVE){
            if($element->getAmount() > $this->getAmount()){
                throw new CardAddTransactionException('Current amount less than need decrement amount');
            }
        }

        parent::add($element);
    }

    public function removeStorageElement($element)
    {
        if(!$this->removeElement($element)){
            throw new TransactionNotFoundException();
        }

        return $element;
    }

    public function getAmount(){
        $amount = 0;

        /**
         * @var Transaction $transaction
         */
        foreach($this->toArray() as $transaction){
            switch($transaction->getType()->getName()){
                case Type::ADD:
                    $amount += $transaction->getAmount();
                    break;
                case Type::REMOVE:
                    $amount -= $transaction->getAmount();
                    break;
            }
        }

        return $amount;
    }
}