<?php

namespace app\controllers;

use app\components\ArrayDataProvider;
use components\Controller;
use app\models\FilterForm;
use shop\repositories\NotFoundException;
use shop\Services\Filter\Filter;

class FilterController extends Controller
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
                  'actions'=>array('index'),
                  'roles'=>array('view_only'),
            ),
            array('allow',
                  'actions'=>array('create', 'delete', 'update'),
                  'roles'=>array('manage_filter'),
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
        $list = [];
        try{
            $list = \Yii::app()->DI->container->get(Filter::class)->getAll();
        }catch(NotFoundException $e){
//            \Yii::app()->user->setFlash('info', 'Filters not found!');
        }

        $this->render('index', ['list' => new ArrayDataProvider($list)]);

    }

    public function actionCreate(){
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new FilterForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_FilterForm');
            if(!is_null($form)){
                $model->attributes = $form;
                if($model->validate() && $model->create()){
                    $this->redirect(['filter/index']);
                }
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id){
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new FilterForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_FilterForm');
            if(!is_null($form)){
                $model->attributes = $form;
                if($model->validate() && $model->update($id)){
                    $this->redirect(['filter/index']);
                }
            }
        }

        $filter = \Yii::app()->DI->container->get(Filter::class)->get($id);

        $model->attributes = ['value' => $filter->getValue(), 'filterTypeId' => $filter->getType()->getId()];

        $this->render('update', array('model' => $model));
    }

    public function actionDelete($id){
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        try{
            $filter = \Yii::app()->DI->container->get(Filter::class)->delete($id);
            \Yii::app()->user->setFlash('success', 'Filter "' . $filter->getValue() . '" deleted!');
        }catch(NotFoundException $e){
            \Yii::app()->user->setFlash('error', 'Action delete by id => "' . $id . '" failed: "' . $e->getMessage() . '"');
        }

        $this->redirect(['filter/index']);
    }
}