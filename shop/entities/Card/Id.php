<?php

namespace shop\entities\Card;


use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    /**
     * @return string
     * @throws \Exception
     */
    public static function next(){
        return Uuid::uuid4()->toString();
    }

    /**
     * @var string
     */
    private $id;

    /**
     * Id constructor.
     * @param string $id
     */
    public function __construct($id)
    {
        Assert::notEmpty($id);

        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $other
     * @return bool
     */
    public function isEqualTo(int $other)
    {
        return $this->getId() === $other->getId();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}