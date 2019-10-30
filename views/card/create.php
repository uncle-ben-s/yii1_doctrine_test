<?php
$this->pageTitle=Yii::app()->name . ' - Card';
$this->breadcrumbs=array(
    'Card',
);
?>

<div class="form-block">
    <h1>Card create</h1>

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

        <div class="row">
            <?php echo $form->labelEx($model,'filterTypeId'); ?>
            <?php echo $form->dropDownList($model,'filterTypeId',$model->getFilterTypes(),
                array(
                    'prompt'=>'---Select Filter Type---',
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('card/filterAjax'), //url to call.
                        //Style: CController::createUrl('currentController/methodToCall')
                        'update'=>'#app_models_CardForm_filterId', //selector to update
                        //'data'=>'js:javascript statement'
                        //leave out the data key to pass all form values through
                    ))
            ); ?>
            <?php echo $form->error($model,'filterTypeId'); ?>
            <p class="hint"></p>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'filterId'); ?>
            <?php echo $form->dropDownList($model, 'filterId', $filters,
                array(
                    'prompt'=>'---Select Filter Value---',)
            );  ?>
            <?php echo $form->error($model,'filterId'); ?>
            <p class="hint"></p>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Create'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
