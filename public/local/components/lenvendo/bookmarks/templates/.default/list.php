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

// Сортировка
$sortingField = 'DATE_CREATE';
$sortingOrder = 'DESC';

if (isset($_GET['sort']) && htmlspecialchars($_GET['sort']) == 'url') {
    $sortingField = 'NAME';
} elseif (isset($_GET['sort']) && htmlspecialchars($_GET['sort']) == 'title') {
    $sortingField = 'PROPERTY_META_TITLE';
}

if (isset($_GET['order']) && htmlspecialchars($_GET['order']) == 'asc') {
    $sortingOrder = 'ASC';
}
?>

<?php if (isset($_GET['delete-success']) && !isset($_GET['PAGEN_1'])): ?>
    <div class="alert alert-success mb-0 mt-4" role="alert">
        Закладка была успешно удалена!
    </div>
<?php endif; ?>

<?php
$APPLICATION->IncludeComponent(
    'lenvendo:bookmarks.list',
    '.default',
    [
        'SORTING_FIELD' => $sortingField,
        'SORTING_ORDER' => $sortingOrder,
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
        'ELEMENT_COUNT' => $arParams['LIST_ELEMENT_COUNT'],
        'ELEMENT_URL' => $arResult['ELEMENT_URL'],
        'ADD_URL' => $arResult['ADD_URL'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
        'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
        'MESSAGE_404' => $arParams['MESSAGE_404'],
        'SET_STATUS_404' => $arParams['SET_STATUS_404'],
        'SHOW_404' => $arParams['SHOW_404'],
        'FILE_404' => $arParams['FILE_404'],
        'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
        'PAGER_TITLE' => $arParams['PAGER_TITLE'],
        'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
        'COMPONENT_TEMPLATE' => '.default'
    ],
    $component
);
