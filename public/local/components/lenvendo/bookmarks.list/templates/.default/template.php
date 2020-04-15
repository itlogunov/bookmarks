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
$currentPage = $APPLICATION->GetCurPage();
?>

<?php if (isset($arResult['ITEMS']) && count($arResult['ITEMS']) > 0): ?>

    <div class="btn-group mt-4 mb-4" role="group">
        <a href="<?= $arParams['ADD_URL']; ?>" class="btn btn-primary"><?= Loc::getMessage('ADD_BOOKMARK'); ?></a>
        <a href="<?= $currentPage . 'export.php?list=' . $arParams['IBLOCK_ID']; ?>"
           class="btn btn-link"><?= Loc::getMessage('EXPORT_TO_EXCEL'); ?></a>
    </div>

    <?php if ($arParams['DISPLAY_TOP_PAGER'] == 'Y'): ?>
        <?= $arResult['NAV_STRING']; ?>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">
                <?php if (!isset($_GET['sort']) || htmlspecialchars($_GET['sort']) == 'date'): ?>
                    <?php if (!isset($_GET['order']) || htmlspecialchars($_GET['order']) == 'desc'): ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=date&order=asc', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('DATE'); ?> ↓
                        </a>
                    <?php elseif (isset($_GET['order']) && htmlspecialchars($_GET['order']) == 'asc'): ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('DATE'); ?> ↑
                        </a>
                    <?php else: ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=date&order=asc', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('DATE'); ?> ↓
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= $APPLICATION->GetCurPageParam('', ['sort', 'order']); ?>">
                        <?= Loc::getMessage('DATE'); ?>
                    </a>
                <?php endif; ?>
            </th>
            <th scope="col">Favicon</th>
            <th scope="col">
                <?php if (isset($_GET['sort']) && htmlspecialchars($_GET['sort']) == 'url'): ?>
                    <?php if (!isset($_GET['order']) || htmlspecialchars($_GET['order']) == 'desc'): ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=url&order=asc', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('URL'); ?> ↓
                        </a>
                    <?php elseif (isset($_GET['order']) && htmlspecialchars($_GET['order']) == 'asc'): ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=url&order=desc', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('URL'); ?> ↑
                        </a>
                    <?php else: ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=url&order=asc', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('URL'); ?> ↓
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= $APPLICATION->GetCurPageParam('sort=url&order=asc', ['sort', 'order']); ?>">
                        <?= Loc::getMessage('URL'); ?>
                    </a>
                <?php endif; ?>
            </th>
            <th scope="col">
                <?php if (isset($_GET['sort']) && htmlspecialchars($_GET['sort']) == 'title'): ?>
                    <?php if (!isset($_GET['order']) || htmlspecialchars($_GET['order']) == 'desc'): ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=title&order=asc', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('TITLE'); ?> ↓
                        </a>
                    <?php elseif (isset($_GET['order']) && htmlspecialchars($_GET['order']) == 'asc'): ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=title&order=desc', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('TITLE'); ?> ↑
                        </a>
                    <?php else: ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=title&order=asc', ['sort', 'order']); ?>">
                            <?= Loc::getMessage('TITLE'); ?> ↓
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= $APPLICATION->GetCurPageParam('sort=title&order=asc', ['sort', 'order']); ?>">
                        <?= Loc::getMessage('TITLE'); ?>
                    </a>
                <?php endif; ?>
            </th>
            <th scope="col"><?= Loc::getMessage('ACTIONS'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($arResult['ITEMS'] as $item): ?>
            <tr>
                <td><?= $item['DATE_CREATE']; ?></td>
                <td>
                    <?php if (!empty($item['DETAIL_PICTURE'])): ?>
                        <img src="<?= $item['DETAIL_PICTURE']['SRC']; ?>"
                             alt="<?= $item['DETAIL_PICTURE']['ALT']; ?>"
                             title="<?= $item['DETAIL_PICTURE']['TITLE']; ?>"/>
                    <?php endif; ?>
                </td>
                <td><a href="<?= $item['NAME']; ?>" target="_blank"><?= $item['NAME']; ?></a></td>
                <td><?= $item['PROPERTIES']['META_TITLE']['VALUE']; ?></td>
                <td>
                    <a href="<?= $item['DETAIL_PAGE_URL']; ?>"><?= Loc::getMessage('DETAILS'); ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($arParams['DISPLAY_BOTTOM_PAGER'] == 'Y'): ?>
        <?= $arResult['NAV_STRING']; ?>
    <?php endif; ?>

<?php else: ?>

    <p class="mt-5"><?= Loc::getMessage('ADD_BOOKMARK_FIRST'); ?>
        <a href="<?= $arParams['ADD_URL']; ?>" class="btn btn-primary ml-2"><?= Loc::getMessage('ADD'); ?></a>
    </p>

<?php endif; ?>
