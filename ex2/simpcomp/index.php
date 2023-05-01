<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"ex2:simple.comp", 
	".default", 
	array(
		"CACHE_TIME" => "30000000",
		"CACHE_TYPE" => "A",
		"IBLOCK_ID_PRODUCTS" => "2",
		"IBLOCK_ID_PRODUCTS_CLASSIFIER" => "7",
		"PRODUCT_TO_CLASSIFIER_CODE" => "COMPANIES",
		"PRODUCT_URL_TEMPLATE" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>