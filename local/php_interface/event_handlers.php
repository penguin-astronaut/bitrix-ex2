<?php

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", ["MyClass", "onBeforeElementUpdate"]);
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", ["MyClass", "onAfterElementUpdate"]);
AddEventHandler("main", "OnEpilog", ["MyClass", "onEpilog"]);

class MyClass
{
    public static function onBeforeElementUpdate(&$arParams)
    {
        $cancelDeactivateProductCount = 2;
        $productsBlockID = 2;

        if ($arParams["IBLOCK_ID"] === $productsBlockID && $arParams["ACTIVE"] === "N") {
            $elem = CIBlockElement::GetByID($arParams["ID"])->Fetch();
            if ($elem["ACTIVE"] === "Y" && (int)$elem["SHOW_COUNTER"] > $cancelDeactivateProductCount) {
                global $APPLICATION;
                $APPLICATION->throwException(
                    "Товар невозможно деактивировать, у него {$elem["SHOW_COUNTER"]} просмотров"
                );
                return false;
            }
        }
    }

    public static function onAfterElementUpdate(&$arParams)
    {
        if ($arParams["IBLOCK_ID"] === '3') {

            CBitrixComponent::clearComponentCache('ex2:simple.comp');
        }
    }

    public static function onEpilog()
    {
        global $APPLICATION;

        if (defined('ERROR_404') && constant('ERROR_404') === "Y") {
            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "ERROR_404",
                "MODULE_ID" => "main",
                "DESCRIPTION" => $APPLICATION->GetCurPage(),
            ));
        }

        if (CModule::IncludeModule("iblock")) {
            $arFilter = ["IBLOCK_ID" => 6, "NAME" => $APPLICATION->GetCurPage()];
            $selectedFields = ["PROPERTY_TITLE", "PROPERTY_DESCRIPTION"];
            $metaTagsQ = CIBlockElement::GetList(false, $arFilter, false, false, $selectedFields);
            if ($pageMetaTags = $metaTagsQ->Fetch()) {
                if ($pageMetaTags["PROPERTY_TITLE_VALUE"]) {
                    $APPLICATION->SetPageProperty("title", $pageMetaTags["PROPERTY_TITLE_VALUE"]);
                }
                if ($pageMetaTags["PROPERTY_DESCRIPTION_VALUE"]) {
                    $APPLICATION->SetPageProperty("description", $pageMetaTags["PROPERTY_DESCRIPTION_VALUE"]);
                }
            }
        }
    }
}
