<?php


namespace tests\unit\repositories;


use Doctrine\ORM\PersistentCollection;
use shop\entities\Storage\Transaction;
use shop\entities\Storage\Transaction\Type;
use tests\unit\entities\card\CardBuilder;
use shop\entities\Card\Currency;
use shop\entities\Card\Price;
use shop\entities\Filter\Filter;
use shop\entities\Filter\Filters;
use shop\entities\Filter\FilterType;
use shop\repositories\CardRepository;
use shop\repositories\NotFoundException;

abstract class BaseRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var CardRepository
     */
    protected $repository;

    public function testGet()
    {
        $card = (new CardBuilder())->build();

        $this->assertIsNotInt($card->getId());

        $this->repository->add($card);

        $this->assertIsInt($card->getId());

        $found = $this->repository->get($card->getId());

        $this->assertNotNull($found);
        $this->assertEquals($card->getId(), $found->getId());
    }

    public function testGetNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->get('');
    }

    public function testAdd()
    {
        $card = (new CardBuilder())->withFilters(Filters::fromItems([
            $one = new Filter(new FilterType('size'), '25'),
            $two = new Filter(new FilterType('color'), 'blue'),
        ]))->build();

        $card->addStorageElement($transaction1 = new Transaction($card, new Type(Type::ADD), 12, new \DateTime()));
        $card->addStorageElement($transaction2 = new Transaction($card, new Type(Type::REMOVE), 9, new \DateTime()));

        $this->assertCount(2, $card->getFilters());
        $this->assertCount(2, $card->getStorage());

        $this->repository->add($card);

        $found = $this->repository->get($card->getId());

        $this->assertEquals($card->getId(), $found->getId());
        $this->assertEquals($card->getName(), $found->getName());
        $this->assertEquals($card->getStatus(), $found->getStatus());
        $this->assertTrue($this->isPriceEquals($card->getPrice(), $found->getPrice()));
        $this->assertEquals($card->getPrice()->getCurrency()->getCode(), $found->getPrice()->getCurrency()->getCode());

        $this->assertEquals(
            $card->getCreateDate()->getTimestamp(),
            $found->getCreateDate()->getTimestamp()
        );

        $this->assertCount(2, $found->getFilters());
        $this->assertCount(2, $found->getStorage());

        $this->assertTrue($this->filtersContainsTo([$one, $two], $found->getFilters()));
    }

    public function testSave()
    {
        $card = (new CardBuilder())->build();
        $filtersCnt = count($card->getFilters());

        $this->repository->add($card);

        $edit = $this->repository->get($card->getId());

        $edit->rename($name = 'new Name');
        $edit->addFilter($filter = new Filter(new FilterType('new filter type'), 'value'));
        $edit->activate(new \DateTime());
        $edit->changePrice($price = new Price(new Currency('money of ukraine', 'grn'), 36));

        $this->repository->save($edit);

        $found = $this->repository->get($card->getId());

        $this->assertTrue($found->isActive());
        $this->assertEquals($name, $found->getName());

        $this->assertTrue($this->isPriceEquals($price, $found->getPrice()));

        $this->assertCount($filtersCnt+1, $found->getFilters());

        $this->assertTrue($this->filtersContainsTo([$filter], $found->getFilters()));
    }

    public function testRemove()
    {
        $card = (new CardBuilder())->build();
        $this->repository->add($card);

        $id = $card->getId();

        $this->repository->remove($card);

        $this->expectException(NotFoundException::class);

        $this->repository->get($id);
    }

    public function testRemoveFilter(){
        $card = (new CardBuilder())->withFilters(Filters::fromItems([
            $filterSize = new Filter(new FilterType('size'), '12'),
            $filterMaterial = new Filter(new FilterType('material'), 'felt'),
        ]))->build();

        $this->assertIsNotInt($card->getId());

        $this->repository->add($card);

        $this->assertIsInt($card->getId());

        $filters = $card->getFilters();

        $this->assertEquals($filters->count(), 2);

        /**
         * @var Filter $filter
         */
        $filter = $filters->last();

        $card->removeFilter($filter);

        $this->repository->save($card);

        $found = $this->repository->get($card->getId());

        $this->assertEquals($found->getFilters()->count(), 1);

    }

    /**
     * @param Price $expected
     * @param Price $actual
     * @return mixed
     */
    private function isPriceEquals($expected, $actual){
        return $expected->getCurrency()->getCode() === $actual->getCurrency()->getCode()
            && $expected->getValue() === $actual->getValue();
    }


    /**
     * @param Filter[] $filters
     * @param Filters | PersistentCollection $filterCollection
     * @return bool
     */
    private function filtersContainsTo(array $filters, $filterCollection){
        $results = [];
        foreach($filters as $filter){
            $results[] = $filterCollection->exists(function($key,$element) use ($filter)
            {
                /**
                 * @var Filter $element
                 */
                return ($element->getValue() === $filter->getValue() && $element->getType()->getName() == $filter->getType()->getName());
            });
        }

        return count(array_filter($results)) === count($filters);
    }
}