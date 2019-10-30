<?php


namespace shop\entities\User;


use Webmozart\Assert\Assert;

class Password
{
    /**
     * @var string
     */
    private $hash;

    /**
     * Password constructor.
     * @param string $hash
     */
    public function __construct($hash){
        Assert::notEmpty($hash);
        $this->hash = $hash;
    }

    /**
     * @param string $password
     * @return string
     */
    public static function hash($password){
        return sha1($password);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verify($password, $hash){
        return sha1($password) === $hash;
    }

    /**
     * @return string
     */
    public function getHash(){
        return $this->hash;
    }
}