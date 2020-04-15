<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if (!Loader::includeModule('iblock')) {
    return;
}

// Типы инфоблоков
$infoBlocksTypes = CIBlockParameters::GetIBlockTypes();

// Активные инфоблоки
$infoBlocks = [];
$filter = ['ACTIVE' => 'Y'];

// Отфильтруем по выбранному типу инфоблока
if (!empty($arCurrentValues['IBLOCK_TYPE'])) {
    $filter['TYPE'] = $arCurrentValues['IBLOCK_TYPE'];
}

$query = CIBlock::GetList(['SORT' => 'ASC'], $filter);
while ($row = $query->Fetch()) {
    $infoBlocks[$row['ID']] = '[' . $row['ID'] . '] ' . $row['NAME'];
}

/*
 * Настройки компонента
 */
$arComponentParameters = [
    'PARAMETERS' => [
        // Тип инфоблока
        'IBLOCK_TYPE' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('CHOOSE_TYPE_OF_INFO_BLOCK'),
            'TYPE' => 'LIST',
            'VALUES' => $infoBlocksTypes,
            'REFRESH' => 'Y',
        ],
        // Инфоблок
        'IBLOCK_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('CHOOSE_TYPE_OF_INFO_BLOCK'),
            'TYPE' => 'LIST',
            'VALUES' => $infoBlocks,
        ],

        'ELEMENT_COUNT' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('COUNT'),
            'TYPE' => 'STRING',
            'DEFAULT' => '3',
        ],

        // Ссылка на детальную страницу закладки
        'ELEMENT_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => Loc::getMessage('URL_DETAIL'),
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/detail/#ELEMENT_ID#/'
        ],

        // Ссылка на детальную страницу закладки
        'ADD_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => Loc::getMessage('URL_ADD'),
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/add/'
        ],

        // Кеширование
        'CACHE_TIME' => ['DEFAULT' => 3600],
        'CACHE_GROUPS' => [
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => Loc::getMessage('ACCESS_RIGHTS'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ]
    ],
];

// Настройка постраничной навигации
CIBlockParameters::AddPagerSettings(
    $arComponentParameters,
    Loc::getMessage('BOOKMARKS'),
    false,
    false
);
