<?php

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock,
    Bitrix\Main\Localization\Loc;

if (!Loader::includeModule("iblock")) {
	ShowError(Loc::getMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (!$USER->IsAuthorized()) {
    $this->includeComponentTemplate();
}

$arUser = CUser::GetByID($USER->GetID())->Fetch();

if ($this->StartResultCache()) {
    $authorFilter = [
        $arParams["AUTHOR_TYPE_PROPERTY_CODE"] => $arUser[$arParams["AUTHOR_TYPE_PROPERTY_CODE"]],
    ];
    $authors = CUser::GetList('', '', $authorFilter, ["FIELDS" => ["ID", "LOGIN"]]);

    $arAuthors = [];
    while ($author = $authors->Fetch()) {
        $arAuthors[$author["ID"]] = $author;
    }

    $authorProp = "PROPERTY_" . $arParams["AUTHOR_PROPERTY_CODE"];
    $newsFilter = [
        "IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
        $authorProp => array_keys($arAuthors)
    ];
    $selectedFields = [$authorProp , "ID", "NAME"];
    $news = CIBlockElement::GetList(false, $newsFilter, false, false, $selectedFields);
    $arNews = [];
    while ($n = $news->Fetch()) {
        if (!in_array($n["ID"], $arNews)) {
            $arNews[$n["ID"]]["NEWS"] = $n;
        }
        $arNews[$n["ID"]]["AUTHORS"][$n["PROPERTY_AUTHOR_VALUE"]] = $arAuthors[$n["PROPERTY_AUTHOR_VALUE"]];
    }

    $arResult["TOTAL_NEWS_CNT"] = 0;
    foreach ($arNews as $arNew) {
        if (in_array($USER->GetID(), array_keys($arNew["AUTHORS"]))) {
            continue;
        }
        $arResult["TOTAL_NEWS_CNT"] += 1;
        foreach ($arNew["AUTHORS"] as $author) {
            $arResult["ITEMS"][$author["ID"]]["AUTHOR"] = $author;
            $arResult["ITEMS"][$author["ID"]]["NEWS"][$arNew["NEWS"]["ID"]] = $arNew["NEWS"];
        }
    }

    $this->includeComponentTemplate();
}
