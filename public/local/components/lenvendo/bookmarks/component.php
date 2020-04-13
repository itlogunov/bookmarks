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

// Если включен режим ЧПУ
if ($arParams['SEF_MODE'] == 'Y') {

    $arVariables = [];

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
        Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Закладка не найдена',
            true,
            $arParams['SET_STATUS_404'] === 'Y',
            $arParams['SHOW_404'] === 'Y',
            $arParams['FILE_404']
        );

        return;
    }

    $notFound = false;

    // Некорректный идентификатор закладки
    if ($componentPage == 'detail') {
        if (!(isset($arVariables['ELEMENT_ID']) && ctype_digit($arVariables['ELEMENT_ID']))) {
            $notFound = true;
        }
    }

    // Показываем страницу 404 Not Found
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

} else {

    // Если не включен ЧПУ
    $arVariables = [];

    CComponentEngine::InitComponentVariables(
        false,
        null,
        $arParams['VARIABLE_ALIASES'],
        $arVariables
    );

    $componentPage = '';
    if (isset($arVariables['ELEMENT_ID']) && intval($arVariables['ELEMENT_ID']) > 0) {
        $componentPage = 'detail';
    } else {
        $componentPage = 'list';
    }

    /*
     * Обрабытываем ситуацию, когда переданы некорректные параметры и показываем 404 Not Found
     */
    $notFound = false;

    // недопустимое значение идентификатора элемента
    if ($componentPage == 'detail') {
        if (!(isset($arVariables['ELEMENT_ID']) && ctype_digit($arVariables['ELEMENT_ID']))) {
            $notFound = true;
        }
    }

    // Показываем страницу 404 Not Found
    if ($notFound) {
        Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Элемент или раздел инфоблока не найден',
            true,
            $arParams['SET_STATUS_404'] === 'Y',
            $arParams['SHOW_404'] === 'Y',
            $arParams['FILE_404']
        );

        return;
    }

    $arResult['VARIABLES'] = $arVariables;
    $arResult['FOLDER'] = '';
    $arResult['ELEMENT_URL'] = $APPLICATION->GetCurPage() . '?' . $arParams['VARIABLE_ALIASES']['ELEMENT_ID'] . '=#ELEMENT_ID#';
}

$this->IncludeComponentTemplate($componentPage);
