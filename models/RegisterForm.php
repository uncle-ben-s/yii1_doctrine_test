<?php


namespace app\models;

use shop\repositories\UserDoubleException;
use shop\Services\User\User;

class RegisterForm extends \CFormModel
{
    public $email;
    public $password;
    public $role;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            ['email, password, role', 'required'],
            ['email', 'email'],
            ['role', 'match', 'pattern'=>'/^admin|manager|employee$/'],
        ];
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'email'=>'Email Address',
            'role'=>'Role'
        ];
    }

    public function register()
    {
        try{
            \Yii::app()->DI->container->get(User::class)->register($this->email, $this->password, $this->role);
        }catch(UserDoubleException $e){
            $this->addError('email','Email double.');
            return false;
        }

        return true;
    }

}