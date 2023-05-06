<?php

function countUsersRegisterForPeriod(): ?string
{
    $lastTimeStart = COption::GetOptionInt("main", "countUsersRegisterForPeriod_time");
    if (!$lastTimeStart) {
        COption::SetOptionInt("main", "countUsersRegisterForPeriod_time", time());
        return "countUsersRegisterForPeriod();";
    }

    $newUsers = CUser::GetList(false, false, ["DATE_REGISTER_1" => date("d.m.Y", $lastTimeStart)]);
    $newUsersCount = $newUsers ? $newUsers->SelectedRowsCount() : 0;

    $admins = CUser::GetList(false, false, ["GROUPS_ID" => [1]]);
    $adminsEmails = [];
    while ($admin = $admins->Fetch()) {
        $adminsEmails[] = $admin["EMAIL"];
    }
    $period = floor((time() - $lastTimeStart)/(60*60*24));

    CEvent::Send(
        "NEW_USERS_REGISTER_PERIOD",
        "s1",
        [
            "COUNT" => $newUsersCount,
            "PERIOD" => $period,
            "EMAIL_TO" => implode(",", $adminsEmails)
        ]
    );
    COption::SetOptionInt("main", "countUsersRegisterForPeriod_time", time());
    return "countUsersRegisterForPeriod();";
}