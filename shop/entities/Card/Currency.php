<?php

namespace shop\entities\Card;


use Webmozart\Assert\Assert;

class Currency
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $name;

    /**
     * Currency constructor.
     * @param string $name
     * @param string $code
     */
    public function __construct($name, $code){
        Assert::notEmpty($name);
        Assert::notEmpty($code);

        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(){
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }
}