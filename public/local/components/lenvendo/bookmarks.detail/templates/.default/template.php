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

$this->setFrameMode(false);
?>

<div class="alert alert-danger mb-2 mt-4 hidden" role="alert" id="errors"></div>

<div class="card" id="bookmark" data-url="<?= $arResult['DETAIL_URL']; ?>">
    <?php if (!empty($arResult['DETAIL_PICTURE'])): ?>
        <img class="card-img-top-favicon" src="<?= $arResult['DETAIL_PICTURE']['SRC']; ?>"
             alt="<?= $arResult['DETAIL_PICTURE']['ALT']; ?>"
             title="<?= $arResult['DETAIL_PICTURE']['TITLE']; ?>"/>
    <?php endif; ?>
    <div class="card-body text-left">
        <h5 class="card-title mb-4">Заголовок: <?= $arResult['PROPERTIES']['META_TITLE']['VALUE']; ?></h5>
        <h5 class="card-subtitle mb-3 text-muted">Дата добавления: <?= $arResult['DATE_CREATE']; ?></h5>
        <?php if ($arResult['PROPERTIES']['META_DESCRIPTION']['VALUE']): ?>
            <p class="card-text">Description: <?= $arResult['PROPERTIES']['META_DESCRIPTION']['VALUE']; ?></p>
        <?php endif; ?>
        <?php if ($arResult['PROPERTIES']['META_KEYWORDS']['VALUE']): ?>
            <p class="card-text">Keywords: <?= $arResult['PROPERTIES']['META_KEYWORDS']['VALUE']; ?></p>
        <?php endif; ?>

        <div class="text-right">
            <a href="<?= $arResult['NAME']; ?>" class="btn btn-link" target="_blank">Перейти на страницу</a>
            <button class="btn btn-link" onclick="deleteBookmark();">Удалить закладку</button>
        </div>
    </div>
</div>

<div class="text-left mt-5">
    <a href="<?= $arResult['LIST_URL']; ?>" class="btn btn-link">Вернуться в список закладок</a>
</div>