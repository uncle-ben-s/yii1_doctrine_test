<?php


namespace app\models;

use shop\repositories\NotFoundException;
use shop\Services\Card\Card;
use shop\Services\Card\Currency;

class CardPriceForm extends \CFormModel
{
    public $currencyId;
    public $priceValue;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            ['priceValue', 'numerical', 'min'=>1, 'max'=>99999,
             'tooSmall'=>'You must order at least 1 piece',
             'tooBig'=>'You cannot order more than 99999 pieces at once'
            ],
            ['currencyId', 'numerical', 'min'=>1, 'max'=>99],
        ];
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'currencyId'=>'Currency',
            'priceValue'=>'Cost',
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

    public function updatePrice($cardId){
        try{
            $currency = \Yii::app()->DI->container->get(Currency::class)->get($this->currencyId);
            \Yii::app()->DI->container->get(Card::class)->updatePrice($cardId, $currency, $this->priceValue);
            \Yii::app()->user->setFlash('success', 'Price change successfully!');
            return true;
        }catch(\Exception $e){
            $this->addError('currencyId', 'Price change failed!');
            return false;
        }
    }
}