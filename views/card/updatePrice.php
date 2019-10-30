<?php
$this->pageTitle=Yii::app()->name . ' - Card Price update';
$this->breadcrumbs=array(
    'Card Price update',
);
?>

<div class="form-block">
    <h1>Card Price update</h1>

    <p>Please fill out the following form:</p>

    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'card-price-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->labelEx($model,'currencyId'); ?>
            <?php echo $form->dropDownList($model,'currencyId',$model->getCurrency(),

                array('prompt'=>'---Select currency---')); ?>
            <?php echo $form->error($model,'currencyId'); ?>
            <p class="hint"></p>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'priceValue'); ?>
            <?php echo $form->textField($model,'priceValue'); ?>
            <?php echo $form->error($model,'priceValue'); ?>
            <p class="hint"></p>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Change'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
