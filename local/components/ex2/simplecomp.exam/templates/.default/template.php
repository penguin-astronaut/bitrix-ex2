<?php
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<h3>Элеметнов - <?=$arResult["TOTAL_CNT"]?></h3>
----
<p><b>Каталог:</b></p>
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
    <p>Максимальная цена: <?=$arResult["PRODUCT_MAX_PRICE"]?></p>
    <p>Минимальная цена: <?=$arResult["PRODUCT_MIN_PRICE"]?></p>
</div>
<?php $this->EndViewTarget();?>
