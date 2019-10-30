<?php


namespace app\models;

use shop\Services\Filter\FilterType;
use shop\entities\Filter\Exceptions\FilterTypeDoubleException;

class FilterTypeForm extends \CFormModel
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
            array('name', 'required'),
            array('name', 'length', 'min'=>2, 'max'=>150,)
        ];
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array('name'=>'Filter type name');
    }

    /**
     * @return bool
     */
    public function create()
    {
        try{
            \Yii::app()->DI->container->get(FilterType::class)->create($this->name);
        }catch(FilterTypeDoubleException $e){
            $this->addError('name',$e->getMessage());
            return false;
        }

        return true;
    }

}