<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

// Проверяем установку модуля «Информационные блоки»
if (!CModule::IncludeModule('iblock')) {
    return;
}

// Получаем типы инфоблоков
$arIBlockType = CIBlockParameters::GetIBlockTypes();

// Подготавливаем массивы для данных инфоблоков
$arInfoBlocks = array();
$arFilterInfoBlocks = array('ACTIVE' => 'Y');
$arOrderInfoBlocks = array('SORT' => 'ASC');

// Если выбран тип инфоблока, фильтруем
if (!empty($arCurrentValues['IBLOCK_TYPE'])) {
    $arFilterInfoBlocks['TYPE'] = $arCurrentValues['IBLOCK_TYPE'];
}

// Получаем список инфоблоков
$rsIBlock = CIBlock::GetList($arOrderInfoBlocks, $arFilterInfoBlocks);
while ($obIBlock = $rsIBlock->Fetch()) {
    $arInfoBlocks[$obIBlock['ID']] = '[' . $obIBlock['ID'] . '] ' . $obIBlock['NAME'];
}

// Настройки параметров компонента
$arComponentParameters = array(
    "GROUPS" => array(
        "TEST" => array(
            "NAME" => 'Тест'
        ),
    ),
    'PARAMETERS' => array(
        // Выбор типа инфоблока
        'IBLOCK_TYPE' => array(
            'PARENT' => 'TEST',
            'NAME' => 'Выберите тип инфоблока',
            'TYPE' => 'LIST',
            'VALUES' => $arIBlockType,
            'REFRESH' => 'Y',
            'DEFAULT' => 'news',
            'MULTIPLE' => 'N',
        ),
        // Выбор инфоблока
        'IBLOCK_ID' => array(
            'PARENT' => 'TEST',
            'NAME' => 'Выберите родительский инфоблок',
            'TYPE' => 'LIST',
            'VALUES' => $arInfoBlocks,
            'REFRESH' => 'Y',
            'DEFAULT' => '',
            'ADDITIONAL_VALUES' => 'Y',
        ),
        // Настройки кэширования
        'CACHE_TIME' => array(
            'DEFAULT' => 3600
        ),
    ),
);
?>
