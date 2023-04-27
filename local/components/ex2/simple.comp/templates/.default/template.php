<?php
/** @var array $arResult */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

---

<h3>Каталог</h3>
<ul>
    <?php foreach ($arResult["ITEMS"] as $classifier):?>
        <li><b><?=$classifier["name"]?></b></li>
        <ul>
            <?php foreach ($classifier["products"] as $product):?>
                <li>
                    <?=$product["NAME"]?> -
                    <?=$product["PROPERTY_PRICE_VALUE"]?> -
                    <?=$product["PROPERTY_MATERIAL_VALUE"]?> -
                    <?=$product["PROPERTY_ARTNUMBER_VALUE"]?>
                    <a href="<?=$product['DETAIL_PAGE_URL']?>">ссылка</a>
                </li>
            <?php endforeach;?>
        </ul>
    <?php endforeach;?>
</ul>

