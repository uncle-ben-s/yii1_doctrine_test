<?php
namespace shop\entities\Storage;


use shop\entities\Storage\Transaction\Type;
use shop\entities\AggregateRoot;
use shop\entities\Card\Card;
use shop\entities\EventTrait;
use Webmozart\Assert\Assert;

class Transaction implements AggregateRoot
{
    use EventTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Card
     */
    private $card;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var \DateTime
     */
    private $createDate;
    /**
     * @var Type
     */
    private $type;


    /**
     * Transaction constructor.
     * @param Card $card
     * @param int $count
     * @param Type $type
     * @param \DateTime $date
     */
    public function __construct(Card $card, Type $type, $count, \DateTime $date){
        Assert::notEmpty($count);

        $this->card = $card;
        $this->amount = $count;
        $this->type = $type;
        $this->createDate = $date;

        $this->recordEvent(new Events\TransactionCreated($this));
    }



    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return Card
     */
    public function getCard(){
        return $this->card;
    }

    /**
     * @return int
     */
    public function getAmount(){
        return $this->amount;
    }

    /**
     * @return Type
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate(){
        return $this->createDate;
    }
}