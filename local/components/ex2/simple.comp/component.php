<?php
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
$arParams["PRODUCT_URL_TEMPLATE"] = $arParams["PRODUCT_URL_TEMPLATE"] ?: 'test';
$arParams["PRODUCT_TO_CLASSIFIER_CODE"] = $arParams["PRODUCT_TO_CLASSIFIER_CODE"] ?: 'COMPANIES';

if ($this->startResultCache(false, $USER->GetGroups())) {
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
    $propName = "PROPERTY_{$arParams["PRODUCT_TO_CLASSIFIER_CODE"]}";
    $arProductsFilter = [
        "IBLOCK_ID" => $arParams["IBLOCK_ID_PRODUCTS"],
        "CHECK_PERMISSIONS" => "Y",
        $propName => array_keys($catalog)
    ];
    $arProductsFields =
        ["ID", "NAME", "PROPERTY_COMPANIES", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL", "DETAIL_PAGE_URL"];
    $productsQ =
        CIBlockElement::GetList(false, $arProductsFilter, false, false, $arProductsFields);

    // формирование результируещего массива
    while($product = $productsQ->GetNext()) {
        $catalog[$product["PROPERTY_COMPANIES_VALUE"]]["products"][] = $product;
    }
    $arResult["TOTAL_CNT"] = count($catalog);
    $arResult["ITEMS"] = $catalog;
    $this->includeComponentTemplate();
}

$APPLICATION->SetTitle("Разделов: {$arResult["TOTAL_CNT"]}");