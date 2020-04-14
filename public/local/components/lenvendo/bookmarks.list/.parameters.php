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
 * Настройки компонента
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

        'ELEMENT_COUNT' => [
            'PARENT' => 'BASE',
            'NAME' => 'Количество закладок на странице',
            'TYPE' => 'STRING',
            'DEFAULT' => '3',
        ],

        // Ссылка на детальную страницу закладки
        'ELEMENT_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL на детальную страницу закладки',
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/detail/#ELEMENT_ID#/'
        ],

        // Ссылка на детальную страницу закладки
        'ADD_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL добавления новой закладки',
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/add/'
        ],

        // Кеширование
        'CACHE_TIME' => ['DEFAULT' => 3600],
        'CACHE_GROUPS' => [
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => 'Учитывать права доступа',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ]
    ],
];

// Настройка постраничной навигации
CIBlockParameters::AddPagerSettings(
    $arComponentParameters,
    'Закладки',
    false,
    false
);
