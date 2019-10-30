<?php

namespace shop\entities\Card;


use Webmozart\Assert\Assert;

class Status
{
    const ACTIVE = 'active';
    const UNOBTAINABLE = 'close';

    /**
     * @var string
     */
    private $statusName;

    /**
     * Status constructor.
     * @param $statusName
     */
    public function __construct($statusName){
        Assert::oneOf($statusName, [self::ACTIVE, self::UNOBTAINABLE]);
        $this->statusName = $statusName;
    }

    /**
     * @return bool
     */
    public function isUnobtainable(){
        return $this->statusName === self::UNOBTAINABLE;
    }

    /**
     * @return bool
     */
    public function isActive(){
        return $this->statusName === self::ACTIVE;
    }

    /**
     * @return string
     */
    public function getStatusName(){
        return $this->statusName;
    }


}