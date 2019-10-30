<?php
$this->pageTitle=Yii::app()->name . ' - Card';
$this->breadcrumbs=array(
    'Card' => [$id],
    'Storage' => ['card/' . $id . '/storage'],
    'Card add transaction',
);
?>

<div class="form-block">
    <h1>Card add transaction</h1>

    <p>Please fill out the following form:</p>

    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'card-add-transaction-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->labelEx($model,'typeName'); ?>
            <?php echo $form->dropDownList($model, 'typeName', $model->getTransactionTypes(),
                array(
                    'prompt'=>'---Select Type Value---',)
            );  ?>
            <?php echo $form->error($model,'typeName'); ?>
            <p class="hint"></p>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'amount'); ?>
            <?php echo $form->textField($model,'amount'); ?>
            <?php echo $form->error($model,'amount'); ?>
            <p class="hint"></p>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Add transaction'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
