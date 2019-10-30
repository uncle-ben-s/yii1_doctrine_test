<?php

$this->pageTitle=Yii::app()->name . ' - Histories';
$this->breadcrumbs=array(
    'Histories',
);
?>

    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.dataTables-1.10.20.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/buttons.dataTables-1.6.0.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui-1.12.1.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.dataTables.yadcf.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.dataTables-1.10.20.min.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dataTables.buttons-1.6.0.min.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui-1.12.1.min.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.dataTables.yadcf.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/historyTable.js', CClientScript::POS_END); ?>

    <table id="histories" class="display dataTable" width="100%"></table>

    <?php
    Yii::app()->clientScript
    ->registerScript('filterTypeTable', "
        window.YiiShop = window.YiiShop || {};
        window.YiiShop.cardOptions = ". json_encode($optionsCard) ." || [];
        window.YiiShop.optionsType = ". json_encode($optionsType) ." || [];
        window.YiiShop.optionsUser = ". json_encode($optionsUser) ." || [];
    ", CClientScript::POS_BEGIN);
    ?>
