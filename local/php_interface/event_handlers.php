<?php

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", ["MyClass", "onBeforeElementUpdate"]);
AddEventHandler("main", "OnEpilog", ["MyClass", "onEpilog"]);

class MyClass
{
    public static function onBeforeElementUpdate(&$arParams)
    {
        if ($arParams["ACTIVE"] === "N") {
            $elem = CIBlockElement::GetByID($arParams["ID"])->Fetch();
            if ($elem["ACTIVE"] === "Y" && (int)$elem["SHOW_COUNTER"] > 2) {
                global $APPLICATION;
                $APPLICATION->throwException("Товар невозможно деактивировать, у него {$elem["SHOW_COUNTER"]} просмотров");
                return false;
            }
        }
    }

    public static function onEpilog()
    {
        if (constant('ERROR_404') === "Y") {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            CHTTP::SetStatus("404 Not Found");
            include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/header.php");
            include($_SERVER["DOCUMENT_ROOT"] . '/404.php');
            include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/footer.php");
            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "ERROR_404",
                "MODULE_ID" => "main",
                "DESCRIPTION" => "url страницы",
            ));
        }
    }
}