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

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(false);
$APPLICATION->SetPageProperty('title', Loc::getMessage('TITLE'));
$APPLICATION->SetTitle(Loc::getMessage('TITLE'));
$currentPage = $APPLICATION->GetCurPage();
?>

<?php if (isset($arResult['ERRORS']) && !empty($arResult['ERRORS'])) : ?>
    <div class="alert alert-danger mb-0 mt-4" role="alert">
        <?php foreach ($arResult['ERRORS'] as $error): ?>
            <?= $error; ?>
            <br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="<?= $currentPage; ?>" id="js-bookmark-add-form" class="justify-content-center mt-4">
    <div class="form-row">
        <div class="col">
            <input type="text" class="form-control" name="url" placeholder="<?= Loc::getMessage('PLACEHOLDER_URL'); ?>"
                   required>
        </div>
        <div class="col">
            <input type="text" class="form-control" name="password"
                   placeholder="<?= Loc::getMessage('PLACEHOLDER_PASSWORD'); ?>"
                   autocomplete="off">
        </div>
    </div>

    <div class="mt-4 mb-4" role="group" id="bookmark-buttons">
        <button type="submit" class="btn btn-primary"><?= Loc::getMessage('ADD'); ?></button>
        <br>
        <a href="<?= $arParams['LIST_URL']; ?>" class="btn btn-link"><?= Loc::getMessage('BACK_LINK'); ?></a>
    </div>

    <img src="<?= $templateFolder; ?>/preloader.gif" id="preloader" alt="загрузка">
</form>
