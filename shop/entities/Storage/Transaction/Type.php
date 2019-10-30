<?php


namespace shop\entities\Storage\Transaction;


use Webmozart\Assert\Assert;

class Type
{
    const ADD = 'add';
    const REMOVE = 'remove';

    public static function getTypes(){
        return [self::ADD => self::ADD, self::REMOVE => self::REMOVE];
    }

    /**
     * @var string
     */
    private $name;

    /**
     * Type constructor.
     * @param string $name
     */
    public function __construct($name){
        Assert::oneOf($name, [self::ADD, self::REMOVE]);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }
}