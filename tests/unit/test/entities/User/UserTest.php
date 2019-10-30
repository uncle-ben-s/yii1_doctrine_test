<?php

namespace tests\unit\test\entities\User;

use shop\entities\User\Events\UserCreated;
use shop\entities\User\Password;
use shop\entities\User\Role;
use shop\entities\User\User;

class UserTest extends \Codeception\Test\Unit
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
        $user = new User($role = new Role('admin'), $email = 'email', $pass = new Password(Password::hash($password = 'test')));

        $this->assertEquals($role, $user->getRole());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($pass, $user->getPass());


        $this->assertNotEmpty($events = $user->releaseEvents());
        $this->assertInstanceOf(UserCreated::class, end($events));
    }

    public function testUserPasswordVerify(){
        $user = new User($role = new Role('admin'), $email = 'email', $pass = new Password(Password::hash($password = 'test')));

        $this->assertTrue(Password::verify($password, $user->getPass()->getHash()));
    }

    public function testCreateUserWithOutEmail(){
        $email = '';

        $this->assertEmpty($email);

        $this->expectException(\InvalidArgumentException::class);

        new User(new Role('admin'), $email, new Password(Password::hash('test')));
    }


}
