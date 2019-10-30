<?php
$this->pageTitle=Yii::app()->name . ' - Filter type';
$this->breadcrumbs=array(
    'Filter type',
);
?>

<div class="form-block">
    <h1>Filter type create</h1>

    <p>Please fill out the following form:</p>

    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'filterType-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name'); ?>
            <?php echo $form->error($model,'name'); ?>
            <p class="hint"></p>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Create'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
