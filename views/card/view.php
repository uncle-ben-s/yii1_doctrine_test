<?php
$this->pageTitle=Yii::app()->name . ' - Card';
$this->breadcrumbs=array(
    'Card [' . $card->getId() . ']',
);
/**
 * @var \shop\entities\Card\Card $card
 */
$card;

?>

<div>
    <h1>Card id[<?= $card->getId() ?>] view</h1>

    <div class="post">
        <div class="title">
            Card Status
        </div>
        <div class="content">
            <?= $card->getStatus()->getStatusName() ?>
        </div>
    </div>

    <div class="post">
        <div class="title">
            Card Name
        </div>
        <div class="content">
            <?= $card->getName() ?>
        </div>
        <?php if(Yii::app()->user->checkAccess('manage_card')){ ?>
        <div class="nav">
            <b>Actions:</b>
            <?= CHtml::link('Update', ['card/updateName/' . $card->getId()]); ?>
        </div>
        <?php } ?>
    </div>

    <div class="post">
        <div class="title">
            Card Price
        </div>
        <div class="content">
            <?= $card->getPrice()->getValue() . ' [' . $card->getPrice()->getCurrency()->getCode() . ']' ?>
        </div>
        <?php if(Yii::app()->user->checkAccess('manage_card')){ ?>
        <div class="nav">
            <b>Actions:</b>
            <?= CHtml::link('Update', ['card/updatePrice/' . $card->getId()]); ?>
        </div>
        <?php } ?>
    </div>

    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.dataTables-1.10.20.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/buttons.dataTables-1.6.0.min.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.dataTables-1.10.20.min.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dataTables.buttons-1.6.0.min.js', CClientScript::POS_END); ?>

    <table id="filters" class="display" width="100%"></table>

    <?php
    $btn = (!Yii::app()->user->checkAccess('manage_card'))?"":"
    {
                text: 'Add Filter',
                action: function ( e, dt, node, config ) {
                    window.location = '" . Yii::app()->createUrl("card/".$card->getId()."/addFilter") . "';
                }
            },
    ";
    $btnColumn = (!Yii::app()->user->checkAccess('manage_card'))?"":"
    columnDefs:[{'targets':3, 'data':'name', 'render': function(data,type,full,meta){
                    return '<a href=" . Yii::app()->createUrl("card/".$card->getId()."/deleteFilter") . "/'+full[0]+'>Delete</a>'
                }
            }],
    ";


    Yii::app()->clientScript
    ->registerScript('filterTypeTable', "
    var dataSet = ". json_encode($filters) ." || [];
    $(document).ready(function() {
        $('#filters').DataTable( {
            data: dataSet,
            columns: [
                { title: 'Id' },
                { title: 'Type' },
                { title: 'Value' }
            ]," . $btnColumn . "
            dom: 'Bfrtip',
            buttons: [" . $btn . "
            {
                text: 'Storage',
                action: function ( e, dt, node, config ) {
                    window.location = '" . Yii::app()->createUrl("card/".$card->getId()."/storage") . "';
                }
            }
        ]
        } );
    } );");
    ?>
</div>
