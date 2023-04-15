<?php
/** @var CBitrixComponent $this */
/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;

if (!Loader::includeModule("iblock")) {
    ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
    return;
}

$arParams["ID_IBLOCK_CATALOG"] = $arParams["ID_IBLOCK_CATALOG"] ?: 2;
$arParams["ID_IBLOCK_NEWS"] = $arParams["ID_IBLOCK_NEWS"] ?: 1;
$arParams["UF_NEWS_LINK"] = $arParams["ID_IBLOCK_NEWS"] ?: "UF_NEWS_LINK";

if ($this->StartResultCache()) {
    $news = CIBlockElement::GetList(
        [],
        ["ACTIVE" => "Y", "IBLOCK_ID" => $arParams["ID_IBLOCK_NEWS"]],
        false,
        false,
        ["NAME", "ACTIVE_FROM", "ID"]
    );
    $arNews = [];
    while ($curNews = $news->Fetch()) {
        $arNews[$curNews["ID"]] = $curNews;
    }

    $sections = CIBlockSection::GetList(
        [],
        ["ACTIVE" => "Y", "IBLOCK_ID" => $arParams["ID_IBLOCK_CATALOG"], $arParams["PROPERTY_CODE"] => array_keys($arNews)],
        false,
        ["NAME", "ID", $arParams["PROPERTY_CODE"]]
    );
    $arSections = [];
    while ($curSection = $sections->Fetch()) {
        $arSections[$curSection["ID"]] = $curSection;
    }

    $products = CIBlockElement::GetList(
        [],
        ["ACTIVE" => "Y", "IBLOCK_ID" => $arParams["ID_IBLOCK_CATALOG"], "SECTION_ID" => array_keys($arSections)],
        ["NAME", "ID", "IBLOCK_SECTION_ID", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL", "PROPERTY_PRICE"],
    );
    $arProducts = [];
    while ($curProduct = $products->Fetch()) {
        $arProducts[$curProduct["ID"]] = $curProduct;
    }

    foreach ($arProducts as $arProduct) {
        $productSection = $arSections[$arProduct["IBLOCK_SECTION_ID"]];
        $sectionNews = $productSection[$arParams["PROPERTY_CODE"]];
        foreach ($arNews as $arNew) {
            if (in_array($arNew["ID"], $sectionNews)) {
                $arResult["ITEMS"][$arNew["ID"]]["NEWS"] = $arNew;
                $arResult["ITEMS"][$arNew["ID"]]["PRODUCTS"][$arProduct["ID"]] = $arProduct;
                $arResult["ITEMS"][$arNew["ID"]]["SECTIONS"][$productSection["ID"]] = $productSection["NAME"];
            }
        }
    }

    $arResult["TOTAL_CNT"] = count($arProducts);

    $this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle("В каталоге товаров представлено товаров: {$arResult["TOTAL_CNT"]}");