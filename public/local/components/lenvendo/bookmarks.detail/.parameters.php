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
    'GROUPS' => [
        'SEO' => [
            'NAME' => Loc::getMessage('SEO_SETTINGS'),
            'SORT' => 1000
        ],
    ],
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

        // ID-закладки из $_REQUEST['ELEMENT_ID']
        'ELEMENT_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('ITEM'),
            'TYPE' => 'STRING',
            'DEFAULT' => '={$_REQUEST["ELEMENT_ID"]}',
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

        // SEO-параметры
        'SET_PAGE_TITLE' => [
            'PARENT' => 'SEO',
            'NAME' => Loc::getMessage('SET_PAGE_TITLE'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_BROWSER_TITLE' => [
            'PARENT' => 'SEO',
            'NAME' => Loc::getMessage('SET_BROWSER_TITLE'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_META_KEYWORDS' => [
            'PARENT' => 'SEO',
            'NAME' => Loc::getMessage('SET_META_KEYWORDS'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_META_DESCRIPTION' => [
            'PARENT' => 'SEO',
            'NAME' => Loc::getMessage('SET_META_DESCRIPTION'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],

        // Кеширование
        'CACHE_TIME' => ['DEFAULT' => 3600],
        'CACHE_GROUPS' => [
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => Loc::getMessage('ACCESS_RIGHTS'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ]
    ]
];

// В случае, если закладка не будет найдена, добавим дополнительную настройку
CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
