<?php

namespace shop\entities\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use shop\entities\Filter\Exceptions\CardFilterDoubleException;
use shop\entities\Filter\Exceptions\CardFilterNotFoundException;

class Filters extends ArrayCollection
{
    /**
     * @param Filter[] $elements
     * @return Filters
     */
    public static function fromItems($elements)
    {
        return new self($elements);
    }

    public static function fromDoctrine(PersistentCollection $collection)
    {
        return new self($collection);
    }

    /**
     * Filters constructor.
     * @param Filter[]|PersistentCollection $filters
     */
    public function __construct($filters)
    {
        if (!$filters) {
            throw new CardFilterNotFoundException();
        }

        $this->clear();

        foreach ($filters as $filter) {
            $this->add($filter);
        }
    }

    /**
     * @param Filter $filter
     */
    public function add($filter)
    {
        if($this->contains($filter)){
            throw new CardFilterDoubleException();
        }

        parent::add($filter);
    }

    /**
     * @param Filter $filter
     * @return Filter
     */
    public function removeFilter($filter)
    {
        if(!$this->removeElement($filter)){
            throw new CardFilterNotFoundException();
        }

        return $filter;
    }

    /**
     * @return Filter[]
     */
    public function getAll()
    {
        return $this->toArray();
    }
}