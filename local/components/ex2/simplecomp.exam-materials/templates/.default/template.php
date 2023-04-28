<?php

/** @var array $arResult */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<ul>
<?php foreach ($arResult["ITEMS"] as $item): ?>
    <li><b>[<?=$item["AUTHOR"]["ID"]?>] <?=$item["AUTHOR"]["LOGIN"]?></b></li>
    <ul>
        <?php foreach ($item["NEWS"] as $news): ?>
            <li><?=$news["NAME"]?></li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
</ul>