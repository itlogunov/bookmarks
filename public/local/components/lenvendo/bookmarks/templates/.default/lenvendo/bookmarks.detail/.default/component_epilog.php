<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Iblock\ElementTable;

// Если запросили удаление
if (isset($_GET['delete'])) {
    if (isset($_GET['password'])) {
        $password = trim(htmlspecialchars($_GET['password']));
        $password = (strlen($password)) ? sha1($password) : '';
        $query = ElementTable::getList([
            'order' => [],
            'select' => ['ID'],
            'filter' => [
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'ACTIVE' => 'Y',
                'CODE' => $password,
                'ID' => $arParams['ELEMENT_ID']
            ],
            'limit' => 1,
            'offset' => 0
        ]);
        if ($row = $query->fetch()) {
            CIBlockElement::Delete($row['ID']);
            header('Location: ' . $arParams['LIST_URL'] . '?delete-success');
            die();
        }

        $arResult['ERRORS'][] = 'Закладка не была удалена';
    }
}

if (isset($arResult['ERRORS']) && !empty($arResult['ERRORS'])) {
    $errors = implode(', ', $arResult['ERRORS']);
    ?>
    <script type="text/javascript">
        let errors = document.getElementById('errors');
        errors.innerText = '<?= $errors; ?>';
        errors.classList.remove('hidden');
    </script>
    <?php
}
