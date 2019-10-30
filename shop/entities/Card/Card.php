<?php
namespace shop\entities\Card;


use shop\entities\Storage\Storage;
use DateTime;
use Doctrine\ORM\PersistentCollection;
use shop\entities\AggregateRoot;
use shop\entities\Filter\Exceptions\CardFilterNotFoundException;
use shop\entities\Card\Exceptions\CardIsAlreadyUnobtainableException;
use shop\entities\EventTrait;
use shop\entities\Card\Exceptions\CardActiveRemoveException;
use shop\entities\Card\Exceptions\CardIsAlreadyActiveException;
use shop\entities\Filter\Filters;
use shop\entities\Filter\Filter;
use shop\entities\Storage\Transaction;

class Card implements AggregateRoot
{
    use EventTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    /**
     * @var Price
     */
    private $price;
    /**
     * @var Filters
     */
    private $filters;
    /**
     * @var DateTime
     */
    private $createDate;
    /**
     * @var Status
     */
    private $status;
    /**
     * @var Storage
     */
    private $storage;

    private $histories;

    /**
     * Card constructor.
     * @param DateTime $date
     * @param string $name
     * @param Price $price
     * @param Filters $filters
     */
    public function __construct(DateTime $date, $name, Price $price, Filters $filters){

        if(!count($filters)){
            throw new CardFilterNotFoundException();
        }

        $this->storage = Storage::fromItems([]);

        $this->name = $name;
        $this->price = $price;
        $this->filters = $filters;
        $this->createDate = $date;
        $this->setStatus(new Status(Status::UNOBTAINABLE));

        $this->recordEvent(new Events\CardCreated($this));
    }

    /**
     * @param string $name
     */
    public function rename($name){
        $this->name = $name;
        $this->recordEvent(new Events\CardRenamed($this));
    }

    public function changePrice(Price $price){
        $this->price = $price;
        $this->recordEvent(new Events\CardPriceChanged($this, $price));
    }

    public function addFilter(Filter $filter){
        $this->getFilters()->add($filter);
        $this->recordEvent(new Events\CardFilterAdded($this, $filter));
    }

    public function removeFilter(Filter $filter){

        $removedFilter = $this->getFilters()->removeFilter($filter);

        $this->recordEvent(new Events\CardFilterRemoved($this, $removedFilter));
    }

    /**
     * @param Transaction\Type $type
     * @param $count
     * @return Transaction
     * @throws \Exception
     */
    public function addTransaction(Transaction\Type $type , $count){
        $transaction = new Transaction($this, $type, $count, new DateTime());
        return $this->addStorageElement($transaction);
    }


    /**
     * @param Transaction $transaction
     * @return Transaction
     * @throws \Exception
     */
    public function addStorageElement(Transaction $transaction){
        $this->getStorage()->add($transaction);

        $this->checkStatus();

        $this->recordEvent(new Events\CardTransactionAdded($this, $transaction));

        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function removeStorageElement(Transaction $transaction){

        $removedTransaction = $this->getStorage()->removeStorageElement($transaction);

        $this->checkStatus();

        $this->recordEvent(new Events\CardTransactionRemoved($this, $removedTransaction));

        return $removedTransaction;
    }

    public function activate(DateTime $date){
        if($this->status->isActive()){
            throw new CardIsAlreadyActiveException();
        }

        $this->status = new Status(Status::ACTIVE);

        $this->recordEvent(new Events\CardActivate($this, $date));
    }

    public function deactivate(DateTime $date){
        if($this->status->isUnobtainable()){
            throw new CardIsAlreadyUnobtainableException();
        }

        $this->status = new Status(Status::UNOBTAINABLE);

        $this->recordEvent(new Events\CardDeactivate($this, $date));
    }

    public function remove(){
        if($this->isActive()){
            throw new CardActiveRemoveException();
        }

        $this->recordEvent(new Events\CardRemoved($this));
    }

    public function isActive(){
        return $this->getStatus()->isActive();
    }

    public function isUnobtainable(){
        return $this->getStatus()->isUnobtainable();
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getFilters(){
        if ($this->filters instanceof PersistentCollection) {
            $this->filters = Filters::fromDoctrine($this->filters);
        }

        return $this->filters;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getCreateDate(){
        return $this->createDate;
    }

    /**
     * @return Status
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @return Storage
     */
    public function getStorage(){
        if ($this->storage instanceof PersistentCollection) {
            $this->storage = Storage::fromDoctrine($this->storage);
        }

        return $this->storage;
    }

    private function setStatus(Status $status)
    {
        $this->status = $status;
    }

    private function checkStatus(){
        if($this->getStorage()->getAmount() > 0){
            if($this->isUnobtainable()){
                $this->activate(new DateTime());
            }
        }elseif($this->isActive()){
            $this->deactivate(new DateTime());
        }
    }
}