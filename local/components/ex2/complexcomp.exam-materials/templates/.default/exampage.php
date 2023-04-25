<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult*/

$param2 = $arResult["VARIABLES"]["PARAM2"] ?? 'Параметр не опредлен';

echo "PARAM1 = {$arResult["VARIABLES"]["PARAM1"]} <br>";
echo "PARAM2 = $param2";