<?php
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<h3><?=Loc::GetMessage("COMPONENT_TITLE");?> - <?=$arResult["TOTAL_CNT"]?></h3>
----
<p><b><?=Loc::GetMessage("COMPONENT_LIST_TITLE");?>:</b></p>
<ul>
<?php foreach ($arResult["ITEMS"] as $item):?>
    <li>
        <b><?=$item["NEWS"]["NAME"]?></b> -
        <?=$item["NEWS"]["ACTIVE_FROM"]?>
        (<?=implode(", ", $item["SECTIONS"])?>)
    </li>
    <br>
    <ul>
        <?php foreach ($item["PRODUCTS"] as $product):?>
            <li>
                <?=
                    $product["NAME"] . " - "  .
                    $product["PROPERTY_PRICE_VALUE"] . " - " .
                    $product["PROPERTY_MATERIAL_VALUE"] . " - " .
                    $product["PROPERTY_ARTNUMBER_VALUE"]
                ?>
            </li>
        <?php endforeach;?>
    </ul>
    <br>
<?php endforeach;?>
</ul>

<?php $this->SetViewTarget("price_block");?>
<div style="color:red; margin: 34px 15px 35px 15px">
    <p><?=Loc::GetMessage("BLOCK_MAX_PRICE");?>: <?=$arResult["PRODUCT_MAX_PRICE"]?></p>
    <p><?=Loc::GetMessage("BLOCK_MIN_PRICE");?>: <?=$arResult["PRODUCT_MIN_PRICE"]?></p>
</div>
<?php $this->EndViewTarget();?>
