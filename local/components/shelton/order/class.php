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

class OrderComponent extends CBitrixComponent implements Controllerable
{
    public function configureActions(): array
    {
        return [
            'checkBasketAndAddressSession' => [
                'prefilters' => [],
            ],
            'getBasket' => [
                'prefilters' => [],
            ],
        ];
    }
    public function checkBasketAndAddressSessionAction()
    {
        if (
            !isset($_SESSION['order_adress']) ||
            !isset($_SESSION['order_basket']) ||
            empty($_SESSION['order_adress']) ||
            empty($_SESSION['order_basket'])
        ) {
            return [
                'status' => 'error',
                'message' => 'Страница оформления заказа недоступна',
                'redirect' => '/'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Корзина и данные адреса найдены в сессии'
        ];
    }

    public function getBasketAction()
    {
        $basket = [];

        foreach ($_SESSION['order_basket'] as $basketItem) {
            $productId = $basketItem['PRODUCT_ID'];
            $productImage = $this->getImagePath($productId);
            $basket[] = [
                'PRODUCT_ID' => $productId,
                'QUANTITY' => $basketItem['QUANTITY'],
                'PRICE' => $basketItem['PRICE'],
                'CURRENCY' => $basketItem['CURRENCY'],
                'DETAIL_PICTURE' => $productImage
            ];
        }

        return [
            'status' => 'success',
            'basket' => $basket
        ];
    }

    private function getImagePath($productId)
    {
        $product = CIBlockElement::GetByID($productId)->GetNext();
        if ($product && !empty($product['DETAIL_PICTURE'])) {
            return CFile::GetPath($product['DETAIL_PICTURE']);
        }
        return '';
    }

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}
