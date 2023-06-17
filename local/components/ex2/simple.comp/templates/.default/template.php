<?php

/** @var array $arResult */
/** @var array $arParams */

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>
---
<p><?= Loc::getMessage("SIMP_COMP_TEMPLATE_TIMESTAMP") ?> <?= time() ?></p>
---
<p><a href="/ex2/simpcomp/?F=Y">/ex2/simpcomp/?F=Y</a></p>
<h3><?= Loc::getMessage("SIMP_COMP_TEMPLATE_TITLE") ?></h3>
<?php
$this->AddEditAction("ELEMENT_ADD", $arResult['ADD_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID_PRODUCTS"], "ELEMENT_ADD"));
?>
<ul id="<?= $this->GetEditAreaId("ELEMENT_ADD"); ?>">
    <?php foreach ($arResult["ITEMS"] as $classifier) : ?>
        <li><b><?= $classifier["name"] ?></b></li>
        <ul>
            <?php foreach ($classifier["products"] as $product) : ?>
                <?php
                $id = "{$classifier["name"]}-{$product['ID']}";
                $this->AddEditAction($id, $product['EDIT_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($id, $product['DELETE_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"], "ELEMENT_DELETE"), ["CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                ?>
                <li id="<?= $this->GetEditAreaId($id); ?>">
                    <?= $product["NAME"] ?> -
                    <?= $product["PROPERTY_PRICE_VALUE"] ?> -
                    <?= $product["PROPERTY_MATERIAL_VALUE"] ?> -
                    <?= $product["PROPERTY_ARTNUMBER_VALUE"] ?>
                    <span><?= $product['DETAIL_PAGE_URL_CUSTOM'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</ul>
<div>
    <?= $arResult["NAV_STRING"] ?>
</div>