<?php
$this->pageTitle=Yii::app()->name . ' - Filter';
$this->breadcrumbs=array(
    'Filter',
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

