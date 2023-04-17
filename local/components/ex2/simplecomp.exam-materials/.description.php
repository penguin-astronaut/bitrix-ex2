<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = [
	"NAME" => Loc::getMessage("SIMPLECOMP_EXAM2_NAME"),
	"PATH" => [
		"ID" => "exam2",
        "NAME" => Loc::getMessage("SIMPLECOMP_EXAM2_PATH")
	],
];