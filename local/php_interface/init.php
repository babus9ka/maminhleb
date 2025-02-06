<?php

use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

// Убедитесь, что модуль "sale" загружен
if (Loader::includeModule('sale')) {

    // Регистрируем обработчик для события входа пользователя
    EventManager::getInstance()->addEventHandler(
        "catalog", 
        "OnBeforeUserLogin", 
        function($arParams) {
            $userId = $arParams['USER_ID'];
            $basketComponent = new BasketComponent();
            $basketComponent->onBeforeUserLogin($userId);
        }
    );
}
?>
