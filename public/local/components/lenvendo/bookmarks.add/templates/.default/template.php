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
$APPLICATION->SetPageProperty('title', 'Добавление закладки');
$APPLICATION->SetTitle('Добавление закладки');
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

<form action="<?= $currentPage; ?>" class="justify-content-center mt-4">
    <div class="form-group">
        <input type="text" class="form-control" name="url" placeholder="Вставьте URL">
    </div>
    <button type="submit" class="btn btn-link">Добавить</button>
</form>