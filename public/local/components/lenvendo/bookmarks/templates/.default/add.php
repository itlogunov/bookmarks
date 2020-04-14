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
    'lenvendo:bookmarks.add',
    '.default',
    [
        'ELEMENT_URL' => $arResult['ELEMENT_URL'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'LIST_URL' => $arResult['FOLDER'],
        'COMPONENT_TEMPLATE' => '.default'
    ],
    $component
);
