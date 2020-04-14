<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<?php
$APPLICATION->IncludeComponent(
    'lenvendo:bookmarks.detail',
    '.default',
    [
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
        'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
        'ELEMENT_URL' => $arResult['ELEMENT_URL'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'LIST_URL' => $arResult['FOLDER'],
        'SET_PAGE_TITLE' => $arParams['DETAIL_SET_PAGE_TITLE'],
        'SET_BROWSER_TITLE' => $arParams['DETAIL_SET_BROWSER_TITLE'],
        'SET_META_KEYWORDS' => $arParams['DETAIL_SET_META_KEYWORDS'],
        'SET_META_DESCRIPTION' => $arParams['DETAIL_SET_META_DESCRIPTION'],
        'MESSAGE_404' => $arParams['MESSAGE_404'],
        'SET_STATUS_404' => $arParams['SET_STATUS_404'],
        'SHOW_404' => $arParams['SHOW_404'],
        'FILE_404' => $arParams['FILE_404'],
        'COMPONENT_TEMPLATE' => '.default'
    ],
    $component
);
