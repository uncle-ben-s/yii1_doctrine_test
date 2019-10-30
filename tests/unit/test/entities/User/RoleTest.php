<?php

namespace tests\unit\test\entities\User;

use shop\entities\User\Role;

class RoleTest extends \Codeception\Test\Unit
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
        $role = new Role($name = 'admin');

        $this->assertEquals($role->getName(), $name);
    }
}
