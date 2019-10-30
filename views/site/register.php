<?php
$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
    'Register',
);
?>
<div class="form-block">
    <h1>Register</h1>

    <p>Please fill out the following form with your login credentials:</p>

    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email'); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'role'); ?>
            <?php echo $form->dropDownList($model,'role', [
                    'admin' => 'Администратор',
                    'manager' => 'Менеджер',
                    'employee' => 'Сотрудник'
            ],

                array('prompt'=>'---Select Role---')); ?>
            <?php echo $form->error($model,'role'); ?>
            <p class="hint">
                <?= CHtml::link('Login',array('site/login')); ?>
            </p>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Register'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>