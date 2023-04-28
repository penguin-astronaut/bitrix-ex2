<?php

AddEventHandler("main", "OnBuildGlobalMenu", ["EventHandlers", "OnBuildGlobalMenu"]);
class EventHandlers
{
    public function OnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
    {
        global $USER;
        $contentManagersGroupID = 5;
        if (!$USER->IsAdmin() && !in_array($contentManagersGroupID, $USER->GetUserGroupArray())) {
            foreach ($aModuleMenu as $item) {
                if ($item["text"] === "Новости") {
                    $aModuleMenu = [$item];
                    break;
                }
            }

            $aGlobalMenu = [
                "global_menu_content" => $aGlobalMenu["global_menu_content"]
            ];
        }
    }
}