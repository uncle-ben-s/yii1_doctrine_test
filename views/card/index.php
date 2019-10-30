<?php
$this->pageTitle=Yii::app()->name . ' - Cards';
$this->breadcrumbs=array(
    'Cards',
);
?>

<div>
    <h1>Cards</h1>

    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.dataTables-1.10.20.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/buttons.dataTables-1.6.0.min.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.dataTables-1.10.20.min.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dataTables.buttons-1.6.0.min.js', CClientScript::POS_END); ?>

    <table id="cards" class="display" width="100%"></table>

    <?php

    $btn = (!Yii::app()->user->checkAccess('manage_card'))?"":"
    ,
            dom: 'Bfrtip',
            buttons: [
            {
                text: 'Add Card',
                action: function ( e, dt, node, config ) {
                    window.location = '" . Yii::app()->createUrl("card/create") . "';
                }
            }
        ]
    ";

    Yii::app()->clientScript
    ->registerScript('filterTypeTable', "
    var dataSet = ". json_encode($cards) ." || [];
    $(document).ready(function() {
        $('#cards').DataTable( {
            data: dataSet,
            columns: [
                { title: 'Id' },
                { title: 'Name' },
                { title: 'Price' },
                { title: 'Created' },
                { title: 'Status' },
                { title: 'Amount' }
            ],
            columnDefs:[{'targets':6, 'data':'name', 'render': function(data,type,full,meta){
                    return '<a href=" . Yii::app()->createUrl("card") . "/'+full[0]+'>View</a>'
                }
            }]" . $btn . "
        } );
    } );");
    ?>
</div>
