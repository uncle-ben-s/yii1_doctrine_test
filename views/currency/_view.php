
<div class="post">
	<div class="title">
        <?= $data->getName() . ' [ id:' . $data->getId() . ' ] [' . $data->getCode() .']' ?>
	</div>
    <?php /*if(Yii::app()->user->checkAccess('manage_filter')){ */?><!--
    <div class="nav">
        <b>Actions:</b>
        <?/*= CHtml::link('Delete', ['currency/delete/' . $data->getId()]); */?>
    </div>
    --><?php /*} */?>
</div>