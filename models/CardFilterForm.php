<?php


namespace app\models;

use shop\entities\Filter\Exceptions\CardFilterDoubleException;
use shop\repositories\NotFoundException;
use shop\Services\Card\Card;
use shop\Services\Filter\FilterType;

class CardFilterForm extends \CFormModel
{
    public $filterTypeId;
    public $filterId;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            ['filterTypeId', 'numerical', 'min'=>1, 'max'=>999],
            ['filterId', 'numerical', 'min'=>1, 'max'=>9999],
        ];
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'filterTypeId'=>'Filter Type Name',
            'filterId'=>'Filter Value',
        ];
    }

    public function getFilterTypes(){
        $filterTypes = [];
        try{
            /**
             * @var \shop\entities\Filter\FilterType $filterType
             */
            foreach(\Yii::app()->DI->container->get(FilterType::class)->getAll() as $filterType){
                $filterTypes[$filterType->getId()] = $filterType->getName();
            }
        }catch(NotFoundException $e){}

        return $filterTypes;
    }

    public function addFilter($cardId)
    {
        try{
            \Yii::app()->DI->container->get(Card::class)->addFilter($cardId, $this->filterId);
            \Yii::app()->user->setFlash('success', 'Filter added successfully');
            return true;
        }catch(NotFoundException $e){
            $this->addError('filterId', $e->getMessage());
            return false;
        }catch(CardFilterDoubleException $e){
            $this->addError('filterId', $e->getMessage());
            return false;
        }catch(\Exception $e){
            $this->addError('filterId', 'Filter add operation failed!');
            return false;
        }
    }
}