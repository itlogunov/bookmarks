<?php

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetPageProperty('title', 'Тестовое задание для разработчика 1С-Битрикс');
$APPLICATION->SetTitle('Тестовое задание для разработчика 1С-Битрикс');
?>


    <div class="lead mt-5 text-left">
        <p>Доступ в административную часть:
        <ul>
            <li>login: levendo</li>
            <li>password: dBXq4J9$rU</li>
        </ul>
        </p>
        <p>В инфоблоке с закладками должны быть созданы свойства типа «строка»: META_TITLE, META_DESCRIPTION,
            META_KEYWORDS.</p>
        <p>Можно настроить Sphinx на сервере и переключить затем в настройках модуля тип поиска, сейчас стоит по
            умолчанию. Хорошая статья по теме:
            https://medium.com/@dermanov.mark/bitrix-and-sphinx-ccd806b68e9f</p>

        <div class="text-center">
            <a href="/bookmarks/" class="btn btn-primary btn-lg mt-5">Перейти в закладки</a>
        </div>
    </div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
