<?php


namespace app\tests\unit\test\entities\Storage;


use shop\entities\Storage\Transaction\Type;
use shop\entities\Storage\Events\TransactionCreated;
use shop\entities\Storage\Transaction;
use tests\unit\entities\card\CardBuilder;

class TransactionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testCreate(){

        $card = (new CardBuilder())->build();
        $storage = new Transaction($card, $tr =  new Type(Type::ADD), $cnt = 10, $date = new \DateTime());


        $this->assertEquals($card->getName(), $storage->getCard()->getName());
        $this->assertEquals($cnt, $storage->getAmount());
        $this->assertEquals($tr->getName(), $storage->getType()->getName());
        $this->assertEquals($date, $storage->getCreateDate());

        $this->assertNotEmpty($events = $storage->releaseEvents());
        $this->assertInstanceOf(TransactionCreated::class, end($events));
    }
}