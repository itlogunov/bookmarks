<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Bitrix\Iblock\InheritedProperty\ElementValues;

if (!Loader::includeModule('iblock')) {
    ShowError(Loc::getMessage('ERROR_MODULE_IBLOCK'));
    return;
}

// Запрет на сохранение в сессию номера последней страницы при постраничной навигации
CPageOption::SetOptionString('main', 'nav_page_in_session', 'N');

if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 3600;
}

$arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
$arParams['IBLOCK_ID'] = (int)$arParams['IBLOCK_ID'];

$arParams['ELEMENT_URL'] = trim($arParams['ELEMENT_URL']);

$arParams['ELEMENT_COUNT'] = (int)$arParams['ELEMENT_COUNT'];
if ($arParams['ELEMENT_COUNT'] <= 0) {
    $arParams['ELEMENT_COUNT'] = 3;
}

$arParams['CACHE_GROUPS'] = $arParams['CACHE_GROUPS'] == 'Y';

// Текст постраничной навигации
$arParams['PAGER_TITLE'] = trim($arParams['PAGER_TITLE']);

// Шаблон постраничной навигации
$arParams['PAGER_TEMPLATE'] = trim($arParams['PAGER_TEMPLATE']);

// Параметры постраничной навигации
$navParams = [
    'nPageSize' => $arParams['ELEMENT_COUNT'],
    'bShowAll' => false
];
$navigation = CDBResult::GetNavParams($navParams);

$arParams['SORTING_FIELD'] = is_null($arParams['SORTING_FIELD']) ? 'DATE_CREATE' : $arParams['SORTING_FIELD'];
$arParams['SORTING_ORDER'] = is_null($arParams['SORTING_ORDER']) ? 'DESC' : $arParams['SORTING_ORDER'];

$cacheDependence = [$arParams['CACHE_GROUPS'] ? $USER->GetGroups() : false, $navigation];
if ($this->StartResultCache(false, $cacheDependence)) {

    $sorting = [$arParams['SORTING_FIELD'] => $arParams['SORTING_ORDER']];
    $select = [
        'ID',
        'IBLOCK_ID',
        'NAME',
        'DATE_CREATE',
        'DETAIL_PICTURE',
        'DETAIL_PAGE_URL',
        'PROPERTY_*',
    ];
    $filter = [
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'IBLOCK_ACTIVE' => 'Y',
        'ACTIVE' => 'Y',
        'ACTIVE_DATE' => 'Y',
        'CHECK_PERMISSIONS' => 'Y'
    ];

    // Если передан дополнительный параметры для фильтрации, добавим в фильтр
    if (count($arParams['FILTER'])) {
        $filter = array_merge($filter, $arParams['FILTER']);
    }

    $query = CIBlockElement::GetList(
        $sorting,
        $filter,
        false,
        $navParams,
        $select
    );

    // Устанавливаем шаблон пути для закладки
    $query->SetUrlTemplates($arParams['ELEMENT_URL']);

    $arResult['ITEMS'] = [];
    while ($row = $query->GetNextElement()) {

        $item = $row->GetFields();
        $item['PROPERTIES'] = $row->GetProperties();

        // SEO-свойства закладки
        $iPropValues = new ElementValues(
            $item['IBLOCK_ID'],
            $item['ID']
        );
        $item['IPROPERTY_VALUES'] = $iPropValues->getValues();

        if (isset($item['DETAIL_PICTURE'])) {
            $item['DETAIL_PICTURE'] =
                (0 < $item['DETAIL_PICTURE'] ? CFile::GetFileArray($item['DETAIL_PICTURE']) : false);
            if ($item['DETAIL_PICTURE']) {
                $item['DETAIL_PICTURE']['ALT'] =
                    $item['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'];
                if ($item['DETAIL_PICTURE']['ALT'] == '') {
                    $item['DETAIL_PICTURE']['ALT'] = $item['NAME'];
                }
                $item['DETAIL_PICTURE']['TITLE'] =
                    $item['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'];
                if ($item['DETAIL_PICTURE']['TITLE'] == '') {
                    $item['DETAIL_PICTURE']['TITLE'] = $item['NAME'];
                }
            }
        }

        $arResult['ITEMS'][] = $item;
    }

    // Постраничная навигация
    $arResult['NAV_STRING'] = $query->GetPageNavString(
        $arParams['PAGER_TITLE'],
        $arParams['PAGER_TEMPLATE'],
        ($arParams['PAGER_SHOW_ALWAYS'] == 'N') ? false : $arParams['PAGER_SHOW_ALWAYS'],
        $this
    );

    $this->SetResultCacheKeys(
        [
            'ID',
            'NAME',
            'IPROPERTY_VALUES'
        ]
    );
    $this->IncludeComponentTemplate();
}
