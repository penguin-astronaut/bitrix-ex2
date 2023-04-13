<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["SPECIALDATE"]) {
    $APPLICATION->SetPageProperty("specialdate", $arResult["SPECIALDATE"]);
}