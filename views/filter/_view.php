<?php
/** @var \shop\entities\Filter\Filter $data */
$data;
?>
<div class="post">
	<div class="title">
        <?= $data->getType()->getName() . ' | ' . $data->getValue() . ' [ id:' . $data->getId() . ' ]' ?>
	</div>
    <?php if(Yii::app()->user->checkAccess('manage_filter')){ ?>
    <div class="nav">
        <b>Actions:</b>
        <?= CHtml::link('Delete', ['filter/delete/' . $data->getId()]); ?> |
        <?= CHtml::link('Update', ['filter/update/' . $data->getId()]); ?>
    </div>
    <?php } ?>
</div>