<?php


namespace tests\unit\repositories;

use ProxyManager\Factory\AccessInterceptorValueHolderFactory;
use shop\entities\User\Role;
use shop\repositories\DoctrineRoleRepository;
use shop\repositories\Interfaces\IRoleRepository;
use shop\repositories\NotFoundException;
use shop\repositories\RoleDoubleException;

class RoleRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var IRoleRepository
     */
    protected $repository;

    /**
     * @var \UnitTester
     */
    public $tester;

    public function _before()
    {
        $em = $this->getModule('Doctrine2')->em;

        $repository = new DoctrineRoleRepository($em, $em->getRepository(Role::class));

        $this->repository = (new AccessInterceptorValueHolderFactory())->createProxy($repository, [
            'get' => function () use ($em) { $em->clear(); },
        ]);
    }

    public function testGet()
    {
        $role = new Role('ad_min');

        $this->assertEmpty($role->getId());

        $this->repository->add($role);

        $this->assertIsInt($role->getId());

        $found = $this->repository->get($role->getId());

        $this->assertNotNull($found);
        $this->assertEquals($role->getId(), $found->getId());
        $this->assertEquals($role->getName(), $found->getName());
    }



    public function testGetByName()
    {
        $name = 'ad_min';
        $role = new Role($name);

        $this->assertEmpty($role->getId());

        $this->repository->add($role);

        $this->assertIsInt($role->getId());

        $found = $this->repository->getByName($name);

        $this->assertNotNull($found);
        $this->assertEquals($role->getId(), $found->getId());
        $this->assertEquals($name, $found->getName());
    }
    public function testGetByEmailNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->getByName('my_test_role_name');
    }

    public function testGetNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->get('ff');
    }

    public function testAdd()
    {
        $role = new Role($name = 'ad_min');

        $this->assertEmpty($role->getId());

        $this->repository->add($role);

        $this->assertIsInt($role->getId());

        $found = $this->repository->get($role->getId());

        $this->assertEquals($name, $found->getName());
    }

    public function testAddDouble()
    {
        $name = 'ad_min';
        $role = new Role($name);

        $this->repository->add($role);

        $this->expectException(RoleDoubleException::class);

        $role2 = new Role($name);
        $this->repository->add($role2);
    }

    public function testRemove()
    {
        $role = new Role('ad_min');
        $this->repository->add($role);

        $id = $role->getId();

        $this->assertIsInt($id);

        $this->repository->remove($role);

        $this->expectException(NotFoundException::class);

        $this->repository->get($id);
    }
}