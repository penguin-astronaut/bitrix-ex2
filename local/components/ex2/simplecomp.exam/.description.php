<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    "NAME" => Loc::getMessage("SIMPLECOMP_EXAM2_NAME"),
    "DESCRIPTION" => Loc::getMessage("SIMPLECOMP_EXAM2_DESCR"),
    "PATH" => array(
        "ID" => "ex2",
        "NAME" => Loc::getMessage("SIMPLECOMP_EXAM2_PATH")
    ),
);