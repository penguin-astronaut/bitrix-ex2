<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

$arTemplateParameters["SET_PROP_REPORT_AJAX"] = [
    "NAME" => Loc::getMessage("SET_PROP_REPORT_AJAX"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "PARENT" => "AJAX_SETTINGS",
];