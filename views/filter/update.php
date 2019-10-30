<?php
$this->pageTitle=Yii::app()->name . ' - Filter';
$this->breadcrumbs=array(
    'Filter',
);
?>

<div class="form-block">
    <h1>Filter update</h1>

    <p>Please fill out the following form:</p>

    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'filterType-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->labelEx($model,'value'); ?>
            <?php echo $form->textField($model,'value'); ?>
            <?php echo $form->error($model,'value'); ?>
            <p class="hint"></p>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'filterTypeId'); ?>
            <?php echo $form->dropDownList($model,'filterTypeId',$model->getFilterTypes(),

                array('prompt'=>'---Select Filter Type---')); ?>
            <?php echo $form->error($model,'filterTypeId'); ?>
            <p class="hint"></p>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Update'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
