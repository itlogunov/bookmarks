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
 * Параметры компонента
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
            'NAME' => Loc::getMessage('CHOOSE_INFO_BLOCK'),
            'TYPE' => 'LIST',
            'VALUES' => $infoBlocks,
        ],

        // Ссылка на список закладок
        'LIST_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => Loc::getMessage('LIST_URL'),
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/'
        ],

        // Шаблон ссылки на детальную страницу закладки
        'ELEMENT_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => Loc::getMessage('ELEMENT_URL'),
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/detail/#ELEMENT_ID#/'
        ],
    ]
];
