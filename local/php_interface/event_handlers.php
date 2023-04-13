<?php

AddEventHandler("main", "OnBeforeEventAdd", ["EventHandlers", "BeforeSend"]);
class EventHandlers
{
    public function BeforeSend($event, $lid, &$arFields)
    {
        if ($event !== "FEEDBACK_FORM") {
            return;
        }

        global $USER;
        $arFields["AUTHOR"] = $USER->IsAuthorized()
            ? "Пользователь авторизован: {$USER->GetID()} ({$USER->GetLogin()}) {$USER->GetFullName()}, "
                . "данные из формы: {$arFields["AUTHOR"]}"
            : "Пользователь не авторизован, данные из формы: {$arFields["AUTHOR"]}";

        CEventLog::Add(array(
                'SEVERITY' => 'INFO',
                'AUDIT_TYPE_ID' => 'FEEDBACK_AUTHOR_RENAME_INFO',
                'MODULE_ID' => 'main',
                'DESCRIPTION' => "Замена данных в отсылаемом письме – {$arFields["AUTHOR"]}",
            )
        );
    }
}