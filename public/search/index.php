<?php

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$title = 'Поиск по закладкам';

use App\Services\SearchInfoBlock;

$query = null;
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $query = trim(htmlspecialchars($_GET['q']));

    $ids = [];
    $filter = [];
    if ($query != null) {
        $title .= '«' . $query . '»';
        $ids = (new SearchInfoBlock(SITE_ID, IBLOCK['BOOKMARKS'], $query))->fullText();
    }

    if (count($ids) > 0) {
        $filter = ['ID' => $ids];
    }
}

$APPLICATION->SetPageProperty('title', $title);
$APPLICATION->SetTitle($title);

if (!is_null($query) && count($ids) > 0): ?>
    <?php

    /*
     * Сортировка для компонента списка
     */
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

    <?php $APPLICATION->IncludeComponent(
        "lenvendo:bookmarks.list",
        "search_page", Array(
        "SORTING_FIELD" => $sortingField,
        "SORTING_ORDER" => $sortingOrder,
        "ADD_URL" => "/bookmarks/add/",    // URL добавления новой закладки
        "CACHE_GROUPS" => "Y",    // Учитывать права доступа
        "CACHE_TIME" => "3600",    // Время кеширования (сек.)
        "CACHE_TYPE" => "A",    // Тип кеширования
        "DISPLAY_BOTTOM_PAGER" => "Y",    // Выводить под списком
        "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
        "ELEMENT_COUNT" => "3",    // Количество закладок на странице
        "ELEMENT_URL" => "/bookmarks/detail/#ELEMENT_ID#/",    // URL на детальную страницу закладки
        "IBLOCK_ID" => "3",    // Выберите инфоблок
        "IBLOCK_TYPE" => "services",    // Выберите тип инфоблока
        "PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
        "PAGER_TEMPLATE" => "bootstrap_v4",    // Шаблон постраничной навигации
        "PAGER_TITLE" => "Закладки",    // Название категорий
        "FILTER" => $filter
    ),
        false
    ); ?>

<?php elseif (!is_null($query) && count($ids) == 0): ?>
    <p class="mt-5">Ничего не найдено</p>
<?php else: ?>
    <p class="mt-5">Вы не ввели запрос</p>
<?php endif; ?>
