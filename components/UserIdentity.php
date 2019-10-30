<?php


namespace app\components;


use shop\Services\User\User;
use shop\entities\User\Password;
use shop\repositories\NotFoundException;

class UserIdentity extends \CUserIdentity
{

    // Need to store the user's ID:
    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate(){

        try{
            $user = \Yii::app()->DI->container->get(User::class)->getByEmail($this->username);

            if(!Password::verify($this->password, $user->getPass()->getHash())){
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }else{
                $this->errorCode = self::ERROR_NONE;
                // Store the role in a session:
                $this->setState('role', $user->getRole()->getName());
                $this->_id = $user->getId();
            }

        }catch(NotFoundException $e){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }

        return !$this->errorCode;
    }

    public function getId(){
        return $this->_id;
    }
}