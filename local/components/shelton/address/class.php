<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Catalog\StoreTable;

class AddressComponent extends CBitrixComponent implements Controllerable
{
    public function configureActions(): array
    {
        return [
            'checkBasket' => [
                'prefilters' => [],
            ],
            'processAddress' => [
                'prefilters' => [],
            ],
            'getWarehouses' => [
                'prefilters' => [],
            ],
        ];
    }

    public function getWarehousesAction()
    {
        $warehouses = [];

        $result = StoreTable::getList([
            'filter' => ['=ACTIVE' => 'Y'],
            'select' => ['ID', 'ADDRESS', 'GPS_N', 'GPS_S']
        ]);

        while ($arstore = $result->fetch()) {
            $warehouses[] = [
                'id' => $arstore['ID'],
                'label' => $arstore['ADDRESS'],
                'coords' => [(float) $arstore['GPS_N'], (float) $arstore['GPS_S']]
            ];
        }

        return $warehouses;

    }


    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}
