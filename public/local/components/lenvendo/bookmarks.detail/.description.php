<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    'NAME' => 'Детальная закладка',
    'DESCRIPTION' => 'Вывод карточки закладки',
    // 'ICON' => '/images/icon.gif',
    'CACHE_PATH' => 'Y',
    'SORT' => 30,
    'COMPLEX' => 'N',
    'PATH' => [
        'ID' => 'lenvendo',
        'NAME' => 'Lenvendo',
        'CHILD' => [
            'ID' => 'lenvendo_bookmarks',
            'NAME' => 'Закладки'
        ]
    ]
];
