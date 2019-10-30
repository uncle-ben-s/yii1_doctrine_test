<?php
return array(

    /* Разрешения */

    'manage_card' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'управлять товарами',
        'bizRule' => null,
        'data' => null
    ),

    'manage_filter' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управлять фильтрами',
        'bizRule' => null,
        'data' => null
    ),

    'manage_storage' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управлять хранилищем',
        'bizRule' => null,
        'data' => null
    ),

    'view_only' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Смотреть',
        'bizRule' => null,
        'data' => null
    ),

    /* Роли */

    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Гость',
        'bizRule' => null,
        'data' => null
    ),

//    'admin' => array(
    'employee' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Сотрудник',
        'children' => array(
            'view_only',
            'manage_storage',
        ),
        'bizRule' => null,
        'data' => null
    ),

//    'admin' => array(
    'manager' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Менеджер',
        'children' => array(
            'manage_card',
            'manage_storage',
            'view_only',
        ),
        'bizRule' => null,
        'data' => null
    ),

    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Администратор',
        'children' => array(
            'manage_filter',
            'manage_card',
            'manage_storage',
            'view_only',
        ),
        'bizRule' => null,
        'data' => null
    ),
);