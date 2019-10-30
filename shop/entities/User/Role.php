<?php

namespace shop\entities\User;

use Doctrine\ORM\Mapping as ORM;
use shop\entities\AggregateRoot;
use shop\entities\EventTrait;
use Webmozart\Assert\Assert;

/**
 * Role
 *
 * @ORM\Table(name="doctrine_role")
 * @ORM\Entity
 */
class Role
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=10, nullable=false, unique=true)
     */
    private $name;


    public function __construct($name){
        Assert::notEmpty($name);
        $this->name = $name;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

