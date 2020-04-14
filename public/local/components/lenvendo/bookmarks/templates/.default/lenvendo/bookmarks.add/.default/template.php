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
$APPLICATION->SetTitle('Добавление закладки');
$currentPage = $APPLICATION->GetCurPage();
?>

<?php if (isset($arResult['ERRORS']) && !empty($arResult['ERRORS'])) : ?>
    <?php foreach ($arResult['ERRORS'] as $error): ?>
        <?= $error; ?>
        <br>
    <?php endforeach; ?>
    <br>
<?php endif; ?>

<form action="<?= $currentPage; ?>">
    <input type="text" name="url" placeholder="Введите url" size="80" required>
    <button>Добавить</button>
</form>
