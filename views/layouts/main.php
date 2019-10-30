<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/menu.css" />
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">
        window.YiiShop = {};
    </script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div><!-- header -->

    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Home', 'url'=>array('site/index')),
                ['label' => 'Filter', 'url' => ['filter/index'], 'visible'=>!Yii::app()->user->isGuest,
                 'linkOptions'=> array(
                     'class' => '',// <a> has no class so <a class=''>
                 ),
                 'itemOptions' => array('class'=>'collapsed', 'data-toggle' => 'collapse','data-target'=>"#service", 'aria-expanded'=>"false"),//<li class='collapsed'>
                 'encodeLabel' => false,
                    'items' => [
                        ['label' => 'All Filters', 'url' => ['filter/index']],
                        ['label' => 'Create Filter', 'url' => ['filter/create'], 'visible' => Yii::app()->user->checkAccess('manage_filter')],
                    ],
                 'id' => 'services',
                ],
                ['label' => 'Filter Type', 'url' => ['filterType/index'], 'visible'=>!Yii::app()->user->isGuest, 'items' => [
                    ['label' => 'All Filter Types', 'url' => ['filterType/index']],
                    ['label' => 'Create Filter Type', 'url' => ['filterType/create'], 'visible' => Yii::app()->user->checkAccess('manage_filter')],
                ]],
                ['label' => 'Card', 'url' => ['card/index'], 'visible'=>!Yii::app()->user->isGuest, 'items' => [
                    ['label' => 'All Cards', 'url' => ['card/index']],
                    ['label' => 'Create Card', 'url' => ['card/create'], 'visible' => Yii::app()->user->checkAccess('manage_card')],
                ]],
                ['label' => 'Currency', 'url' => ['currency/index'], 'visible'=>!Yii::app()->user->isGuest, 'items' => [
                    ['label' => 'Create Currency', 'url' => ['currency/create'], 'visible' => Yii::app()->user->checkAccess('manage_filter')],
                ]],
                ['label'=>'History', 'url'=>array('history/index'), 'visible'=>!Yii::app()->user->isGuest],
                array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
            'id'=>"menu-content",
            'encodeLabel' => false,
            'htmlOptions' => array(
                'class'=>'menu-content collapse out',
            ),
            'submenuHtmlOptions' => array(
                'class' => 'sub-menu collapse',//<ul class="sub-menu collapse">
                'id'=>'service'
            )
        )); ?>
    </div><!-- mainmenu -->

    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->

    <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>

    <?php echo $content; ?>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
        All Rights Reserved.<br/>
        <?php echo Yii::powered(); ?>
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>