<?php


namespace tests\unit\repositories;

use ProxyManager\Factory\AccessInterceptorValueHolderFactory;
use shop\entities\User\Password;
use shop\entities\User\User;
use shop\repositories\DoctrineUserRepository;
use shop\repositories\Interfaces\IUserRepository;
use shop\repositories\NotFoundException;
use shop\repositories\UserDoubleException;
use shop\entities\User\Role;

class UserRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var IUserRepository
     */
    protected $repository;

    /**
     * @var \UnitTester
     */
    public $tester;

    public function _before()
    {
        $em = $this->getModule('Doctrine2')->em;

        $repository = new DoctrineUserRepository($em, $em->getRepository(User::class));

        $this->repository = (new AccessInterceptorValueHolderFactory())->createProxy($repository, [
            'get' => function () use ($em) { $em->clear(); },
        ]);
    }

    public function testGet()
    {
        $user = new User($role = new Role('admin'), $email = 'email', $pass = new Password(Password::hash($password = 'test')));

        $this->assertEmpty($user->getId());

        $this->repository->add($user);

        $this->assertIsInt($user->getId());

        $found = $this->repository->get($user->getId());

        $this->assertNotNull($found);
        $this->assertEquals($user->getId(), $found->getId());
        $this->assertEquals($user->getPass()->getHash(), $found->getPass()->getHash());
        $this->assertEquals($user->getEmail(), $found->getEmail());
        $this->assertEquals($user->getRole()->getName(), $found->getRole()->getName());
    }



    public function testGetByEmail()
    {
        $user = new User($role = new Role('admin'), $email = 'email', $pass = new Password(Password::hash($password = 'test')));

        $this->assertEmpty($user->getId());

        $this->repository->add($user);

        $this->assertIsInt($user->getId());

        $found = $this->repository->getByEmail($email);

        $this->assertNotNull($found);
        $this->assertEquals($user->getId(), $found->getId());
        $this->assertEquals($user->getPass()->getHash(), $found->getPass()->getHash());
        $this->assertEquals($user->getEmail(), $found->getEmail());
        $this->assertEquals($user->getRole()->getName(), $found->getRole()->getName());
    }
    public function testGetByEmailNotFound()
    {
        $user = new User($role = new Role('admin'), $email = 'email', $pass = new Password(Password::hash($password = 'test')));

        $this->repository->add($user);

        $this->expectException(NotFoundException::class);

        $this->repository->getByEmail($email . '1');
    }

    public function testGetNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->get('ff');
    }

    public function testAdd()
    {
        $user = new User($role = new Role('admin'), $email = 'email', $pass = new Password(Password::hash($password = 'test')));

        $this->repository->add($user);

        $found = $this->repository->get($user->getId());

        $this->assertEquals($email, $found->getEmail());
        $this->assertEquals($role->getName(), $found->getRole()->getName());
        $this->assertEquals($pass, $found->getPass());
    }

    public function testAddDouble()
    {
        $user = new User($role = new Role('admin'), $email = 'email', $pass = new Password(Password::hash($password = 'test')));

        $this->repository->add($user);

        $this->expectException(UserDoubleException::class);

        $user2 = new User($role = new Role('guest'), $email = 'email', $pass = new Password(Password::hash($password = 'test1')));
        $this->repository->add($user2);
    }

    public function testRemove()
    {
        $user = new User($role = new Role('admin'), $email = 'email', $pass = new Password(Password::hash($password = 'test')));
        $this->repository->add($user);

        $id = $user->getId();

        $this->assertIsInt($id);

        $this->repository->remove($user);

        $this->expectException(NotFoundException::class);

        $this->repository->get($id);
    }
}