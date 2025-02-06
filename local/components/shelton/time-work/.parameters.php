<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "START_TIME" => array(
            "PARENT" => "BASE",
            "NAME" => "Время начала работы",
            "TYPE" => "TEXT",
            "DEFAULT" => "10:00",
        ),
        "END_TIME" => array(
            "PARENT" => "BASE",
            "NAME" => "Время окончания работы",
            "TYPE" => "TEXT",
            "DEFAULT" => "20:00",
        ),
    ),
);
?>