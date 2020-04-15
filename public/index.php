<?php

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetPageProperty('title', 'Тестовое задание для разработчика 1С-Битрикс');
$APPLICATION->SetTitle('Тестовое задание для разработчика 1С-Битрикс');
?>


    <div class="lead mt-5">
        <p>Можно настроить sphinx на сервере и переключить затем в настройках модуля тип поиска, сейчас стоит
            bitrix.<br>Хорошая статья по теме:
            https://medium.com/@dermanov.mark/bitrix-and-sphinx-ccd806b68e9f</p>
        <a href="/bookmarks/" class="btn btn-primary btn-lg mt-5">Перейти в закладки</a>
    </div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
