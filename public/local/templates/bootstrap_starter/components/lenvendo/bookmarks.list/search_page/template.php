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
$currentPage = $APPLICATION->GetCurPage();
?>

<?php if (isset($arResult['ITEMS']) && count($arResult['ITEMS']) > 0): ?>
    <div class="mt-4">
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
                                Дата ↓
                            </a>
                        <?php elseif (isset($_GET['order']) && htmlspecialchars($_GET['order']) == 'asc'): ?>
                            <a href="<?= $APPLICATION->GetCurPageParam('', ['sort', 'order']); ?>">
                                Дата ↑
                            </a>
                        <?php else: ?>
                            <a href="<?= $APPLICATION->GetCurPageParam('sort=date&order=asc', ['sort', 'order']); ?>">
                                Дата ↓
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('', ['sort', 'order']); ?>">
                            Дата
                        </a>
                    <?php endif; ?>
                </th>
                <th scope="col">Favicon</th>
                <th scope="col">
                    <?php if (isset($_GET['sort']) && htmlspecialchars($_GET['sort']) == 'url'): ?>
                        <?php if (!isset($_GET['order']) || htmlspecialchars($_GET['order']) == 'desc'): ?>
                            <a href="<?= $APPLICATION->GetCurPageParam('sort=url&order=asc', ['sort', 'order']); ?>">
                                URL ↓
                            </a>
                        <?php elseif (isset($_GET['order']) && htmlspecialchars($_GET['order']) == 'asc'): ?>
                            <a href="<?= $APPLICATION->GetCurPageParam('sort=url&order=desc', ['sort', 'order']); ?>">
                                URL ↑
                            </a>
                        <?php else: ?>
                            <a href="<?= $APPLICATION->GetCurPageParam('sort=url&order=asc', ['sort', 'order']); ?>">
                                URL ↓
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=url&order=asc', ['sort', 'order']); ?>">
                            URL
                        </a>
                    <?php endif; ?>
                </th>
                <th scope="col">
                    <?php if (isset($_GET['sort']) && htmlspecialchars($_GET['sort']) == 'title'): ?>
                        <?php if (!isset($_GET['order']) || htmlspecialchars($_GET['order']) == 'desc'): ?>
                            <a href="<?= $APPLICATION->GetCurPageParam('sort=title&order=asc', ['sort', 'order']); ?>">
                                Заголовок ↓
                            </a>
                        <?php elseif (isset($_GET['order']) && htmlspecialchars($_GET['order']) == 'asc'): ?>
                            <a href="<?= $APPLICATION->GetCurPageParam('sort=title&order=desc', ['sort', 'order']); ?>">
                                Заголовок ↑
                            </a>
                        <?php else: ?>
                            <a href="<?= $APPLICATION->GetCurPageParam('sort=title&order=asc', ['sort', 'order']); ?>">
                                Заголовок ↓
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?= $APPLICATION->GetCurPageParam('sort=title&order=asc', ['sort', 'order']); ?>">
                            Заголовок
                        </a>
                    <?php endif; ?>
                </th>
                <th scope="col">Действия</th>
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
                        <a href="<?= $item['DETAIL_PAGE_URL']; ?>">Подробно</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($arParams['DISPLAY_BOTTOM_PAGER'] == 'Y'): ?>
            <?= $arResult['NAV_STRING']; ?>
        <?php endif; ?>
    </div>
<?php else: ?>

    <p class="mt-5">Добавьте свою первую закладку <a href="<?= $arParams['ADD_URL']; ?>" class="btn btn-primary ml-2">Добавить
            закладку</a></p>

<?php endif; ?>
