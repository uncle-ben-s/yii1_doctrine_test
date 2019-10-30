<?php


namespace shop\entities\History;


use Webmozart\Assert\Assert;

class Type
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    private $histories;

    /**
     * Type constructor.
     * @param string $name
     */
    public function __construct($name){
        Assert::notEmpty($name);
        $this->name = $name;
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

    /**
     * @return mixed
     */
    public function getHistories(){
        return $this->histories;
    }
}