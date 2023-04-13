<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!$arResult["ITEMS"] || !$arParams["SET_PROP_SPECIAL_DATE"]) {
    return;
}

$cp = $this->__component;

$arResult["SPECIALDATE"] = $arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"];
$cp->setResultCacheKeys(["SPECIALDATE"]);