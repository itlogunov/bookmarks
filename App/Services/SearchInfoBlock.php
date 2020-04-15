<?php

namespace App\Services;


use Bitrix\Main\Loader;

class SearchInfoBlock
{
    private $iblockId;
    private $siteId;
    private $query;

    public function __construct(string $siteId, int $iblockId, string $query)
    {
        Loader::includeModule('search');

        $this->iblockId = $iblockId;
        $this->siteId = $siteId;
        $this->query = $query;
    }

    /**
     * Поиск
     *
     * @return array
     */
    public function fullText(): array
    {
        $ids = [];
        $search = new \CSearch();
        $sorting = [];
        $filter = [
            'QUERY' => "*" . $this->query . "*",
            'SITE_ID' => $this->siteId,
            'MODULE_ID' => 'iblock',
            'PARAM2' => $this->iblockId
        ];

        // Ищем с отключенной морфологией - будет больше результатов
        $params = [
            'STEMMING' => false
        ];
        $search->Search($filter, $sorting, $params);

        while ($row = $search->fetch()) {
            $ids[] = $row['ITEM_ID'];
        }

        return $ids;
    }
}
