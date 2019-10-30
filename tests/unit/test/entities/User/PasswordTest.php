<?php

use shop\entities\User\Password;

class PasswordTest extends \Codeception\Test\Unit
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
        $password = new Password(Password::hash($pass = 'test'));

        $this->assertEquals($password->getHash(), Password::hash($pass));
    }

    public function testCreateInvalidArgument(){
        $this->expectException(InvalidArgumentException::class);
        new Password('');
    }

    public function testVerify(){
        $pass = 'test';

        $this->assertTrue(Password::verify($pass, Password::hash($pass)));
    }

}
