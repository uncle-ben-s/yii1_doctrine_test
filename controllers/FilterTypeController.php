<?php

namespace app\controllers;

use app\components\ArrayDataProvider;
use components\Controller;
use app\models\FilterTypeForm;
use shop\Services\Filter\FilterType;
use shop\repositories\NotFoundException;

class FilterTypeController extends Controller
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
                  'actions'=>array('create', 'delete'),
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
            $list = \Yii::app()->DI->container->get(FilterType::class)->getAll();
        }catch(NotFoundException $e){
//            \Yii::app()->user->setFlash('info', 'Filters not found!');
        }

        $this->render('index', ['list' => new ArrayDataProvider($list)]);
    }

    public function actionCreate(){
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new FilterTypeForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_FilterTypeForm');
            if(!is_null($form)){
                $model->attributes = $form;
                if($model->validate() && $model->create()){
                    $this->redirect(['filterType/index']);
                }
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionDelete($id){
        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        try{
            $type = \Yii::app()->DI->container->get(FilterType::class)->delete($id);
            \Yii::app()->user->setFlash('success', 'Filter type "' . $type->getName() . '" deleted!');
        }catch(NotFoundException $e){
            \Yii::app()->user->setFlash('error', 'Action delete by id => "' . $id . '" failed: "' . $e->getMessage() . '"');
        }

        $this->redirect(['filterType/index']);
    }
}