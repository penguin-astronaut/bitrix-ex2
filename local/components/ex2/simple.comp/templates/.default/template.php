<?php
/** @var array $arResult */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

---
<p><a href="/ex2/simpcomp/?F=Y">/ex2/simpcomp/?F=Y</a></p>
<h3>Каталог</h3>
<ul>
    <?php foreach ($arResult["ITEMS"] as $classifier):?>
        <li><b><?=$classifier["name"]?></b></li>
        <ul>
            <?php foreach ($classifier["products"] as $product):?>
                <?php
                $id = "{$classifier["name"]}-{$product['ID']}";
                $this->AddEditAction($id, $product['EDIT_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($id, $product['DELETE_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"], "ELEMENT_DELETE"), ["CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                ?>
                <li id="<?=$this->GetEditAreaId($id);?>">
                    <?=$product["NAME"]?> -
                    <?=$product["PROPERTY_PRICE_VALUE"]?> -
                    <?=$product["PROPERTY_MATERIAL_VALUE"]?> -
                    <?=$product["PROPERTY_ARTNUMBER_VALUE"]?>
                    <span><?=$product['DETAIL_PAGE_URL_CUSTOM']?></span>
                </li>
            <?php endforeach;?>
        </ul>
    <?php endforeach;?>
</ul>

