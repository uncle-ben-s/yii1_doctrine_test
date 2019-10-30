<?php


namespace app\models;

use shop\entities\Card\Price;
use shop\repositories\NotFoundException;
use shop\Services\Card\Card;
use shop\Services\Card\Currency;
use shop\Services\Filter\Filter;
use shop\Services\Filter\FilterType;

class CardForm extends \CFormModel
{
    public $id;
    public $name;
    public $currencyId;
    public $priceValue;
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
            ['name, filterTypeId', 'required'],
            ['name', 'length', 'min'=>1, 'max'=>255],
            ['priceValue', 'numerical', 'min'=>1, 'max'=>99999,
                'tooSmall'=>'You must order at least 1 piece',
                'tooBig'=>'You cannot order more than 99999 pieces at once'
            ],
            ['currencyId', 'numerical', 'min'=>1, 'max'=>99],
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
            'name'=>'Card name',
            'currencyId'=>'Currency',
            'priceValue'=>'Cost',
            'filterTypeId'=>'Filter Type Name',
            'filterId'=>'Filter Value',
        ];
    }

    public function getCurrency(){
        $currencies = [];
        try{
            /**
             * @var \shop\entities\Card\Currency $currency
             */
            foreach(\Yii::app()->DI->container->get(Currency::class)->getAll() as $currency){
                $currencies[$currency->getId()] = $currency->getName();
            }
        }catch(NotFoundException $e){}

        return $currencies;
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

    /**
     * @return \shop\entities\Card\Card|null
     */
    public function create()
    {
        try{
            $currency = \Yii::app()->DI->container->get(Currency::class)->get($this->currencyId);
            return \Yii::app()->DI->container->get(Card::class)->create(
                $this->name,
                new Price($currency, $this->priceValue),
                \Yii::app()->DI->container->get(Filter::class)->get($this->filterId)
            );
        }catch(NotFoundException $e){
            $this->addError('filterId', 'Card created failed! ' . $e->getMessage());
            return null;
        }catch(\Exception $e){
            $this->addError('name', 'Card created failed!');
            return null;
        }
    }

}