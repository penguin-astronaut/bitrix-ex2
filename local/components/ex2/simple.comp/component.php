<?php

use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;

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
$arParams["CLASSIFIER_PAGE_COUNT"] = (int)$arParams["CLASSIFIER_PAGE_COUNT"] ?: 2;

$request = Context::getCurrent()->getRequest();
$isUseFilter = (bool)$request->get("F");

$arNavParams = [
    "nPageSize" => $arParams["CLASSIFIER_PAGE_COUNT"],
    "bShowAll" => false,
];
$arNavigation = CDBResult::GetNavParams($arParams["CLASSIFIER_PAGE_COUNT"]);

if (
    CModule::IncludeModule("iblock") &&
    ($isUseFilter || $this->startResultCache(false, [$USER->GetGroups(), $arNavigation]))
) {
    //классификаторы
    $arClassifiersFilter = ["IBLOCK_ID" => $arParams["IBLOCK_ID_PRODUCTS_CLASSIFIER"], "CHECK_PERMISSIONS" => "Y"];
    $arClassifiersFields = ["ID", "NAME"];
    $classifiersQ =
        CIBlockElement::GetList(false, $arClassifiersFilter, false, $arNavParams, $arClassifiersFields);
    $arResult["NAV_STRING"] = $classifiersQ->GetPageNavString(Loc::getMessage("EX2_SIMP_PAGINATION_TITLE"));

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
                ["<PROPERTY_PRICE" => 1500, "=PROPERTY_MATERIAL" => "Металл, пластик"],
            ],
        ];
        $this->abortResultCache();
    }

    $arProductsFields =
        ["ID", "NAME", "PROPERTY_COMPANIES", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL", "CODE", "IBLOCK_ID", "IBLOCK_SECTION_ID"];
    $productsQ =
        CIBlockElement::GetList($arProductsOrder, $arProductsFilter, false, false, $arProductsFields);

    $addedIds = [];
    $arResult["ADD_LINK"] = "";
    // формирование результируещего массива
    while ($product = $productsQ->GetNext()) {
        $product["DETAIL_PAGE_URL_CUSTOM"] = str_replace(
            ["#SECTION_ID#", "#ELEMENT_CODE#"],
            [$product["IBLOCK_SECTION_ID"], $product["CODE"]],
            $arParams["PRODUCT_URL_TEMPLATE"]
        );
        $arButtons = CIBlock::GetPanelButtons(
            $product["IBLOCK_ID"],
            $product["ID"],
            0,
            ["SECTION_BUTTONS" => false, "SESSID" => false]
        );
        $product["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
        $product["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
        $catalog[$product["PROPERTY_COMPANIES_VALUE"]]["products"][] = $product;

        if (empty($arResult["ADD_LINK"])) {
            $arResult["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
        }
    }

    $arResult["TOTAL_CNT"] = count($catalog);
    $arResult["ITEMS"] = $catalog;

    $this->includeComponentTemplate();
}

$APPLICATION->SetTitle("Разделов: {$arResult["TOTAL_CNT"]}");
