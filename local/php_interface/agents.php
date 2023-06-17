<?php

function CheckUserCount(): ?string
{
    $lastTimeStart = COption::GetOptionString("main", "countUsersRegisterForPeriod_time");
    $now = new DateTime();

    $nowFormatted = $now->format('d.m.Y H:i:s');

    if (!$lastTimeStart) {
        COption::SetOptionString("main", "countUsersRegisterForPeriod_time", $nowFormatted);
        return __METHOD__ . "();";
    }

    $arUsers = Bitrix\Main\UserTable::getList([
        'select' => [
            'ID', 'DATE_REGISTER'
        ],
        'filter' => [
            '>DATE_REGISTER' => $lastTimeStart,
        ],
        'count_total' => true,
    ]);

    $newUsersCount = $arUsers->getCount();

    $admins = CUser::GetList(false, false, ["GROUPS_ID" => [1]]);
    $adminsEmails = [];
    while ($admin = $admins->Fetch()) {
        $adminsEmails[] = $admin["EMAIL"];
    }

    DateTime::createFromFormat('d.m.Y H:i:s', $lastTimeStart);
    $period = date_diff(DateTime::createFromFormat('d.m.Y H:i:s', $lastTimeStart), $now);

    CEvent::Send(
        "NEW_USERS_REGISTER_PERIOD",
        "s1",
        [
            "COUNT" => $newUsersCount,
            "PERIOD" => $period->d,
            "EMAIL_TO" => implode(",", $adminsEmails)
        ]
    );

    COption::SetOptionString("main", "countUsersRegisterForPeriod_time", $nowFormatted);

    return __METHOD__ . "();";
}
