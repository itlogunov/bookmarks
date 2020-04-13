<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetTitle("Закладки");
?><?$APPLICATION->IncludeComponent(
	"lenvendo:bookmarks",
	"",
	Array(
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
		"LIST_ELEMENT_COUNT" => "3",
		"LIST_URL" => "/bookmarks/",
		"MESSAGE_404" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "modern",
		"PAGER_TITLE" => "Закладки",
		"SEF_FOLDER" => "/bookmarks/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("detail"=>"detail/#ELEMENT_ID#/"),
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y"
	)
);?>