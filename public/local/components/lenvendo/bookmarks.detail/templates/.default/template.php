<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
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

<article>
    <p>Url страницы: <a href="<?= $arResult['NAME']; ?>" target="_blank"><?= $arResult['NAME']; ?></a></p>
    <p>Дата добавления: <?= $arResult['DATE_CREATE']; ?></p>

    <?php if (!empty($arResult['DETAIL_PICTURE'])): ?>
        <p>
            Favicon: <img src="<?= $arResult['DETAIL_PICTURE']['SRC']; ?>"
                          alt="<?= $arResult['DETAIL_PICTURE']['ALT']; ?>"
                          title="<?= $arResult['DETAIL_PICTURE']['TITLE']; ?>" />
        </p>
    <?php endif ?>

    <p>Meta Title: <?= $arResult['PROPERTIES']['META_TITLE']['VALUE']; ?></p>
    <p>Meta Description: <?= $arResult['PROPERTIES']['META_DESCRIPTION']['VALUE']; ?></p>
    <p>Meta Keywords: <?= $arResult['PROPERTIES']['META_KEYWORDS']['VALUE']; ?></p>

    <p><a href="<?= $arResult['LIST_URL']; ?>">В список закладок</a></p>
</article>