<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;
Use \Bitrix\Main\Localization\Loc;

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title><? $APPLICATION->ShowTitle(); ?></title>

    <?php
    $APPLICATION->ShowHead();
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/plugins.min.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/starter_template.css');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/plugins.min.js');
    ?>

    <link rel="icon" href="/favicon.ico">
</head>
<body>

<? $APPLICATION->ShowPanel(); ?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/">Lenvendo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Главная</a>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="/bookmarks/" id="bookmarks" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">Закладки</a>
                <div class="dropdown-menu" aria-labelledby="bookmarks">
                    <a class="dropdown-item" href="/bookmarks/">Список</a>
                    <a class="dropdown-item" href="/bookmarks/add/">Добавить</a>
                    <a class="dropdown-item" href="/bookmarks/excel/">Выгрузить</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Поиск" aria-label="Поиск">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Найти</button>
        </form>
    </div>
</nav>

<main role="main" class="container">
    <div class="starter-template">
        <h1><? $APPLICATION->ShowTitle(); ?></h1>