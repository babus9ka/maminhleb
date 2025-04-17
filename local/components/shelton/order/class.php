<?php

use Bitrix\Main\Engine\Response\Redirect;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Context;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Delivery;
use Bitrix\Main\Loader;
use Bitrix\Main\Mail\Event;

class OrderComponent extends CBitrixComponent implements Controllerable
{
    public function configureActions(): array
    {
        return [
            'clearBasket' => [
                'prefilters' => [],
            ],
            'isAuthorized' => [
                'prefilters' => [],
            ],
            'processOrder' => [
                'prefilters' => [],
            ],

        ];
    }

    public function isAuthorizedAction()
    {
        global $USER;
        return $USER->IsAuthorized();
    }

    public function clearBasketAction()
    {
        CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
        return [
            'redirect' => '/'
        ];
    }

    private function checkPostRequestAndRedirect($request)
    {
        if (!$request->isPost() || $request->getPostList()->count() === 0) {
            LocalRedirect('/');
            return true;
        }

        return false;
    }

    private function validateDeliveryAndAddressRequest($postList)
    {
        return empty($postList['delivery_option']);
    }

    protected function getRussianMonth($monthNumber)
    {
        $months = [
            1 => 'Января',
            2 => 'Февраля',
            3 => 'Марта',
            4 => 'Апреля',
            5 => 'Мая',
            6 => 'Июня',
            7 => 'Июля',
            8 => 'Августа',
            9 => 'Сентября',
            10 => 'Октября',
            11 => 'Ноября',
            12 => 'Декабря'
        ];

        return $months[$monthNumber];
    }

    protected function generateDate()
    {
        $now = new \DateTime();
        $limit = (clone $now)->modify('+1 month');
        $dates = [];
        while ($now <= $limit) {
            $dayNumber = $now->format('d');
            $monthName = $this->getRussianMonth($now->format('n'));
            $dates[] = $dayNumber . ' ' . $monthName;
            $now->modify('+1 day');
        }

        return $dates;
    }

    public function executeComponent()
    {
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        if ($this->checkPostRequestAndRedirect($request)) {
            return;
        }
        $postList = $request->getPostList();
        if ($this->validateDeliveryAndAddressRequest($postList)) {
            LocalRedirect('/');
            return;
        }

        $this->arResult['DATES'] = $this->generateDate();
        $this->includeComponentTemplate();
    }

    protected function registerUser($email, $phone, $name)
    {
        global $USER;
        if (!$USER->IsAuthorized()) {

            if (empty($email)) {
                throw new Exception("Email обязателен для оформления заказа");
            }
            $login = $phone;
            $password = \Bitrix\Main\Security\Random::getString(8);

            $user = new CUser();
            $fields = [
                "LOGIN" => $login,
                "NAME" => $name,
                "EMAIL" => $email,
                "LID" => SITE_ID,
                "ACTIVE" => "Y",
                "PASSWORD" => $password,
                "CONFIRM_PASSWORD" => $password,
            ];

            $newUserId = $user->Add($fields);
            if (!$newUserId) {
                return ("Ошибка регистрации: " . $user->LAST_ERROR);
            } else {
                AddMessage2Log('Событие отработало');
                $result = Event::send([
                    "EVENT_NAME" => "NEW_USER_ACCOUNT",
                    "LID" => SITE_ID,
                    "C_FIELDS" => [
                        "EMAIL_TO" => $email,
                        "USER_ID" => $newUserId,
                        "LOGIN" => $login,
                        "PASSWORD" => $password,
                        "EMAIL" => $email,
                        "NAME" => $name,
                    ],
                ]);

                AddMessage2Log($result);
                die();
                $USER->Authorize($newUserId);
            }
        }
    }

    protected function updateUserDeliveryAddress($address)
    {
        global $USER;
        $userId = $USER->GetID();
        $userUpdate = new CUser();
        $fields = [
            "UF_ADDRESS" => $address,
        ];
        $res = $userUpdate->Update($userId, $fields);
    }

    protected function createOrderFromContext($postData)
    {


        global $USER;
        $userId = $USER->GetID();
        $fuser = \Bitrix\Sale\Fuser::getIdByUserId($userId);
        $siteId = Context::getCurrent()->getSite();

        $currencyCode = CurrencyManager::getBaseCurrency();

        // Создаём новый заказ
        $order = Order::create($siteId, $userId, $currencyCode);
        $order->setPersonTypeId(1);

        $order->setField('CURRENCY', $currencyCode);
        // Если есть комментарий к заказу, его можно сохранить
        if (!empty($postData['order-comment'])) {
            $order->setField('USER_DESCRIPTION', trim($postData['order-comment']));
        }

        // Получаем текущую корзину покупателя
        $basket = Basket::loadItemsForFUser($fuser, $siteId);
        $order->setBasket($basket);



        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem();
        $deliveryId = ($postData['delivery_option'] == 'delivery') ? 2 : 3;

        $service = Delivery\Services\Manager::getById($deliveryId);

        $shipment->setFields(array(
            'DELIVERY_ID' => $service['ID'],
            'DELIVERY_NAME' => $service['NAME'],
        ));

        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        foreach ($order->getBasket() as $item) {
            $shipmentItem = $shipmentItemCollection->createItem($item);
            $shipmentItem->setQuantity($item->getQuantity());
        }
        $shipmentCollection = $order->getShipmentCollection();
        foreach ($shipmentCollection as $shipment) {
            if (!$shipment->isSystem()) {
                $shipment->allowDelivery(); // разрешаем отгрузку
            }
        }

        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem();
        $paySystemId = ($postData['payment_type'] == "2") ? 2 : 3;
        $payment->setFields(array(
            'PAY_SYSTEM_ID' => $paySystemId,
            'SUM' => $order->getPrice()
        ));


        $propertyCollection = $order->getPropertyCollection();
        $propertyCollection->getItemByOrderPropertyCode('FIO')?->setValue($postData['name']);
        $propertyCollection->getItemByOrderPropertyCode('PHONE')?->setValue($postData['phone']);
        $propertyCollection->getItemByOrderPropertyCode('ENTRANCE')?->setValue($postData['entrance']);
        $propertyCollection->getItemByOrderPropertyCode('INTERCOM')?->setValue($postData['intercom']);
        $propertyCollection->getItemByOrderPropertyCode('FLOOR')?->setValue($postData['floor']);
        $propertyCollection->getItemByOrderPropertyCode('FLAT')?->setValue($postData['apartment']);
        $propertyCollection->getItemByOrderPropertyCode('ADDRESS_NOTE')?->setValue($postData['address-comment']);
        $propertyCollection->getItemByOrderPropertyCode('CHANGE_FROM_PURCHASE')?->setValue($postData['change_amount']);
        $propertyCollection->getItemByOrderPropertyCode('DELIVERY_DATE')?->setValue($postData['order-date']);

        if ($USER->IsAuthorized()) {
            $userData = CUser::GetByID($USER->GetID())->Fetch();
            $email = $userData['EMAIL'];
        } elseif (!empty($postData['email'])) {
            $email = $postData['email'];
        }

        if (!empty($email)) {
            $propertyCollection->getItemByOrderPropertyCode('EMAIL')?->setValue($email);
        }

        $saveResult = $order->save();
        if (!$saveResult->isSuccess()) {
            $errors = $saveResult->getErrors();
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return [
                'status' => 'error',
                'errors' => $errorMessages
            ];
        } else {
            // Если доставку выбрали и пользователь авторизован – обновляем адресные данные в профиле
            if ($postData['delivery_option'] === 'delivery' && $USER->IsAuthorized()) {
                $this->updateUserDeliveryAddress($postData['address']);
            }
        }

    }

    public function processOrderAction($orderData = [])
    {
        // Подключаем необходимые модули
        Loader::includeModule("sale");
        Loader::includeModule("catalog");
        $postData = $orderData;

        // Контактные данные клиента
        $name = isset($postData['name']) ? trim($postData['name']) : '';
        $phone = isset($postData['phone']) ? trim($postData['phone']) : '';
        $email = isset($postData['email']) ? trim($postData['email']) : '';

        // Если пользователь не авторизован – регистрируем нового пользователя
        $this->registerUser($email, $phone, $name);
        // // Получаем данные для создания заказа
        return $this->createOrderFromContext($postData);

    }
}



