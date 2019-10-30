<?php


namespace shop\entities\Filter\Events;


use shop\entities\Filter\Filter;

class FilterCreated
{
    /**
     * FilterCreated constructor.
     * @param Filter $filter
     */
    public function __construct(Filter $filter){
    }
}