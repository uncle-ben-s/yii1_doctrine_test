<?php


namespace app\models;

use shop\entities\Storage\CardAddTransactionException;
use shop\entities\Storage\Transaction\Type;
use shop\repositories\NotFoundException;
use shop\Services\Card\Card;

class CardTransactionForm extends \CFormModel
{
    public $typeName;
    public $amount;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            ['typeName, amount', 'required'],
            ['typeName', 'length', 'min'=>1, 'max'=>10],
            ['typeName', 'match', 'pattern'=>'/^add|remove$/'],
            ['amount', 'numerical', 'min'=>1, 'max'=>9999],
        ];
    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'typeName'=>'Transaction Type Name',
            'amount'=>'Amount',
        ];
    }

    public function getTransactionTypes(){
        return Type::getTypes();
    }

    public function addTransaction($cardId)
    {
        try{
            \Yii::app()->DI->container->get(Card::class)->addTransaction($cardId, $this->typeName, $this->amount);
            \Yii::app()->user->setFlash('success', 'Transaction added successfully');
            return true;
        }catch(NotFoundException $e){
            \Yii::app()->user->setFlash('error', $e->getMessage());
            return false;
        }catch(CardAddTransactionException $e){
            \Yii::app()->user->setFlash('error', $e->getMessage());
            return false;
        }catch(\Exception $e){
            \Yii::app()->user->setFlash('error', 'Transaction add Fail.');
            return false;
        }
    }
}