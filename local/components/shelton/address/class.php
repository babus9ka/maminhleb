<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Sale\Basket;
use Bitrix\Main\UserTable;
use Bitrix\Sale;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Sale\Delivery\Services\Manager;

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
        ];
    }


    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}
