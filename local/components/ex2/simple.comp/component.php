<?php

use Bitrix\Main\Context;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

global $USER;

$arParams["CACHE_TIME"] = $arParams["CACHE_TIME"] ?? 300;
$arParams["IBLOCK_ID_PRODUCTS"] = $arParams["IBLOCK_ID_PRODUCTS"] ?: 2;
$arParams["IBLOCK_ID_PRODUCTS_CLASSIFIER"] = $arParams["IBLOCK_ID_PRODUCTS_CLASSIFIER"] ?: 7;
$arParams["PRODUCT_URL_TEMPLATE"] = $arParams["PRODUCT_URL_TEMPLATE"] ?: 'catalog_exam/#SECTION_ID#/#ELEMENT_CODE#';
$arParams["PRODUCT_TO_CLASSIFIER_CODE"] = $arParams["PRODUCT_TO_CLASSIFIER_CODE"] ?: 'COMPANIES';

$request = Context::getCurrent()->getRequest();
$isUseFilter = (bool)$request->get("F");
if ($isUseFilter || $this->startResultCache(false, $USER->GetGroups())) {
    //классификаторы
    $arClassifiersFilter = ["IBLOCK_ID" => $arParams["IBLOCK_ID_PRODUCTS_CLASSIFIER"], "CHECK_PERMISSIONS" => "Y"];
    $arClassifiersFields = ["ID", "NAME"];
    $classifiersQ =
        CIBlockElement::GetList(false, $arClassifiersFilter, false, false, $arClassifiersFields);

    $catalog = [];
    while ($classifierItem = $classifiersQ->Fetch()) {
        $catalog[$classifierItem["ID"]]["name"] = $classifierItem["NAME"];
    }

    // продукция
    $arProductsOrder = ["name" => "asc", "sort" => "asc"];
    $propName = "PROPERTY_{$arParams["PRODUCT_TO_CLASSIFIER_CODE"]}";
    $arProductsFilter = [
        "IBLOCK_ID" => $arParams["IBLOCK_ID_PRODUCTS"],
        "CHECK_PERMISSIONS" => "Y",
        $propName => array_keys($catalog)
    ];

    if ($isUseFilter) {
        $arProductsFilter += [
            [
                "LOGIC" => "OR",
                ["<=PROPERTY_PRICE" => 1700, "=PROPERTY_MATERIAL" => "Дерево, ткань"],
                ["<PROPERTY_RADIUS" => 1500, "=PROPERTY_MATERIAL" => "Металл, пластик"],
            ],
        ];
    }

    $arProductsFields =
        ["ID", "NAME", "PROPERTY_COMPANIES", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL", "CODE", "IBLOCK_ID", "IBLOCK_SECTION_ID"];
    $productsQ =
        CIBlockElement::GetList($arProductsOrder, $arProductsFilter, false, false, $arProductsFields);

    // формирование результируещего массива
    while($product = $productsQ->Fetch()) {
        $product["DETAIL_PAGE_URL"] = str_replace(
            ["#SECTION_ID#", "#ELEMENT_CODE#"],
            [$product["IBLOCK_SECTION_ID"], $product["CODE"]],
            $arParams["PRODUCT_URL_TEMPLATE"]
        );
        $catalog[$product["PROPERTY_COMPANIES_VALUE"]]["products"][] = $product;
    }
    $arResult["TOTAL_CNT"] = count($catalog);
    $arResult["ITEMS"] = $catalog;
    $this->includeComponentTemplate();
}

$APPLICATION->SetTitle("Разделов: {$arResult["TOTAL_CNT"]}");