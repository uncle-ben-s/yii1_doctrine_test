<?php
$this->pageTitle=Yii::app()->name . ' - Currency';
$this->breadcrumbs=array(
    'Currency',
);
?>

<div class="form-block">
    <h1>Currency create</h1>

    <p>Please fill out the following form:</p>

    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'currency-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name'); ?>
            <?php echo $form->error($model,'name'); ?>
            <p class="hint"></p>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'code'); ?>
            <?php echo $form->textField($model,'code'); ?>
            <?php echo $form->error($model,'code'); ?>
            <p class="hint"></p>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Create'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
