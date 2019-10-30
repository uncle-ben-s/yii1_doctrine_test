<?php
$this->pageTitle=Yii::app()->name . ' - Currency';
$this->breadcrumbs=array(
    'Currency',
);
?>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$list,
    'itemView'=>'_view',
    /*'sortableAttributes'=>array(
        'name',
    ),*/
));
?>

