
<div class="post">
	<div class="title">
        <?= $data->getName() . ' [ id:' . $data->getId() . ' ]' ?>
	</div>
    <?php if(Yii::app()->user->checkAccess('manage_filter')){ ?>
    <div class="nav">
        <b>Actions:</b>
        <?= CHtml::link('Delete', ['filterType/delete/' . $data->getId()]); ?>
    </div>
    <?php } ?>
</div>