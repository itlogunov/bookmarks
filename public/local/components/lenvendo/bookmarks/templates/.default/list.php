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
    "lenvendo:bookmarks.list",
    ".default",
    array(
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
        "ELEMENT_COUNT" => $arParams['LIST_ELEMENT_COUNT'],
        "ELEMENT_URL" => $arResult['ELEMENT_URL'],
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
        'MESSAGE_404' => $arParams['MESSAGE_404'],
        'SET_STATUS_404' => $arParams['SET_STATUS_404'],
        'SHOW_404' => $arParams['SHOW_404'],
        'FILE_404' => $arParams['FILE_404'],
        'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
        'PAGER_TITLE' => $arParams['PAGER_TITLE'],
    )
);
