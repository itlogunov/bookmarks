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
    ]
];
