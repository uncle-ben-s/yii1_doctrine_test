<?php

use shop\entities\Filter\Filter;
use shop\entities\Filter\FilterType;

class FilterTest extends \Codeception\Test\Unit
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
    public function testCreate()
    {
        $filter = new Filter(
            $filterType = new FilterType($filterTypeName = 'size'),
            $filterValue = '12');

        $this->assertEquals($filterType, $filter->getType());
        $this->assertEquals($filterTypeName, $filter->getType()->getName());
        $this->assertEquals($filterValue, $filter->getValue());
    }

    public function testChangeFilterType()
    {
        $filter = new Filter($filterType = new FilterType('size'), '12');

        $filterType1 = new FilterType('type');

        $this->assertEquals($filterType, $filter->getType());

        $filter->changeFilterType($filterType1);

        $this->assertEquals($filterType1, $filter->getType());
    }

    public function testChangeValue()
    {
        $filter = new Filter($filterType = new FilterType('size'), $value = '12');

        $value2 = '13';

        $this->assertEquals($value, $filter->getValue());

        $filter->changeValue($value2);

        $this->assertEquals($value2, $filter->getValue());
    }

    public function testIsEqualTo()
    {
        $filter = new Filter(new FilterType('size'), '12');
        $filter1 = new Filter(new FilterType('size'), '12');
        $filter2 = new Filter(new FilterType('size'), '121');

        $this->assertTrue($filter->isEqualTo($filter1));
        $this->assertFalse($filter->isEqualTo($filter2));
    }
}