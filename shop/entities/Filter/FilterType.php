<?php

namespace shop\entities\Filter;


use shop\entities\AggregateRoot;
use shop\entities\EventTrait;

class FilterType implements AggregateRoot
{
    use EventTrait;

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    private $filters;

    /**
     * @return mixed
     */
    public function getFilters(){
        return $this->filters;
    }

    /**
     * FilterType constructor.
     * @param string $name
     */
    public function __construct($name){

        $this->name = $name;

        $this->recordEvent(new Events\FilterTypeCreated($this));
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param FilterType $filter
     * @return bool
     */
    public function isEqualTo(FilterType $filter){
        return $this->name === $filter->getName();
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }
}