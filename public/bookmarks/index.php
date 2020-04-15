<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetPageProperty('title', 'Закладки');
$APPLICATION->SetTitle('Закладки');
?><?$APPLICATION->IncludeComponent(
	"lenvendo:bookmarks", 
	".default", 
	array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DETAIL_SET_BROWSER_TITLE" => "Y",
		"DETAIL_SET_META_DESCRIPTION" => "Y",
		"DETAIL_SET_META_KEYWORDS" => "Y",
		"DETAIL_SET_PAGE_TITLE" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILE_404" => "",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "services",
		"LIST_ELEMENT_COUNT" => "4",
		"MESSAGE_404" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "bootstrap_v4",
		"PAGER_TITLE" => "Страницы",
		"SEF_FOLDER" => "/bookmarks/",
		"SEF_MODE" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"SEF_URL_TEMPLATES" => array(
			"detail" => "detail/#ELEMENT_ID#/",
			"add" => "add/",
		)
	),
	false
);?>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
