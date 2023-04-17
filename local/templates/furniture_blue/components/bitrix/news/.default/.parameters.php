<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$arTemplateParameters = [
    "ID_IBLOCK_CANONICAL" => [
        "NAME" => Loc::getMessage("ID_IBLOCK_CANONICAL_NAME"),
        "TYPE" => "STRING",
    ],
];