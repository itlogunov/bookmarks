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

use Bitrix\Iblock\Component\Tools;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

// Если включен режим ЧПУ
if ($arParams['SEF_MODE'] == 'Y') {

    $arVariables = [];
    $notFound = false;

    // Определим файл (add, list, detail), которому соответствует текущая запрошенная страница
    $componentPage = CComponentEngine::ParseComponentPath(
        $arParams['SEF_FOLDER'],
        $arParams['SEF_URL_TEMPLATES'],
        $arVariables
    );

    if ($componentPage === false && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $arParams['SEF_FOLDER']) {
        $componentPage = 'list';
    }

    // Если определить файл не удалось, показываем  страницу 404 Not Found
    if (empty($componentPage)) {
        $notFound = true;
    }

    // Некорректный идентификатор закладки
    if ($componentPage == 'detail') {
        if (!(isset($arVariables['ELEMENT_ID']) && ctype_digit($arVariables['ELEMENT_ID']))) {
            $notFound = true;
        } else {
            $count = ElementTable::getById((int)$arVariables['ELEMENT_ID'])->getSelectedRowsCount();
            if ($count == 0) {
                $notFound = true;
            }
        }
    }

    // Показываем страницу 404 Not Found
    if ($notFound) {
        Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Страница не найдена',
            true,
            $arParams['SET_STATUS_404'] === 'Y',
            $arParams['SHOW_404'] === 'Y',
            $arParams['FILE_404']
        );

        return;
    }

    /*
     * Метод служит для поддержки псевдонимов переменных в комплексных компонентах.
     * Метод восстанавливает истинные переменные из $_REQUEST на основании их псевдонимов из $arParams['VARIABLE_ALIASES']
     */
    CComponentEngine::InitComponentVariables(
        $componentPage,
        null,
        [],
        $arVariables
    );

    $arResult['VARIABLES'] = $arVariables;
    $arResult['FOLDER'] = $arParams['SEF_FOLDER'];
    $arResult['ELEMENT_URL'] = $arParams['SEF_FOLDER'] . $arParams['SEF_URL_TEMPLATES']['detail'];
    $arResult['ADD_URL'] = $arParams['SEF_FOLDER'] . $arParams['SEF_URL_TEMPLATES']['add'];

} else {

    // Если не включен ЧПУ
    $arVariables = [];
    $notFound = false;
    $currentPage = $APPLICATION->GetCurPage();

    CComponentEngine::InitComponentVariables(
        false,
        null,
        $arParams['VARIABLE_ALIASES'],
        $arVariables
    );

    $componentPage = '';
    if (isset($arVariables['ELEMENT_ID']) && (int)$arVariables['ELEMENT_ID'] > 0) {
        $componentPage = 'detail';
    } else {
        $componentPage = 'list';
    }

    // недопустимое значение идентификатора элемента
    if ($componentPage == 'detail') {
        if (!(isset($arVariables['ELEMENT_ID']) && ctype_digit($arVariables['ELEMENT_ID']))) {
            $notFound = true;
        } else {
            $count = ElementTable::getById((int)$arVariables['ELEMENT_ID'])->getSelectedRowsCount();
            if ($count == 0) {
                $notFound = true;
            }
        }
    }

    // Показываем страницу 404 Not Found
    if ($notFound) {
        Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Страница не найдена',
            true,
            $arParams['SET_STATUS_404'] === 'Y',
            $arParams['SHOW_404'] === 'Y',
            $arParams['FILE_404']
        );

        return;
    }

    $arResult['VARIABLES'] = $arVariables;
    $arResult['FOLDER'] = $currentPage;
    $arResult['ELEMENT_URL'] = $currentPage . '?' . $arParams['VARIABLE_ALIASES']['ELEMENT_ID'] . '=#ELEMENT_ID#';
    $arResult['ADD_URL'] = $currentPage . 'add/';

}

$this->IncludeComponentTemplate($componentPage);
