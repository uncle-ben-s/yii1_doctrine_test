<?php

namespace app\controllers;

use components\Controller;
use shop\Services\History\HistoryType;
use shop\Services\Card\Card;
use shop\Services\History\History;
use shop\Services\User\User;

class HistoryController extends Controller
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
                  'actions'=>array('index', 'ajax'),
                  'roles'=>array('view_only'),
            ),
//            array('allow',
//                  'actions'=>array('create', 'delete', 'update'),
//                  'roles'=>array('manage_filter'),
//            ),
            array('deny',  // deny all users
                  'users'=>array('*'),
                  'deniedCallback' => function () {
                    $role = !empty(\Yii::app()->user->role)? \Yii::app()->user->role : 'guest';
                        \Yii::app()->user->setFlash('error', 'Role "' . $role . '" access deny to ' . \Yii::app()->urlManager->parseUrl(\Yii::app()->request));
                      $this->redirect(['site/index']);
                  }
            ),
        );
    }

    public function actionIndex()
    {
        $optionsCard = \Yii::app()->DI->container->get(Card::class)->getCardsToSelectOptions();
        $optionsType = \Yii::app()->DI->container->get(HistoryType::class)->getTypesToSelectOptions();
        $optionsUser = \Yii::app()->DI->container->get(User::class)->getUsersToSelectOptions();

        $this->render('index', [
            'optionsCard' => $optionsCard,
            'optionsType' => $optionsType,
            'optionsUser' => $optionsUser,
        ]);

    }

    public function actionAjax(){
        $response = \Yii::app()->DI->container->get(History::class)->getTables($_POST);

        echo json_encode($response);
    }

}