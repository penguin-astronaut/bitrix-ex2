<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Localization\Loc;

$arTemplateParameters["SET_PROP_SPECIAL_DATE"] = [
	"NAME" => Loc::getMessage("SET_PROP_SPECIAL_DATE"),
	"TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
];