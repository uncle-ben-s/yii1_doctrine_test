<?php


namespace app\models;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use shop\Services\Filter\Filter;
use shop\Services\Filter\FilterType;

class FilterForm extends \CFormModel
{
    public $value;
    public $filterTypeId;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            array('filterTypeId, value', 'required'),
            array('value', 'length', 'min'=>1, 'max'=>150,)
        ];
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'value'=>'Filter value',
            'filterTypeId'=>'Filter type',
        ];
    }

    public function getFilterTypes(){
        $types = [];
        /**
         * @var \shop\entities\Filter\FilterType $type
         */
        foreach(\Yii::app()->DI->container->get(FilterType::class)->getAll() as $type){
            $types[$type->getId()] = $type->getName();
        }

        return $types;
    }

    /**
     * @return bool
     */
    public function create()
    {
        try{
            \Yii::app()->DI->container->get(Filter::class)->create($this->filterTypeId, $this->value);
        }catch(UniqueConstraintViolationException $e){
            $this->addError('value', 'Filter selected type with value "' . $this->value . '" already exist!');
            return false;
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function update($id)
    {
        try{
            \Yii::app()->DI->container->get(Filter::class)->update($id,$this->filterTypeId, $this->value);
        }catch(UniqueConstraintViolationException $e){
            $this->addError('value', 'Filter selected type with value "' . $this->value . '" already exist!');
            return false;
        }

        return true;
    }

}