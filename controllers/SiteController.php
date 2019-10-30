<?php

namespace app\controllers;

use components\Controller;
use app\models\LoginForm;
use app\models\RegisterForm;

class SiteController extends Controller
{
//    public $layout = 'column1';
    /**
     * Declares class-based actions.
     */
    /*public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }*/
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError(){
        if($error = \Yii::app()->errorHandler->error){
            if(\Yii::app()->request->isAjaxRequest)
                echo $error['message'];else
                $this->render('error', $error);
        }else{
            echo 'dont worry no error :)';
        }
    }

    public function actionLogout()
    {
        \Yii::app()->user->logout();
        $this->redirect(\Yii::app()->homeUrl);
    }

    public function actionLogin(){
        if (!\Yii::app()->user->getIsGuest()) {
            $this->redirect(['site/index']);
        }

        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new LoginForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_LoginForm');
            if(!is_null($form)){
                $model->attributes = $form;
                // validate user input and redirect to the previous page if valid
                if($model->validate() && $model->login()){
                    $this->redirect(['site/index']);
                }
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    public function actionRegister(){
        if (!\Yii::app()->user->getIsGuest()) {
            $this->redirect(['site/index']);
        }

        if(!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new \CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new RegisterForm();

        if(\Yii::app()->request->getIsPostRequest()){
            $form = \Yii::app()->request->getPost('app_models_RegisterForm');
            if(!is_null($form)){
                $model->attributes = $form;
                // validate user input and redirect to the previous page if valid
                if($model->validate() && $model->register()){
                    $this->redirect(['site/login']);
                }
            }
        }
        // display the login form
        $this->render('register', array('model' => $model));
    }

    /**
     * Displays the contact page
     */
    public function actionIndex(){
        $this->render('index');
    }
}