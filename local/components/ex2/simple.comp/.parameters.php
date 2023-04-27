<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS"  =>  [
        "IBLOCK_ID_PRODUCTS"  =>  [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("EX2_SIMP_COMP_IBLOCK_ID_PRODUCTS"),
            "TYPE" => "STRING",
        ],
        "IBLOCK_ID_PRODUCTS_CLASSIFIER" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("EX2_SIMP_COMP_IBLOCK_ID_PRODUCTS_CLASSIFIER"),
            "TYPE" => "STRING",
        ],
        "PRODUCT_URL_TEMPLATE" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("EX2_SIMP_COMP_PRODUCT_URL_TEMPLATE"),
            "TYPE" => "STRING",
        ],
        "PRODUCT_TO_CLASSIFIER_CODE" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("EX2_SIMP_COMP_PRODUCT_TO_CLASSIFIER_CODE"),
            "TYPE" => "STRING",
        ],
        "CACHE_TIME" => Array("DEFAULT"=>30000000),
    ],
];