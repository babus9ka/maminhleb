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

    public function checkBasketAction()
    {
        $basket = Basket::loadItemsForFUser(
            \Bitrix\Sale\Fuser::getId(),
            Context::getCurrent()->getSite()
        );

        return $basket->isEmpty() ? "Корзина пуста" : "Корзина содержит товары";
    }

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}
