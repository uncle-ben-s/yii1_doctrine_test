<?php

namespace tests\unit\entities\card;


use shop\entities\Card\Card;
use shop\entities\Card\Currency;
use shop\entities\Filter\Filters;
use shop\entities\Filter\FilterType;
use shop\entities\Card\Price;
use shop\entities\Filter\Filter;

class CardBuilder
{
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Price
     */
    private $price;
    /**
     * @var Filters
     */
    private $filters;
    /**
     * @var bool
     */
    private $active = false;

    public function __construct(){
        $this->date = new \DateTime();
        $this->name = 'Лапти la lapte de noir';
        $this->price = new Price(new Currency('uans', 'grn'), 125);
        $this->filters = Filters::fromItems([
            new Filter(new FilterType('size'), '25'),
            new Filter(new FilterType('color'), 'blue'),
            new Filter(new FilterType('type'), 'felt boots'),
            new Filter(new FilterType('material'), 'felt'),
            new Filter(new FilterType('season'), 'summer'),
        ]);
    }

    public function withOutName(){
        $clone = clone $this;
        $clone->name = null;

        return $clone;
    }

    public function withOutCreateDate(){
        $clone = clone $this;
        $clone->date = null;

        return $clone;
    }

    public function withFilters(Filters $filters){
        $clone = clone $this;
        $clone->filters = $filters;

        return $clone;
    }

    public function active(){
        $clone = clone $this;
        $clone->active = true;

        return $clone;
    }

    /**
     * @return Card
     * @throws \Exception
     */
    public function build(){
        $card = new Card($this->date, $this->name, $this->price, $this->filters);
        if($this->active){
            $card->activate(new \DateTime());
        }

        return $card;
    }
}