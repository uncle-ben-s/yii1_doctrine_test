<?php


namespace app\models;

use shop\Services\Card\Card;

class CardNameForm extends \CFormModel
{
    public $name;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'length', 'min'=>1, 'max'=>255],
        ];
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'name'=>'Card name',
        ];
    }

    public function updateName($id)
    {
        try{
            \Yii::app()->DI->container->get(Card::class)->updateName($id, $this->name);
            \Yii::app()->user->setFlash('success', 'Card name change successfully!');
            return true;
        }catch(\Exception $e){
            $this->addError('name', 'Card rename failed!');
            return false;
        }
    }
}