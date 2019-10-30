<?php


namespace app\models;

use shop\Services\Card\Currency;

class CurrencyForm extends \CFormModel
{
    public $name;
    public $code;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            array('name, code', 'required'),
            array('name', 'length', 'min'=>2, 'max'=>150,),
            array('code', 'length', 'min'=>2, 'max'=>3,)
        ];
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'name'=>'Currency name',
            'code'=>'Currency code',
        );
    }

    /**
     * @return bool
     */
    public function create()
    {
        try{
            \Yii::app()->DI->container->get(Currency::class)->create($this->name, $this->code);
        }catch(\Exception $e){
            $this->addError('name',$e->getMessage());
            return false;
        }

        return true;
    }

}