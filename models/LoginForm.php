<?php


namespace app\models;

use app\components\UserIdentity;
use shop\repositories\UserDoubleException;
use shop\Services\User;

class LoginForm extends \CFormModel
{
    public $email;
    public $password;

    private $_identity;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // email and password are required
            array('email, password', 'required'),
            // email needs to be a email
            array('email', 'email'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array('email'=>'Email Address');
    }
    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     * @param string $attribute the name of the attribute to be validated.
     * @param array $params additional parameters passed with rule when being executed.
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())  // we only want to authenticate when no input errors
        {
            $identity=new UserIdentity($this->email,$this->password);
            $identity->authenticate();

            switch($identity->errorCode)
            {
                case UserIdentity::ERROR_NONE:
                    \Yii::app()->user->login($identity);
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('email','Email address is incorrect.');
                    break;
                default: // UserIdentity::ERROR_PASSWORD_INVALID
                    $this->addError('password','Password is incorrect.');
                    break;
            }
        }
    }
    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->email,$this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            //$duration=$this->rememberMe ? 3600 *24*30 : 0; // 30 days 1hour
            $duration = 0;
            \Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }
}