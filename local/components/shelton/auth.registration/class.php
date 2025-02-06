<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Bitrix\Main\Engine\Contract\Controllerable;


class AuthRegistrationComponent extends CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [
            'auth' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                ],
            ],
            'register' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                ],
            ],
        ];
    }

    public function authAction($phone, $password)
    {
        $user = new CUser;
        $authResult = $user->Login($phone, $password, "Y");

        if ($authResult === true) {
            return [
                "status" => "success",
                "message" => "Вы успешно авторизовались",
            ];
        }

        return [
            "status" => "error",
            "message" => "Ошибка авторизации: " . str_replace('логин', 'телефон', $authResult["MESSAGE"]),
        ];
    }

    public function validateAddressAction($address, $entrance, $doorphone, $floor, $flat, $privateHouse, $addressComment)
    {
        global $USER;

        $userId = $USER->GetID();

        if (!$userId) {
            return [
                "status" => "error",
                "message" => "Пользователь не авторизован",
            ];
        }

        // Поля для проверки на пустоту
        $requiredFields = [
            'address' => 'Адрес не может быть пустым',
            'entrance' => 'Номер подъезда не может быть пустым',
            'floor' => 'Этаж не может быть пустым',
            'flat' => 'Номер квартиры не может быть пустым',
            'addressComment' => 'Комментарий к адресу не может быть пустым',
        ];

        // Проверяем каждое обязательное поле
        foreach ($requiredFields as $field => $errorMessage) {
            if (empty($$field)) {
                return [
                    "status" => "error",
                    "message" => $errorMessage,
                ];
            }
        }

        // Поля для проверки на "только цифры"
        $numericFields = [
            'entrance' => 'Номер подъезда должен содержать только цифры',
            'floor' => 'Этаж должен содержать только цифры',
            'flat' => 'Номер квартиры должен содержать только цифры',
        ];

        // Проверяем, что указанные поля содержат только цифры
        foreach ($numericFields as $field => $errorMessage) {
            if (!preg_match('/^\d+$/', $$field)) {
                return [
                    "status" => "error",
                    "message" => $errorMessage,
                ];
            }
        }

        // Проверка домофона для частного дома
        if ($privateHouse && empty($doorphone)) {
            return [
                "status" => "error",
                "message" => "Для частного дома необходимо указать домофон",
            ];
        }

        // Все проверки пройдены
        return [
            "status" => "success",
            "message" => "Адрес успешно валидирован для пользователя с ID: {$userId}",
        ];
    }

    public function registerAction($phone, $name, $email, $password, $passwordConfirm)
    {
        if ($password !== $passwordConfirm) {
            return [
                "status" => "error",
                "message" => "Пароли не совпадают",
            ];
        }

        $user = new CUser;
        $fields = [
            "LOGIN" => $phone,
            "REGISTER_PHONE" => $phone,
            "NAME" => $name,
            "EMAIL" => $email,
            "PASSWORD" => $password,
            "CONFIRM_PASSWORD" => $passwordConfirm,
        ];

        $userId = $user->Add($fields);

        if ($userId > 0) {
            return [
                "status" => "success",
                "message" => "Регистрация прошла успешно",
            ];
        }

        return [
            "status" => "error",
            "message" => "Ошибка регистрации: " . $user->LAST_ERROR,
        ];
    }


    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}
