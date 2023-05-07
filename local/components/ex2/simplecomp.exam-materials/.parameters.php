<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    "PARAMETERS" => [
        "NEWS_IBLOCK_ID" => [
            "NAME" => Loc::getMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
            "TYPE" => "STRING",
        ],
        "AUTHOR_PROPERTY_CODE" => [
            "NAME" => Loc::getMessage("AUTHOR_PROPERTY_CODE"),
            "TYPE" => "STRING",
        ],
        "AUTHOR_TYPE_PROPERTY_CODE" => [
            "NAME" => Loc::getMessage("AUTHOR_TYPE_PROPERTY_CODE"),
            "TYPE" => "STRING",
        ],
        "CACHE_TIME" => ["DEFAULT" => 36000000],
    ],
];
