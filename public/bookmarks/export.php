<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!isset($_GET['list']) || (int)$_GET['list'] == 0) {
    header('Location: /');
    die();
}

use Bitrix\Main\Loader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

Loader::includeModule('iblock');

$iblockId = (int)$_GET['list'];
$sorting = ['DATE_CREATE' => 'DESC'];
$select = [
    'NAME',
    'DATE_CREATE',
    'PROPERTY_META_TITLE',
    'PROPERTY_META_DESCRIPTION',
    'PROPERTY_META_KEYWORDS',
];
$filter = [
    'IBLOCK_ID' => $iblockId,
    'IBLOCK_ACTIVE' => 'Y',
    'ACTIVE' => 'Y',
    'ACTIVE_DATE' => 'Y',
    'CHECK_PERMISSIONS' => 'Y'
];

$query = CIBlockElement::GetList(
    $sorting,
    $filter,
    false,
    false,
    $select
);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$titles = ['Дата', 'URL', 'Заголовок', 'Description', 'Keywords'];
$sheet->fromArray($titles, null, 'A1');

$i = 2;
while ($row = $query->Fetch()) {
    $sheet->fromArray([$row['DATE_CREATE']], null, 'A' . $i);
    $sheet->fromArray([$row['NAME']], null, 'B' . $i);

    if ($row['PROPERTY_META_TITLE_VALUE']) {
        $sheet->fromArray([$row['PROPERTY_META_TITLE_VALUE']], null, 'C' . $i);
    }

    if ($row['PROPERTY_META_DESCRIPTION_VALUE']) {
        $sheet->fromArray([$row['PROPERTY_META_DESCRIPTION_VALUE']], null, 'D' . $i);
    }

    if ($row['PROPERTY_META_KEYWORDS_VALUE']) {
        $sheet->fromArray([$row['PROPERTY_META_KEYWORDS_VALUE']], null, 'E' . $i);
    }

    $i++;
}

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setWidth(80);
$sheet->getColumnDimension('D')->setWidth(80);
$sheet->getColumnDimension('E')->setWidth(80);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="bookmarks.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
