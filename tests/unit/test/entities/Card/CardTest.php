<?php

use shop\entities\Card\Events\CardTransactionRemoved;
use shop\entities\Storage\CardAddTransactionException;
use shop\entities\Card\Events\CardTransactionAdded;
use shop\entities\Filter\Filters;
use shop\entities\Storage\Transaction;
use shop\entities\Storage\Transaction\Type;
use tests\unit\entities\card\CardBuilder;
use shop\entities\Card\Events\CardActivate;
use shop\entities\Card\Events\CardCreated;
use shop\entities\Card\Events\CardDeactivate;
use shop\entities\Card\Events\CardFilterAdded;
use shop\entities\Card\Events\CardFilterRemoved;
use shop\entities\Card\Events\CardPriceChanged;
use shop\entities\Card\Events\CardRemoved;
use shop\entities\Card\Events\CardRenamed;
use shop\entities\Card\Exceptions\CardActiveRemoveException;
use shop\entities\Filter\Exceptions\CardFilterDoubleException;
use shop\entities\Filter\Exceptions\CardFilterNotFoundException;
use shop\entities\Card\Exceptions\CardIsAlreadyActiveException;
use shop\entities\Card\Exceptions\CardIsAlreadyUnobtainableException;
use shop\entities\Card\Card;
use shop\entities\Filter\FilterType;
use shop\entities\Card\Price;
use shop\entities\Card\Currency;
use shop\entities\Filter\Filter;

class CardTest extends \Codeception\Test\Unit
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
        $card = new Card(
            $date = new \DateTime(),
            $name = 'Lapty la lapte de noir',
            $price = new Price(new Currency('uans', 'grn'), 125),
            $filters = Filters::fromItems([
                new Filter(new FilterType('size'), '25'),
                new Filter(new FilterType('color'), 'blue'),
                new Filter(new FilterType('type'), 'felt boots'),
                new Filter(new FilterType('material'), 'felt'),
                new Filter(new FilterType('season'), 'summer'),
            ])
        );

        $this->assertIsNotInt($card->getId());
        $this->assertEquals($date, $card->getCreateDate());
        $this->assertEquals($name, $card->getName());
        $this->assertEquals($price, $card->getPrice());
        $this->assertEquals($filters, $card->getFilters());

        $this->assertNotNull($card->getCreateDate());

        $this->assertTrue($card->isUnobtainable());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardCreated::class, end($events));
    }

    public function testCreateWithoutFilters(){
        $this->expectException(CardFilterNotFoundException::class);

        (new CardBuilder())->withFilters(Filters::fromItems([]))->build();
    }

    public function testRename(){
        $card = (new CardBuilder())->build();

        $card->rename($name = 'New name');
        $this->assertEquals($name, $card->getName());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardRenamed::class, end($events));
    }

    public function testChangePrice()
    {
        $card = (new CardBuilder())->build();

        $card->changePrice($price = new Price(new Currency('uans', 'grn'), 200));
        $this->assertEquals($price, $card->getPrice());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardPriceChanged::class, end($events));
    }

    public function testActivate()
    {
        $card = (new CardBuilder())->build();

        $this->assertFalse($card->isActive());
        $this->assertTrue($card->isUnobtainable());

        $card->activate($date = new \DateTime('2019-10-19'));

        $this->assertTrue($card->isActive());
        $this->assertFalse($card->isUnobtainable());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardActivate::class, end($events));
    }

    public function testAlreadyActive()
    {
        $card = (new CardBuilder())->active()->build();

        $this->expectException(CardIsAlreadyActiveException::class);

        $card->activate(new \DateTime('2019-10-19'));
    }

    public function testDeactivate()
    {
        $card = (new CardBuilder())->active()->build();

        $this->assertTrue($card->isActive());
        $this->assertFalse($card->isUnobtainable());

        $card->deactivate($date = new \DateTime('2019-10-19'));

        $this->assertFalse($card->isActive());
        $this->assertTrue($card->isUnobtainable());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardDeactivate::class, end($events));
    }

    public function testAlreadyUnobtainable()
    {
        $card = (new CardBuilder())->build();

        $this->expectException(CardIsAlreadyUnobtainableException::class);

        $card->deactivate(new \DateTime('2019-10-19'));
    }

    public function testAddFilter()
    {
        $card = (new CardBuilder())->build();

        $card->addFilter($filter = new Filter(new FilterType('size'), '12'));

        $this->assertNotEmpty($filters = $card->getFilters());
        $this->assertEquals($filter, $filters->last());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardFilterAdded::class, end($events));
    }

    public function testAddDoubleFilter()
    {
        $card = (new CardBuilder())
            ->withFilters(Filters::fromItems([$filter = new Filter(new FilterType('size'), '12')]))
            ->build();

        $this->expectException(CardFilterDoubleException::class);

        $card->addFilter($filter);
    }

    public function testRemoveFilter()
    {
        $card = (new CardBuilder())
            ->withFilters(Filters::fromItems([
                $filterSize = new Filter(new FilterType('size'), '12'),
                $filterMaterial = new Filter(new FilterType('material'), 'felt'),
                ]))
            ->build();

        $this->assertCount(2, $card->getFilters());

        $card->removeFilter($filterMaterial);

        $this->assertCount(1, $card->getFilters());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardFilterRemoved::class, end($events));
    }

    public function testRemoveFilterNotExists()
    {
        $card = (new CardBuilder())->build();

        $this->expectException(CardFilterNotFoundException::class);

        $card->removeFilter(new Filter(new FilterType('filterName'), 'filterValue'));
    }

    public function testAddTransaction()
    {
        $card = (new CardBuilder())->build();

        $this->assertEmpty($card->getStorage());

        $card->addStorageElement($transaction = new Transaction($card, new Type(Type::ADD), 12, new \DateTime()));

        $this->assertNotEmpty($card->getStorage());
        $this->assertCount(1, $card->getStorage());
        $this->assertEquals($transaction, $card->getStorage()->last());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardTransactionAdded::class, end($events));

        $transaction2 = $card->addTransaction(new Type(Type::ADD), 2);

        $this->assertCount(2, $card->getStorage());

        $this->assertEquals($transaction2, $card->getStorage()->last());

        $this->assertTrue($card->isActive());
    }

    public function testAddBigDecrementTransaction()
    {
        $card = (new CardBuilder())->build();

        $this->assertEmpty($card->getStorage());

        $card->addStorageElement($transaction = new Transaction($card, new Type(Type::ADD), 12, new \DateTime()));

        $this->assertNotEmpty($card->getStorage());
        $this->assertCount(1, $card->getStorage());
        $this->assertEquals($transaction, $card->getStorage()->last());

        $this->expectException(CardAddTransactionException::class);

        $card->addStorageElement($transaction = new Transaction($card, new Type(Type::REMOVE), 13, new \DateTime()));
    }

    public function testRemoveTransaction()
    {
        $card = (new CardBuilder())->build();

        $this->assertCount(0, $card->getStorage());

        $card->addStorageElement($transaction1 = new Transaction($card, new Type(Type::ADD), 12, new \DateTime()));
        $card->addStorageElement($transaction2 = new Transaction($card, new Type(Type::REMOVE), 9, new \DateTime()));

        $this->assertCount(2, $card->getStorage());

        $this->assertTrue($card->getStorage()->contains($transaction1));
        $this->assertTrue($card->getStorage()->contains($transaction2));

        $removed = $card->removeStorageElement($transaction2);

        $this->assertEquals($transaction2, $removed);

        $this->assertTrue($card->getStorage()->contains($transaction1));
        $this->assertFalse($card->getStorage()->contains($transaction2));


        $this->assertCount(1, $card->getStorage());

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardTransactionRemoved::class, end($events));
    }

    public function testRemoveCard()
    {
        $card = (new CardBuilder())->build();

        $card->remove();

        $this->assertNotEmpty($events = $card->releaseEvents());
        $this->assertInstanceOf(CardRemoved::class, end($events));
    }

    public function testRemoveActiveCard()
    {
        $card = (new CardBuilder())->active()->build();

        $this->expectException(CardActiveRemoveException::class);

        $card->remove();
    }

}

/*{
    id: 25
    name: 'Лапти la lapte de noir',
    price: {
        value: '125',
        type: 'grn'
    }
    filters: [
        {name: size, value: 25},
        {name: color, value: 'blue'},
        {name: type, value: 'felt boots'},
        {name: material, value: 'felt'},
        {name: season, value: 'summer'}
    ],
    create_date: '2016-04-12 12:34:00',
    current_status = 'unobtainable',
    statuses: [
        {status: 'active', date: '2016-04-12 12:34:07'},
        {status: 'unobtainable', date: '2016-04-13 12:56:23'},
    ];
}*/
