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
 * Настройки комлексного компонента
 */
$arComponentParameters = [
    'GROUPS' => [
        'SEO' => [
            'NAME' => 'Настройки SEO',
            'SORT' => 1000
        ],
        'LIST_SETTINGS' => [
            'NAME' => 'Настройки страницы списка закладок',
            'SORT' => 1100
        ],
        'DETAIL_SETTINGS' => [
            'NAME' => 'Настройки страницы карточки закладки',
            'SORT' => 1200
        ]
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

        // Параметры страницы списка закладок
        'LIST_ELEMENT_COUNT' => array(
            'PARENT' => 'LIST_SETTINGS',
            'NAME' => 'Количество элементов на странице',
            'TYPE' => 'STRING',
            'DEFAULT' => '3',
        ),

        // Ссылка на список закладок
        'LIST_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL, ведущий на список закладок',
            'TYPE' => 'STRING',
            'DEFAULT' => '/bookmarks/'
        ],

        // SEO-параметры
        'DETAIL_SET_PAGE_TITLE' => [
            'PARENT' => 'SEO',
            'NAME' => 'Устанавливать заголовок страницы',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'DETAIL_SET_BROWSER_TITLE' => [
            'PARENT' => 'SEO',
            'NAME' => 'Устанавливать заголовок окна браузера',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'DETAIL_SET_META_KEYWORDS' => [
            'PARENT' => 'SEO',
            'NAME' => 'Устанавливать meta keywords',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'DETAIL_SET_META_DESCRIPTION' => [
            'PARENT' => 'SEO',
            'NAME' => 'Устанавливать meta description',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],

        // Без ЧПУ
        'VARIABLE_ALIASES' => [
            'ELEMENT_ID' => ['NAME' => 'Идентификатор закладки']
        ],

        // ЧПУ
        'SEF_MODE' => [
            'detail' => [
                'NAME' => 'Страница закладки',
                'DEFAULT' => 'detail/#ELEMENT_ID#/',
            ],
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

// Настройка постраничной навигации
CIBlockParameters::AddPagerSettings(
    $arComponentParameters,
    'Закладки',
    false,
    false
);

// Если закладка не найдена, добавим дополнительную настройку
CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
