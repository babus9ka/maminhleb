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
    /**
     * Подключаем методы, которые будут доступны как действия контроллера (ajax, REST, и т.д.)
     *
     * @return array
     */
    public function configureActions(): array
    {
        return [
            'addToBasket' => [
                'prefilters' => [],
            ],
            'getBasket' => [
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

    /**
     * Возвращает содержимое корзины текущего FUSER (анонимного или авторизованного)
     */
    public function getBasketAction()
    {
        $this->includeModules(['sale']);

        $basket = $this->loadUserBasket(Fuser::getId());
        if ($basket->isEmpty()) {
            return null;
        }

        $items = [];
        $totalBasketSum = 0;
        foreach ($basket->getBasketItems() as $item) {
            $productId = $item->getProductId();
            $imagePath = $this->getProductImage($productId);
            $itemTotal = $item->getPrice() * $item->getQuantity();

            $items[] = [
                'PRODUCTID' => $productId,
                'NAME' => $item->getField('NAME'),
                'QUANTITY' => $item->getQuantity(),
                'PRICE' => $item->getPrice(),
                'IMAGE' => $imagePath,
            ];

            $totalBasketSum += $itemTotal;
        }

        return [
            'ITEMS' => $items,
            'TOTAL_SUM' => $totalBasketSum,
        ];
    }

    /**
     * Добавляет товар в корзину
     *
     * @param int    $productId
     * @param float  $quantity
     * @param float  $price
     * @param string $name
     *
     * @return array
     * @throws SystemException
     */
    public function addToBasketAction(int $productId, float $quantity, float $price, string $name): array
    {
        $this->includeModules(['sale', 'catalog']);

        $imagePath = $this->getProductImage($productId);

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
            $existingItem = $newItem; // чтобы ниже работать с $existingItem
        }

        $basket->save();

        return [
            'data' => [
                'PRODUCTID' => $existingItem->getProductId(),
                'NAME' => $existingItem->getField('NAME'),
                'QUANTITY' => $existingItem->getQuantity(),
                'PRICE' => $existingItem->getPrice(),
                'IMAGE' => $imagePath,
            ],
        ];
    }

    /**
     * Устанавливает количество (QUANTITY) для товара в корзине
     *
     * @param int   $productId
     * @param float $quantity
     *
     * @return array
     * @throws SystemException
     */
    public function addToBasketQuantityAction(int $productId, float $quantity)
    {
        $this->includeModules(['sale']);

        $basket = $this->loadUserBasket(Fuser::getId());
        $item = $basket->getExistsItem('catalog', $productId);

        if ($item) {
            $item->setField('QUANTITY', $quantity);
            $basket->save();
            return [
                'PRODUCTID' => $productId,
                'QUANTITY' => $quantity,
                'PRICE' => $item->getPrice(),
            ];
        }

        // Если товара в корзине не было
        return [
            'PRODUCTID' => $productId,
            'QUANTITY' => 0,
            'PRICE' => 0,
        ];
    }

    public function removeFromBasketQuantityAction(int $productId, float $quantity)
    {
        $this->includeModules(['sale']);


        $basket = $this->loadUserBasket(Fuser::getId());
        $item = $basket->getExistsItem('catalog', $productId);

        if ($item) {
            if ($quantity < 1) {
                $item->delete();
            } else {
                $item->setField('QUANTITY', $quantity);
            }

            $basket->save();

            return [
                'PRODUCTID' => $productId,
                'QUANTITY' => $quantity > 0 ? $quantity : 0,
                'PRICE' => $quantity > 0 ? $item->getPrice() : 0,
            ];
        }


        return [
            'PRODUCTID' => $productId,
            'QUANTITY' => 0,
            'PRICE' => 0,
        ];
    }


    /**
     * Метод вызывается при авторизации пользователя (пример: перенос корзины анонимного пользователя в корзину авторизованного)
     *
     * @param int $userId
     *
     * @return void
     */
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

    /**
     * Метод вызывается при выходе пользователя
     */
    public function onBeforeUserLogout(): void
    {
        // Просто сохраняем текущую корзину, если нужно
        $basket = $this->loadUserBasket(Fuser::getId());
        $basket->save();
    }

    /**
     * Основной метод компонента
     */
    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

    /**
     * Вспомогательный метод для подключения модулей
     *
     * @param array $modules
     * @throws SystemException
     */
    private function includeModules(array $modules): void
    {
        foreach ($modules as $module) {
            if (!Loader::includeModule($module)) {
                throw new SystemException("Модуль {$module} не установлен");
            }
        }
    }

    /**
     * Возвращает объект корзины для указанного FUSER
     *
     * @param int $fuserId
     * @return Basket
     */
    private function loadUserBasket(int $fuserId): Basket
    {
        return Basket::loadItemsForFUser($fuserId, Context::getCurrent()->getSite());
    }

    /**
     * Получает путь к изображению товара
     *
     * @param int $productId
     * @return string
     */
    private function getProductImage(int $productId): string
    {
        $res = ElementTable::getList([
            'select' => ['DETAIL_PICTURE'],
            'filter' => ['=ID' => $productId],
            'limit' => 1,
        ]);

        if ($product = $res->fetch()) {
            return CFile::GetPath($product['DETAIL_PICTURE']);
        }

        return '';
    }
}
