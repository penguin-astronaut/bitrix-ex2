<?php
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

if (!(int)$arParams["ID_IBLOCK_CANONICAL"]) {
    return;
}

$arFilter = ['IBLOCK_ID' => $arParams["ID_IBLOCK_CANONICAL"], "PROPERTY_NEWS" => $arParams["ELEMENT_ID"]];
$elements = CIBlockElement::GetList(false, $arFilter);

if ($element = $elements->Fetch()) {
    $APPLICATION->SetPageProperty("canonical", $element["NAME"]);
}
