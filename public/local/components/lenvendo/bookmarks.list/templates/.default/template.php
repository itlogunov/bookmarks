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

<a href="/">Добавить закладку</a>
<br>
<br>

<div id="bookmarks__items">
    <section>
        <?php foreach ($arResult['ITEMS'] as $item): ?>
            <article>
                <a href="<?= $item['DETAIL_PAGE_URL']; ?>">
                    <img src="<?= $item['DETAIL_PICTURE']['SRC']; ?>"
                         alt="<?= $item['DETAIL_PICTURE']['ALT']; ?>"
                         title="<?= $item['DETAIL_PICTURE']['TITLE']; ?>"/>
                </a>
                <span><?= $item['DATE_CREATE']; ?></span>
                <span><?= $item['PROPERTIES']['URL']['VALUE']; ?></span>
                <a href="<?= $item['DETAIL_PAGE_URL']; ?>"><?= $item['NAME']; ?></a>
            </article>
        <?php endforeach; ?>
    </section>

    <div class="bookmarks__items–pagination">
        <?= $arResult['NAV_STRING']; ?>
    </div>
</div>
