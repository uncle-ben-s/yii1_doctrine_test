<?php

namespace app\controllers;

use components\Controller;
use app\models\CardFilterForm;
use app\models\CardForm;
use app\models\CardNameForm;
use app\models\CardPriceForm;
use app\models\CardTransactionForm;
use shop\entities\Filter\Exceptions\CardFilterNotFoundException;
use shop\repositories\NotFoundException;
use shop\Services\Card\Card;
use shop\Services\Filter\FilterType;

class CardController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control
        );
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                  'actions'=>array('index', 'view', 'storage'),
                  'roles'=>array('view_only'),
            ),
            array('allow',
                  'actions'=>array('transaction'),
                  'roles'=>array('manage_storage'),
            ),
            array('allow',
                  'actions'=>array('addFilter', 'deleteFilter', 'filterAjax', 'filterAjax2', 'create', 'updatePrice', 'updateName'),
                  'roles'=>array('manage_card'),
            ),
            array('deny',  // deny all users
                  'users'=>array('*'),
                  'deniedCallback' => function () {
                      \Yii::app()->user->setFlash('error', 'Role "'. \Yii::app()->user->role .'" access deny to ' . \Yii::app()->urlManager->parseUrl(\Yii::app()->request));
                      $this->redirect(['site/index']);
                  }
            ),
        );
    }

    public function actionIndex()
    {
        $cards = [];
        try{
            /**
             * @var \shop\entities\Card\Card $card
             */
            foreach(\Yii::app()->DI->container->get(Card::class)->getAll() as $card){
                $cards[] = [
                    $card->getId(),
                    $card->getName(),
                    $card->getPrice()->getValue() . ' ' . $card->getPrice()->getCurrency()->getCode(),
                    $card->getCreateDate()->format('Y-m-d H:i:s'),
                    $card->getStatus()->getStatusName(),
                    $card->getStorage()->getAmount(),
                ];
            }

        }catch(NotFoundException $e){
            \Yii::app()->user->setFlash('info', 'Cards not found!');
        }

        $this->render('index', ['cards' => $cards]);

    }

    public function actionStorage($id)
    {
        $storage = [];
        try{
            /**
             * @var \shop\entities\Storage\Transaction $transaction
             */
            foreach(\Yii::app()->DI->container->get(Card::class)->get($id)->getStorage() as $transaction){
                $storage[] = [
                    $transaction->getId(),
                    $transaction->getType()->getName(),
                    $transaction->getAmount(),
                    $transaction->getCreateDate()->format('Y-m-d H:i:s'),
                ];
            }

        }catch(NotFoundException $e){
            \Yii::app()->user->setFlash('info', 'Cards not found!');
        }

        $this->render('storage', ['storage' => $storage, 'id' => $id]);

    }

    public function actionTransaction($id)
    {
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new CardTransactionForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_CardTransactionForm');
            if(!is_null($form)){
                $model->attributes = $form;
                if($model->validate() && $model->addTransaction($id)){
                    $this->redirect(['card/' . $id . '/storage']);
                }
            }
        }

        $this->render('transaction', ['model' => $model, 'id' => $id]);

    }

    public function actionView($id)
    {

        try{
            $card = \Yii::app()->DI->container->get(Card::class)->get($id);
            $filters = [];
            /**
             * @var \shop\entities\Filter\Filter $filter
             */
            foreach($card->getFilters() as $filter){
                $filters[] = [$filter->getId(), $filter->getType()->getName(), $filter->getValue()];
            }

        }catch(NotFoundException $e){
            \Yii::app()->user->setFlash('error', 'Card with id "' . $id . '" not found!');
            $this->redirect(['card/index']);
            die;
        }

        $this->render('view', ['card' => $card, 'filters' => $filters]);

    }

    public function actionAddFilter($id)
    {

        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new CardFilterForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_CardFilterForm');
            if(!is_null($form)){
                $model->attributes = $form;
                if($model->validate() && $model->addFilter($id)){
                    $this->redirect(['card/' . $id]);
                }
            }
        }

        $filters = [];

        if(!empty($model->filterTypeId)){
            foreach(\Yii::app()->DI->container->get(FilterType::class)->getFilters($model->filterTypeId) as $filter){
                $filters[$filter->getId()] = $filter->getValue();
            }
        }

        $this->render('addFilter', ['model' => $model, 'filters' => $filters, 'id' => $id]);

    }

    public function actionDeleteFilter($cardId, $filterId){
        try{
            \Yii::app()->DI->container->get(Card::class)->removeFilter($cardId, $filterId);
            \Yii::app()->user->setFlash('success', 'Filter remove successfully!');
        }catch(CardFilterNotFoundException $e){
            \Yii::app()->user->setFlash('error', $e->getMessage());
        }

        $this->redirect(['card/' . $cardId]);
    }

    public function actionFilterAjax(){
        echo $this->getFiltersToDropDown('app_models_CardForm');
    }

    public function actionFilterAjax2(){
        echo $this->getFiltersToDropDown('app_models_CardFilterForm');
    }

    public function actionCreate(){
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new CardForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_CardForm');
            if(!is_null($form)){
                $model->attributes = $form;
                if($model->validate() && !is_null($card = $model->create())){
                    $this->redirect(['card/' . $card->getId()]);
                }
            }
        }

        $filters = [];

        if(!empty($model->filterTypeId)){
            foreach(\Yii::app()->DI->container->get(FilterType::class)->getFilters($model->filterTypeId) as $filter){
                $filters[$filter->getId()] = $filter->getValue();
            }
        }

        $this->render('create', ['model' => $model, 'filters' => $filters]);
    }

    public function actionUpdatePrice($id){
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new CardPriceForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_CardPriceForm');
            if(!is_null($form)){
                $model->attributes = $form;
                if($model->validate() && $model->updatePrice($id)){
                    $this->redirect(['card/' . $id]);
                }
            }
        }

        $card = \Yii::app()->DI->container->get(Card::class)->get($id);
        $model->attributes = [
            'currencyId' => $card->getPrice()->getCurrency()->getId(),
            'priceValue' => $card->getPrice()->getValue()
        ];

        $this->render('updatePrice', ['model' => $model]);
    }

    public function actionUpdateName($id){
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new CardNameForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_CardNameForm');
            if(!is_null($form)){
                $model->attributes = $form;
                if($model->validate() && $model->updateName($id)){
                    $this->redirect(['card/' . $id]);
                }
            }
        }

        $card = \Yii::app()->DI->container->get(Card::class)->get($id);
        $model->attributes = [
            'name' => $card->getName(),
        ];

        $this->render('updateName', ['model' => $model]);
    }

    private function getFiltersToDropDown($formName){
        $filters = \CHtml::tag('option', array('value'=>''), \CHtml::encode('---Select Filter Value---'),true);
        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost($formName);
            if(!is_null($form) && !empty($form['filterTypeId'])){
                foreach(\Yii::app()->DI->container->get(FilterType::class)->getFilters($form['filterTypeId']) as $filter){
                    $filters .= \CHtml::tag('option', array('value'=>$filter->getId()), \CHtml::encode($filter->getValue()),true);
                }
            }
        }
        return $filters;
    }
}