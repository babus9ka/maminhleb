<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$startTime = $arParams['START_TIME'];
$endTime = $arParams['END_TIME'];

$currentTime = date("H:i");

$isOpen = false;
if ($currentTime >= $startTime && $currentTime <= $endTime) {
    $isOpen = true;
} else {
    $isOpen = false;
}

$arResult['IS_OPEN'] = $isOpen;
$this->IncludeComponentTemplate();
?>