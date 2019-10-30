<?php

namespace shop\entities\User;

use Doctrine\ORM\Mapping as ORM;
use shop\entities\AggregateRoot;
use shop\entities\EventTrait;
use Webmozart\Assert\Assert;

/**
 * User
 *
 * @ORM\Table(name="doctrine_user")
 * @ORM\Entity
 */
class User implements AggregateRoot
{
    use EventTrait;
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
     * @ORM\Column(name="email", type="string", length=80, nullable=false, unique=true)
     */
    private $email;

    /**
     * @var Password
     *
     */
    private $pass;

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="shop\entities\User\Role", cascade={"persist","merge"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    private $histories;

    /**
     * User constructor.
     * @param Role $role
     * @param string $email
     * @param Password $password
     */
    public function __construct(Role $role, $email, Password $password){
        Assert::notEmpty($email);
        $this->pass = $password;
        $this->role = $role;
        $this->email = $email;

        $this->recordEvent(new Events\UserCreated($this));
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pass
     *
     * @param Password $pass
     *
     * @return User
     */
    public function setPass(Password $pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return Password
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set role
     *
     * @param Role $role
     *
     * @return User
     */
    public function setRole(Role $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}

