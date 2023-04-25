<?php

use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="content-block-inner">
    <h3><?= Loc::getMessage('CFT_LANG_CANGE')?></h3>
    <select name="site" onChange="location.href=this.value">
        <?php
    foreach ($arResult["SITES"] as $key => $arSite):
    ?>
        <option value="<?=$arSite['DIR']?>" <?=$arSite['CURRENT'] === "Y" ? 'selected' : '' ?>><?=$arSite['LANG']?></option>
    <?php
    endforeach;
    ?>
    </select>
</div>