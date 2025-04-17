<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Bitrix\Main\Context;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Catalog\Product\Basket as ProductBasket;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\SystemException;
use Bitrix\Main\Entity\Result;

class BasketComponent extends CBitrixComponent implements Controllerable
{
    public function configureActions(): array
    {
        return [
            'getBasket' => [
                'prefilters' => [],
            ],
            'addToBasket' => [
                'prefilters' => [],
            ],
            'checkBasket' => [
                'prefilters' => [],
            ],
            'getBasketTotalSum' => [
                'prefilters' => [],
            ],
            'addToBasketQuantity' => [
                'prefilters' => [],
            ],
            'removeFromBasketQuantity' => [
                'prefilters' => [],
            ]
        ];
    }

    public function checkBasketAction()
    {
        $basket = Basket::loadItemsForFUser(
            Fuser::getId(),
            Context::getCurrent()->getSite()
        );

        return ['hasItems' => !$basket->isEmpty()];
    }

    public function getBasketAction()
    {
        $this->includeModules(['sale']);

        $basket = $this->loadUserBasket(Fuser::getId());
        $items = [];
        $totalBasketSum = 0;

        foreach ($basket->getBasketItems() as $item) {
            $productId = $item->getProductId();

            $productData = $this->getProductImageAndGramm($productId);
            $imagePath = $productData['image'];
            $gramm = $productData['gramm'];
            $itemTotal = $item->getPrice() * $item->getQuantity();

            $items[] = [
                'PRODUCTID' => $productId,
                'NAME' => $item->getField('NAME'),
                'QUANTITY' => $item->getQuantity(),
                'PRICE' => $item->getPrice(),
                'IMAGE' => $imagePath,
                'GRAMM' => $gramm,
                'PRODUCT_PRICE' => $itemTotal,
            ];

            $totalBasketSum += $itemTotal;
        }

        return [
            'ITEMS' => $items,
            'TOTAL_SUM' => $totalBasketSum, // Общая сумма всей корзины
        ];
    }

    public function addToBasketAction(int $productId, float $quantity, float $price, string $name)
    {
        $this->includeModules(['sale', 'catalog']);

        $basket = $this->loadUserBasket(Fuser::getId());
        $existingItem = $basket->getExistsItem('catalog', $productId);

        if ($existingItem) {
            // Обновляем количество, если товар уже есть в корзине
            $existingItem->setField('QUANTITY', $existingItem->getQuantity() + $quantity);
        } else {
            // Создаём новую позицию в корзине
            $newItem = $basket->createItem('catalog', $productId);
            $newItem->setFields([
                'QUANTITY' => $quantity,
                'CURRENCY' => CurrencyManager::getBaseCurrency(),
                'LID' => Context::getCurrent()->getSite(),
                'PRODUCT_PROVIDER_CLASS' => ProductBasket::getDefaultProviderName(),
                'PRICE' => $price,
                'NAME' => $name,
            ]);
        }

        $result = $basket->save();

        if (!$result->isSuccess()) {
            return [
                'success' => false,
                'error' => implode(', ', $result->getErrorMessages()),
            ];
        }

        return ['success' => true];
    }
    public function getBasketTotalSumAction()
    {
        $this->includeModules(['sale']);

        $basket = $this->loadUserBasket(Fuser::getId());
        $totalBasketSum = 0;

        foreach ($basket->getBasketItems() as $item) {
            $totalBasketSum += $item->getPrice() * $item->getQuantity();
        }

        return [
            'TOTAL_SUM' => $totalBasketSum,
        ];
    }
    public function addToBasketQuantityAction(int $productId, float $quantity, $price)
    {
        $this->includeModules(['sale']);
        $basket = $this->loadUserBasket(Fuser::getId());
        $item = $basket->getExistsItem('catalog', $productId);

        if ($item) {
            $newQuantity = $item->getQuantity() + 1;
            $item->setField('QUANTITY', $newQuantity);
            $basket->save();
            $productPrice = $price * $newQuantity;
            return [
                'PRODUCTID' => $productId,
                'QUANTITY' => $newQuantity,
                'PRICE' => $price,
                'PRODUCT_PRICE' => $productPrice,
            ];
        }

        // Если товара в корзине не было
        return [
            'PRODUCTID' => $productId,
            'QUANTITY' => 0,
            'PRICE' => 0,
        ];
    }

    public function removeFromBasketQuantityAction(int $productId, float $quantity, $price)
    {
        $this->includeModules(['sale']);

        $basket = $this->loadUserBasket(Fuser::getId());
        $item = $basket->getExistsItem('catalog', $productId);

        if ($item) {
            $newQuantity = $item->getQuantity() - 1;

            if ($newQuantity <= 0) {
                $item->delete(); // Если товара 0 или меньше — удаляем
            } else {
                $item->setField('QUANTITY', $newQuantity);
            }

            $basket->save();

            return [
                'success' => true,
                'PRODUCTID' => $productId,
                'QUANTITY' => max($newQuantity, 0), // Возвращаем 0, если товар удалён
                'PRICE' => $price,
                'PRODUCT_PRICE' => max($price * $newQuantity, 0),
            ];
        }

        return [
            'success' => false, // Если товара не было в корзине
            'PRODUCTID' => $productId,
            'QUANTITY' => 0,
            'PRICE' => 0,
        ];
    }

    public function onBeforeUserLogin(int $userId): void
    {
        $guestBasket = $this->loadUserBasket(Fuser::getId());
        $userBasket = $this->loadUserBasket($userId);

        // Переносим позиции из анонимной корзины в корзину авторизованного пользователя
        foreach ($guestBasket->getBasketItems() as $guestItem) {
            $productId = $guestItem->getProductId();
            $existsItem = $userBasket->getExistsItem('catalog', $productId);

            if ($existsItem) {
                $existsItem->setField('QUANTITY', $existsItem->getQuantity() + $guestItem->getQuantity());
            } else {
                $newItem = $userBasket->createItem('catalog', $productId);
                $newItem->setFields([
                    'QUANTITY' => $guestItem->getQuantity(),
                    'CURRENCY' => $guestItem->getCurrency(),
                    'LID' => Context::getCurrent()->getSite(),
                    'PRICE' => $guestItem->getPrice(),
                    'NAME' => $guestItem->getField('NAME'),
                ]);
            }
        }

        $userBasket->save();

        // Очищаем корзину анонимного пользователя
        $guestBasket->clearItems();
        $guestBasket->save();
    }

    public function onBeforeUserLogout(): void
    {
        // Просто сохраняем текущую корзину, если нужно
        $basket = $this->loadUserBasket(Fuser::getId());
        $basket->save();
    } 

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

    private function includeModules(array $modules): void
    {
        foreach ($modules as $module) {
            if (!Loader::includeModule($module)) {
                throw new SystemException("Модуль {$module} не установлен");
            }
        }
    }

    private function loadUserBasket(int $fuserId): Basket
    {
        return Basket::loadItemsForFUser($fuserId, Context::getCurrent()->getSite());
    }

    private function getProductImageAndGramm(int $productId): array
    {
        $res = CIBlockElement::GetList(
            [],
            ['=ID' => $productId],
            false,
            ['nTopCount' => 1],
            ['DETAIL_PICTURE', 'PROPERTY_GRAMM']
        );

        if ($product = $res->Fetch()) {
            return [
                'image' => $product['DETAIL_PICTURE'] ? CFile::GetPath($product['DETAIL_PICTURE']) : '', // Проверка на наличие изображения
                'gramm' => isset($product['PROPERTY_GRAMM_VALUE']) ? $product['PROPERTY_GRAMM_VALUE'] : null // Проверка на граммы
            ];
        }

        return [
            'image' => '',
            'gramm' => null
        ];
    }

}
