<?php


namespace tests\unit\repositories;

use ProxyManager\Factory\AccessInterceptorValueHolderFactory;
use shop\entities\Filter\Exceptions\FilterTypeDoubleException;
use shop\entities\Filter\FilterType;
use shop\repositories\DoctrineFilterTypeRepository;
use shop\repositories\FilterTypeRepository;
use shop\repositories\NotFoundException;

class FilterTypeRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var FilterTypeRepository
     */
    protected $repository;

    /**
     * @var \UnitTester
     */
    public $tester;

    public function _before()
    {
        $em = $this->getModule('Doctrine2')->em;

        $repository = new DoctrineFilterTypeRepository($em, $em->getRepository(FilterType::class));

        $this->repository = (new AccessInterceptorValueHolderFactory())->createProxy($repository, [
            'get' => function () use ($em) { $em->clear(); },
        ]);
    }

    public function testGet()
    {
        $type = new FilterType('zise');

        $this->repository->add($type);

        $found = $this->repository->get($type->getId());

        $this->assertNotNull($found);
        $this->assertEquals($type->getId(), $found->getId());
        $this->assertEquals($type->getName(), $found->getName());
    }

    public function testGetAll()
    {
        $type = new FilterType('zise');
        $type2 = new FilterType('zisez');

        try{
            $beginCnt = count($this->repository->getAll());
        }catch(NotFoundException $e){
            $beginCnt = 0;
        }

        $this->repository->add($type);
        $this->repository->add($type2);

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
        $type = new FilterType($name = 'zise');

        $this->repository->add($type);

        $found = $this->repository->get($type->getId());

        $this->assertEquals($name, $found->getName());
        $this->assertTrue($type->isEqualTo($found));

        $this->expectException(FilterTypeDoubleException::class);

        $this->repository->add(new FilterType($name = 'zise'));
    }

    public function testRemove()
    {
        $type = new FilterType($name = 'zise');
        $this->repository->add($type);

        $id = $type->getId();

        $this->assertIsInt($id);

        $this->repository->remove($type);

        $this->expectException(NotFoundException::class);

        $this->repository->get($id);
    }

    public function testRemoveById()
    {
        $type = new FilterType($name = 'zise');
        $this->repository->add($type);

        $id = $type->getId();

        $this->assertIsInt($id);

        $this->repository->removeById($id);

        $this->expectException(NotFoundException::class);

        $this->repository->get($id);
    }
}