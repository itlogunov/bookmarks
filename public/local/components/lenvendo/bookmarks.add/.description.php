<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    'NAME' => 'Добавление закладки',
    'DESCRIPTION' => 'Добавление новой закладки',
    // 'ICON' => '/images/icon.gif',
    'CACHE_PATH' => 'Y',
    'SORT' => 40,
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
