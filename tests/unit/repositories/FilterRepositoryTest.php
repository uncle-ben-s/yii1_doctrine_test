<?php


namespace tests\unit\repositories;

use ProxyManager\Factory\AccessInterceptorValueHolderFactory;
use shop\entities\Filter\Filter;
use shop\entities\Filter\FilterType;
use shop\repositories\DoctrineFilterRepository;
use shop\repositories\FilterRepository;
use shop\repositories\NotFoundException;

class FilterRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var FilterRepository
     */
    protected $repository;

    /**
     * @var \UnitTester
     */
    public $tester;

    public function _before()
    {
        $em = $this->getModule('Doctrine2')->em;

        $repository = new DoctrineFilterRepository($em, $em->getRepository(Filter::class));

        $this->repository = (new AccessInterceptorValueHolderFactory())->createProxy($repository, [
            'get' => function () use ($em) { $em->clear(); },
        ]);
    }

    public function testGet()
    {
        $filter = new Filter($type = new FilterType('zise'), $value = '25');

        $this->repository->add($filter);

        $found = $this->repository->get($filter->getId());

        $this->assertNotNull($found);

        $this->assertEquals($filter->getId(), $found->getId());
        $this->assertEquals($type->getName(), $found->getType()->getName());
        $this->assertEquals($filter->getValue(), $found->getValue());
        $this->assertEquals($value, $found->getValue());
    }



    public function testGetAll()
    {
        $filter = new Filter(new FilterType('zise'), $value = '25');
        $filter2 = new Filter(new FilterType('zise'), $value = '25');

        try{
            $beginCnt = count($this->repository->getAll());
        }catch(NotFoundException $e){
            $beginCnt = 0;
        }

        $this->repository->add($filter);
        $this->repository->add($filter2);

        $afterCnt = count($this->repository->getAll());

        $this->assertEquals($afterCnt - $beginCnt, 2);
    }

    public function testGetNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->get('ff');
    }

    public function testAdd()
    {
        $filter = new Filter(new FilterType('zise'), '25');

        $this->assertEmpty($filter->getId());

        $this->repository->add($filter);

        $this->assertIsInt($filter->getId());
    }

    public function testRemove()
    {
        $filter = new Filter(new FilterType('zise'), '25');

        $this->assertEmpty($filter->getId());

        $this->repository->add($filter);

        $id = $filter->getId();

        $this->assertIsInt($id);

        $this->repository->remove($filter);

        $this->assertEmpty($filter->getId());

        $this->assertIsInt($filter->getType()->getId());

        $this->expectException(NotFoundException::class);

        $this->repository->get($id);
    }



    public function testRemoveById()
    {
        $filter = new Filter(new FilterType('zisez'), '25');
        $this->repository->add($filter);

        $id = $filter->getId();

        $this->assertIsInt($id);

        $this->repository->removeById($id);

        $this->expectException(NotFoundException::class);

        $this->repository->get($id);
    }
}