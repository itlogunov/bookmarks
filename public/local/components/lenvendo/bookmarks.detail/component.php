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
use Bitrix\Iblock\Component\Tools;
use \Bitrix\Iblock\InheritedProperty\ElementValues;

if (!Loader::includeModule('iblock')) {
    ShowError('Модуль «Информационные блоки» не установлен');
    return;
}

if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 3600;
}

$arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
$arParams['IBLOCK_ID'] = (int)$arParams['IBLOCK_ID'];
$arParams['ELEMENT_ID'] = empty($arParams['ELEMENT_ID']) ? 0 : intval($arParams['ELEMENT_ID']);
if (empty($arParams['ELEMENT_ID'])) {
    $notFound = true;
}

if ($notFound) {
    Tools::process404(
        trim($arParams['MESSAGE_404']) ?: 'Закладка не найдена',
        true,
        $arParams['SET_STATUS_404'] === 'Y',
        $arParams['SHOW_404'] === 'Y',
        $arParams['FILE_404']
    );

    return;
}

$arParams['LIST_URL'] = trim($arParams['LIST_URL']);
$arParams['ELEMENT_URL'] = trim($arParams['ELEMENT_URL']);

$cacheDependence = ($arParams['CACHE_GROUPS'] === 'N' ? false : $USER->GetGroups());
if ($this->StartResultCache(false, $cacheDependence)) {

    $ELEMENT_ID = $arParams['ELEMENT_ID'];

    if ($ELEMENT_ID) {
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
            'ID' => $ELEMENT_ID,
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
            'CHECK_PERMISSIONS' => 'Y'
        ];

        $query = CIBlockElement::GetList(
            [],
            $filter,
            false,
            false,
            $select
        );

        // Устанавливаем шаблон пути для закладки
        $query->SetUrlTemplates($arParams['ELEMENT_URL']);

        if ($row = $query->GetNextElement()) {

            $arResult = $row->GetFields();

            // Свойства
            $arResult['PROPERTIES'] = $row->GetProperties();

            // Получаем значения свойств
            foreach ($arResult['PROPERTIES'] as $code => $data) {
                $arResult['DISPLAY_PROPERTIES'][$code] = CIBlockFormatProperties::GetDisplayValue($arResult, $data, '');
            }

            $arResult['LIST_URL'] = $arParams['LIST_URL'];

            /*
             * Добавляем в arResult доп. элементы
             */

            // SEO-свойства выбранной закладки
            $iPropValues = new ElementValues(
                $arResult['IBLOCK_ID'],
                $arResult['ID']
            );
            $arResult['IPROPERTY_VALUES'] = $iPropValues->getValues();

            if (isset($arResult['DETAIL_PICTURE'])) {
                $arResult['DETAIL_PICTURE'] =
                    (0 < $arResult['DETAIL_PICTURE'] ? CFile::GetFileArray($arResult['DETAIL_PICTURE']) : false);
                if ($arResult['DETAIL_PICTURE']) {
                    $arResult['DETAIL_PICTURE']['ALT'] =
                        $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'];
                    if ($arResult['DETAIL_PICTURE']['ALT'] == '') {
                        $arResult['DETAIL_PICTURE']['ALT'] = $arResult['NAME'];
                    }
                    $arResult['DETAIL_PICTURE']['TITLE'] =
                        $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'];
                    if ($arResult['DETAIL_PICTURE']['TITLE'] == '') {
                        $arResult['DETAIL_PICTURE']['TITLE'] = $arResult['NAME'];
                    }
                }
            }
        }
    }

    if (isset($arResult['ID'])) {
        $this->SetResultCacheKeys(
            [
                'ID',
                'NAME',
                'IPROPERTY_VALUES'
            ]
        );
        $this->IncludeComponentTemplate();
    } else {
        $this->AbortResultCache();
        Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Закладка не найдена',
            true,
            $arParams['SET_STATUS_404'] === 'Y',
            $arParams['SHOW_404'] === 'Y',
            $arParams['FILE_404']
        );
    }

}

// Работает с данными вне кеша
if (isset($arResult['ID'])) {

    // Увеличиваем SHOW_COUNTER элемента инфоблока
    CIBlockElement::CounterInc($arResult['ID']);

    // Установить заголовок страницы
    if ($arParams['SET_PAGE_TITLE'] == 'Y') {
        if ($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != '') {
            $APPLICATION->SetTitle($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']);
        } else {
            $APPLICATION->SetTitle($arResult['NAME']);
        }
    }

    // Установить заголовок окна браузера
    if ($arParams['SET_BROWSER_TITLE'] == 'Y') {
        if ($arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE'] != '') {
            $APPLICATION->SetPageProperty('title', $arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE']);
        } else {
            $APPLICATION->SetPageProperty('title', $arResult['NAME']);
        }
    }

    // Установить meta keywords
    if ($arParams['SET_META_KEYWORDS'] == 'Y' && $arResult['IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS'] != '') {
        $APPLICATION->SetPageProperty('keywords', $arResult['IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS']);
    }

    // Установить meta description
    if ($arParams['SET_META_DESCRIPTION'] == 'Y' && $arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'] != '') {
        $APPLICATION->SetPageProperty('description', $arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION']);
    }

    return $arResult['ID'];
}
