<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Loader;
use Bitrix\Iblock;

class CustomIblockComponent extends CBitrixComponent
{
    private function getSections()
    {
        $sections = [];
        $sectionObject = CIBlockSection::GetList(
            ["SORT" => "ASC"],
            ["IBLOCK_ID" => $this->arParams["IBLOCK_ID"], "ACTIVE" => "Y"],
            false,
            ["ID", "NAME", "CODE"],
            false
        );
        while ($arSection = $sectionObject->Fetch()) {
            $sections[] = $arSection;
        }

        return $sections;
    }

    private function getProducts($sectionIds)
    {
        $products = [];
        $productObject = CIBlockElement::GetList(
            ["SORT" => "ASC"],
            [
                "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
                "SECTION_ID" => $sectionIds,
                "ACTIVE" => "Y",
            ],
            false,
            false,
            ["ID", "NAME", "IBLOCK_SECTION_ID", "DETAIL_PICTURE", "PROPERTY_GRAMM"]
        );

        while ($arProduct = $productObject->GetNext()) {

            // Обработка детальной картинки
            if (!empty($arProduct["DETAIL_PICTURE"])) {
                $arProduct["DETAIL_PICTURE"] = CFile::GetPath($arProduct["DETAIL_PICTURE"]);
            }

            // Получение цены товара
            $priceData = CCatalogProduct::GetOptimalPrice($arProduct["ID"]);
            $arProduct["PRICE"] = $priceData["PRICE"]["PRICE"];

            // Сохранение товара в массив
            $products[] = $arProduct;
        }

        return $products;
    }

    public function executeComponent()
    {
        if (!Loader::includeModule("iblock")) {
            ShowError("Module 'iblock' is not installed.");
            return;
        }

        // Получение разделов
        $this->arResult["SECTIONS"] = $this->getSections();

        // Извлечение ID всех разделов
        $sectionIds = array_column($this->arResult["SECTIONS"], "ID");

        // Получение товаров из разделов
        if (!empty($sectionIds)) {
            $this->arResult["PRODUCTS"] = $this->getProducts($sectionIds);
        } else {
            $this->arResult["PRODUCTS"] = [];
        }

        $this->includeComponentTemplate();
    }
}
?>