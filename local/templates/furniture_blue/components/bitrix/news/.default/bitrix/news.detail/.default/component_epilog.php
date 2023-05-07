<?php
/** @var array $arResult */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

if ($request->get("isReport") === "Y") {
    global $USER;

    $login = $USER->IsAuthorized()
        ? "{$USER->GetID()} {$USER->GetFullName()} {$USER->GetLogin()}"
        : "Не авторизован";

    $arLoadReportArray = [
        "IBLOCK_ID" => 8,
        "NAME" => "{$login}_{$arResult["ID"]}_" . time(),
        "DATE_ACTIVE_FROM" => date("d.m.Y H:i:s", time()),
        "PROPERTY_VALUES" => [
            "USER" => $login,
            "NEWS" => $arResult["ID"]
        ]
    ];
    $el = new CIBlockElement;
    $result = "Ваше мнение учтено, №";
    if (!$reportId = $el->Add($arLoadReportArray)) {
        $result = "Ошибка";
    } else {
        $result .= $reportId;
    }

    if (!$request->get('isAjax')) {
        echo "
        <script>
            BX.ready(function () {
                const result = '{$result}';
                const elem = BX('report-msg');
                elem.style.color = result === 'Ошибка' ? 'red' : 'green';
                elem.innerText = result;
                BX.show(elem);
            })
        </script>";
    } else {
        $APPLICATION->RestartBuffer();
        echo $result;
        die();
    }
}