<?php
$this->pageTitle=Yii::app()->name . ' - Cards';
$this->breadcrumbs=array(
    'Card' => [$id],
    'Storage',
);
?>

<div>
    <h1>Storage</h1>

    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.dataTables-1.10.20.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/buttons.dataTables-1.6.0.min.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.dataTables-1.10.20.min.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dataTables.buttons-1.6.0.min.js', CClientScript::POS_END); ?>

    <table id="storage" class="display" width="100%"></table>

    <?php Yii::app()->clientScript
    ->registerScript('filterTypeTable', "
    var dataSet = ". json_encode($storage) ." || [];
    $(document).ready(function() {
        $('#storage').DataTable( {
            data: dataSet,
            columns: [
                { title: 'Id' },
                { title: 'Type' },
                { title: 'Amount' },
                { title: 'Created' }
            ],
            dom: 'Bfrtip',
            buttons: [
            {
                text: 'Add Transaction',
                action: function ( e, dt, node, config ) {
                    window.location = '" . Yii::app()->createUrl("card/".$id."/transaction") . "';
                }
            }
        ]
        } );
    } );");
    ?>
</div>
