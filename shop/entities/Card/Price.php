<?php

namespace shop\entities\Card;

use Webmozart\Assert\Assert;

class Price
{
    private $id;
    /**
     * @var Currency
     */
    private $currency;
    /**
     * @var integer
     */
    private $value;

    /**
     * Price constructor.
     * @param Currency $currency
     * @param integer $value
     */
    public function __construct(Currency $currency, $value){
        Assert::integerish($value);

        $this->currency = $currency;
        $this->value = $value;
    }

    /**
     * @return Currency
     */
    public function getCurrency(){
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency){
        $this->currency = $currency;
    }

    /**
     * @param int $value
     */
    public function setValue($value){
        $this->value = $value;
    }
}