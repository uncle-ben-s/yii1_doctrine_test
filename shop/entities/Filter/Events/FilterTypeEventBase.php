<?php


namespace shop\entities\Filter\Events;


use shop\entities\Filter\FilterType;

class FilterTypeEventBase
{
    /**
     * @var FilterType
     */
    protected $filterType;
    /**
     * @var string
     */
    protected $message;

    /**
     * @return FilterType
     */
    public function getFilterType(){
        return $this->filterType;
    }

    /**
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }
}