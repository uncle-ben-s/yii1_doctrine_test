<?php
$this->pageTitle=Yii::app()->name . ' - Filter Type';
$this->breadcrumbs=array(
    'Filter Type',
);
?>

<?php //Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.dataTables-1.10.20.min.css'); ?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.dataTables-1.10.20.min.js', CClientScript::POS_END); ?>
<!---->
<!--<table id="example" class="display" width="100%"></table>-->
<!---->
<?php //Yii::app()->clientScript
//->registerScript('filterTypeTable', "
//var dataSet = ". json_encode($table['aaData']) ." || [];
//$(document).ready(function() {
//    $('#example').DataTable( {
//        data: dataSet,
//        columns: [
//            { title: \"Name\" }
//        ]
//    } );
//} );");
//?>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$list,
    'itemView'=>'_view',
    /*'sortableAttributes'=>array(
        'name',
    ),*/
));
?>

