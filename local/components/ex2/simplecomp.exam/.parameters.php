<?php

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "ID_IBLOCK_CATALOG" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "",
        ],
        "ID_IBLOCK_NEWS" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "",
        ],
        "PROPERTY_CODE" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("SIMPLECOMP_EXAM2_PROPERTY_CODE"),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "",
        ],
        "CACHE_TIME" => ["DEFAULT" => 36000000],
    ],
];