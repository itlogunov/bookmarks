<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */

/** @global CMain $APPLICATION */

use GuzzleHttp\Client;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Localization\Loc;
use Symfony\Component\DomCrawler\Crawler;
use Intervention\Image\ImageManagerStatic as Image;

class BookmarksAdd extends CBitrixComponent
{
    private $url;
    private $domain;
    private $favicon;
    private $password;
    private $metaTitle = '';
    private $metaKeywords = '';
    private $metaDescription = '';

    public $arResult = [];
    public $arParams = [];

    /**
     * Проверка модулей
     *
     * @return bool
     * @throws Exception
     */
    private function _checkModules()
    {
        if (!Loader::includeModule('iblock')) {
            throw new \Exception(Loc::getMessage('ERROR_MODULE_IBLOCK'));
        }

        return true;
    }

    /**
     * Подготовка параметров компонента
     *
     * @param $arParams
     * @return mixed
     */
    public function onPrepareComponentParams($arParams)
    {
        $arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
        $arParams['IBLOCK_ID'] = (int)$arParams['IBLOCK_ID'];

        return $arParams;
    }

    /**
     * @return mixed|void
     * @throws Exception
     */
    public function executeComponent()
    {
        $this->_checkModules();
        $this->_request = Application::getInstance()->getContext()->getRequest();
        $this->url = $this->_request->get('url');
        $this->password = $this->_request->get('password');

        if (isset($this->url)) {
            $this->parseUrl();

            if (!$this->checkUrl()) {
                $this->includeComponentTemplate();
                return false;
            }

            if (!$this->checkBookmarkDb()) {
                $this->includeComponentTemplate();
                return false;
            }

            if (!$this->downloadPage()) {
                $this->includeComponentTemplate();
                return false;
            }

            $bookmarkId = $this->saveDb();
            if (!$bookmarkId) {
                $this->includeComponentTemplate();
                return false;
            }

            $redirectUrl = str_replace('#ELEMENT_ID#', $bookmarkId, $this->arParams['ELEMENT_URL']);
            header('Location: ' . $redirectUrl);
            die();
        }

        $this->includeComponentTemplate();
    }

    /**
     * Получим ссылку на домен и обрежем в url пробелы
     */
    private function parseUrl()
    {
        $this->url = trim(htmlspecialchars($this->url));
        $parts = parse_url($this->url);
        $this->domain = $parts['scheme'] . '://' . $parts['host'];
    }

    /**
     * Проверим URL
     *
     * @return bool
     */
    private function checkUrl(): bool
    {
        if (!strlen($this->url) > 0 || filter_var($this->url, FILTER_VALIDATE_URL) === false) {
            $this->arResult['ERRORS'][] = Loc::getMessage('ERROR_EMPTY_URL');
            return false;
        }

        return true;
    }

    /**
     * Проверка на существование закладки в БД
     *
     * @return bool
     * @throws Bitrix\Main\ArgumentException
     * @throws Bitrix\Main\ObjectPropertyException
     * @throws Bitrix\Main\SystemException
     */
    private function checkBookmarkDb(): bool
    {
        $query = ElementTable::getList([
            'order' => [],
            'select' => ['ID'],
            'filter' => ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'NAME' => $this->url],
            'limit' => 1,
            'offset' => 0
        ]);
        if ($row = $query->fetch()) {
            $this->arResult['ERRORS'][] = Loc::getMessage('ERROR_BOOKMARK_FOUND');
            return false;
        }

        return true;
    }

    /**
     * Скачиваем страницу и получаем необходимые данные
     *
     * @return bool
     */
    private function downloadPage(): bool
    {
        $client = new Client([
            'timeout' => 7
        ]);

        try {
            $response = $client->request('GET', $this->url);
            $statusCode = $response->getStatusCode();
            if ($statusCode != 200) {
                $this->arResult['ERRORS'][] = Loc::getMessage('ERROR_URL_NOT_AVAILABLE');
                return false;
            }
        } catch (Exception $exception) {
            $this->arResult['ERRORS'][] = Loc::getMessage('ERROR_URL_NOT_AVAILABLE');
            return false;
        }

        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);

        $favicon = $crawler->filterXPath('//link[@rel="shortcut icon"]');
        if ($favicon->count()) {
            $this->favicon = $favicon->attr('href');
        } else {
            $favicon = $crawler->filterXPath('//link[@rel="icon"]');
            if ($favicon->count()) {
                $this->favicon = $favicon->attr('href');
            }
        }

        $metaTitle = $crawler->filterXpath('//title');
        if ($metaTitle->count()) {
            $this->metaTitle = $metaTitle->text();
        }

        $metaDescription = $crawler->filterXpath('//meta[@name="description"]');
        if ($metaDescription->count()) {
            $this->metaDescription = $metaDescription->extract(['content'])[0];
        }

        $metaKeywords = $crawler->filterXpath('//meta[@name="keywords"]');
        if ($metaKeywords->count()) {
            $this->metaKeywords = $metaKeywords->extract(['content'])[0];
        }

        return true;
    }

    /**
     * Сохраняем
     *
     * @return int
     */
    private function saveDb(): int
    {
        $bookmarkId = 0;
        $ciBlockElement = new CIBlockElement();
        $data = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
            'NAME' => $this->url,
            'CODE' => (strlen($this->password) > 0) ? sha1($this->password) : '',
            'ACTIVE' => 'Y',
            'PROPERTY_VALUES' => [
                'META_TITLE' => $this->metaTitle,
                'META_DESCRIPTION' => $this->metaDescription,
                'META_KEYWORDS' => $this->metaKeywords
            ]
        ];

        $favicon = $this->getFavicon();
        if ($favicon) {
            $data['DETAIL_PICTURE'] = CFile::MakeFileArray($favicon);
        }

        if (!$bookmarkId = $ciBlockElement->Add($data)) {
            $this->arResult['ERRORS'][] = $ciBlockElement->LAST_ERROR;
            return false;
        }

        return $bookmarkId;
    }

    /**
     * Получим фавиконку для сохранения в базу
     */
    private function getFavicon(): int
    {
        $favicon = 0;
        if (!is_null($this->favicon)) {
            $favicon = $this->domain . $this->favicon;
            if (substr($this->favicon, 0, 2) == '//') {
                $favicon = 'http:' . $this->favicon;
            } elseif (strstr($this->favicon, '//')) {
                $favicon = $this->favicon;
            }

            // Сохраняем в png
            $favicon = CFile::MakeFileArray($favicon);
            if (is_array($favicon)) {

                if ($favicon['type'] == 'unknown') {
                    return 0;
                }

                $filePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . sha1(date('d.m.Y H:i:s')) . '.png';
                Image::configure(['driver' => 'imagick']);
                Image::make($favicon['tmp_name'])->save($filePath);

                $fileId = CFile::SaveFile(
                    [
                        'name' => 'favicon.png',
                        'tmp_name' => $filePath,
                        'old_file' => '0',
                        'type' => 'image/png'
                    ],
                    'bookmarks',
                    false,
                    false
                );

                if ($fileId) {
                    unlink($filePath);
                    $favicon = $fileId;
                }
            }
        }

        return $favicon;
    }
}
