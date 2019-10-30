<?php
$this->pageTitle=Yii::app()->name . ' - Card';
$this->breadcrumbs=array(
    'Card' => [$id],
    'Card add filter',
);
?>

<div class="form-block">
    <h1>Card add filter</h1>

    <p>Please fill out the following form:</p>

    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'card-add-filter-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->labelEx($model,'filterTypeId'); ?>
            <?php echo $form->dropDownList($model,'filterTypeId',$model->getFilterTypes(),
                array(
                    'prompt'=>'---Select Filter Type---',
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('card/filterAjax2'),
                        'update'=>'#app_models_CardFilterForm_filterId',
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
            <?php echo CHtml::submitButton('Add filter'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
