<?php


namespace shop\entities\Filter\Events;


use shop\entities\Filter\FilterType;

class FilterTypeCreated extends FilterTypeEventBase
{
    /**
     * FilterCreated constructor.
     * @param FilterType $filterType
     */
    public function __construct(FilterType $filterType){
    }
}