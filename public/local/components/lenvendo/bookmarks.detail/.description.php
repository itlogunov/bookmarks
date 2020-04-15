<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    'NAME' => Loc::getMessage('NAME'),
    'DESCRIPTION' => Loc::getMessage('DESCRIPTION'),
    // 'ICON' => '/images/icon.gif',
    'CACHE_PATH' => 'Y',
    'SORT' => 30,
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
