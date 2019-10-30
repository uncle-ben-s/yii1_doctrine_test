<?php

use shop\entities\Filter\Events\FilterTypeCreated;
use shop\entities\Filter\FilterType;

class FilterTypeTest extends \Codeception\Test\Unit
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

    // tests
    public function testCreate(){
        $filter = new FilterType($name = 'size');

        $this->assertEquals($name, $filter->getName());

        $this->assertNotEmpty($events = $filter->releaseEvents());
        $this->assertInstanceOf(FilterTypeCreated::class, end($events));
    }

    public function testIsEqualTo(){
        $filter = new FilterType('size');

        $filter1 = new FilterType('size');

        $filter2 = new FilterType('type');

        $this->assertTrue($filter->isEqualTo($filter1));
        $this->assertFalse($filter->isEqualTo($filter2));
    }
}