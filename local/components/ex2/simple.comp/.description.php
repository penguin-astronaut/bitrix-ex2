<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


$arComponentDescription = array(
    "NAME" => Loc::getMessage("EX2_SIMP_COMP_TITLE"),
    "DESCRIPTION" => Loc::getMessage("EX2_SIMP_COMP_DESCRIPTION"),
    "PATH" => [
        "ID" => "ex2",
        "NAME" => Loc::getMessage("EX2_SIMP_COMP_PATH"),
    ],
);