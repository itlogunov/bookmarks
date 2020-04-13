<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;

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
            'NAME' => 'Настройки SEO',
            'SORT' => 1000
        ],
    ],
    'PARAMETERS' => [
        // Тип инфоблока
        'IBLOCK_TYPE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Выберите тип инфоблока',
            'TYPE' => 'LIST',
            'VALUES' => $infoBlocksTypes,
            'REFRESH' => 'Y',
        ],
        // Инфоблок
        'IBLOCK_ID' => [
            'PARENT' => 'BASE',
            'NAME' => 'Выберите инфоблок',
            'TYPE' => 'LIST',
            'VALUES' => $infoBlocks,
        ],

        // ID-закладки из $_REQUEST['ELEMENT_ID']
        'ELEMENT_ID' => [
            'PARENT' => 'BASE',
            'NAME' => 'Идентификатор элемента',
            'TYPE' => 'STRING',
            'DEFAULT' => '={$_REQUEST["ELEMENT_ID"]}',
        ],

        // Ссылка на список закладок
        'LIST_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL, ведущий на список закладок',
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/'
        ],

        // Шаблон ссылки на детальную страницу закладки
        'ELEMENT_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL, ведущий на страницу с содержимым закладки',
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/detail/#ELEMENT_ID#/'
        ],

        // SEO-параметры
        'SET_PAGE_TITLE' => [
            'PARENT' => 'SEO',
            'NAME' => 'Устанавливать заголовок страницы',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_BROWSER_TITLE' => [
            'PARENT' => 'SEO',
            'NAME' => 'Устанавливать заголовок окна браузера',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_META_KEYWORDS' => [
            'PARENT' => 'SEO',
            'NAME' => 'Устанавливать meta keywords',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_META_DESCRIPTION' => [
            'PARENT' => 'SEO',
            'NAME' => 'Устанавливать meta description',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],

        // Кеширование
        'CACHE_TIME' => ['DEFAULT' => 3600],
        'CACHE_GROUPS' => [
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => 'Учитывать права доступа',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ]
    ]
];

// Если закладка не найдена, добавим дополнительную настройку
CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
