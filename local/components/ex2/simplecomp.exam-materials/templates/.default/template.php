<?php

/** @var array $arResult */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?> - <?=$arResult["TOTAL_NEWS_CNT"]?></b></p>
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