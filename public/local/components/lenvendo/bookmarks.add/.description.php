<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    'NAME' => Loc::getMessage('ADD_NAME'),
    'DESCRIPTION' => Loc::getMessage('ADD_DESCRIPTION'),
    // 'ICON' => '/images/icon.gif',
    'CACHE_PATH' => 'Y',
    'SORT' => 40,
    'COMPLEX' => 'N',
    'PATH' => [
        'ID' => 'lenvendo',
        'NAME' => 'Lenvendo',
        'CHILD' => [
            'ID' => 'lenvendo_bookmarks',
            'NAME' => Loc::getMessage('BOOKMARKS')
        ]
    ]
];
