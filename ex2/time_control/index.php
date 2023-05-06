<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оценка производительности");
?><b>ex2-88</b><br>
 Сама ресурсоёмкая страница&nbsp;<a href="http://exam2.loc/bitrix/admin/perfmon_hit_list.php?lang=ru&set_filter=Y&find_script_name=%2Fproducts%2Findex.php">/products/index.php</a>&nbsp;доля: 30%<br>
 Размер кеша по умолчанию: 25кб<br>
 Размер кеша с доп.данными: 27кб<br>
 <br>
 <b>ex2-10<br>
 </b>Сама ресурсоёмкая страница&nbsp;<a href="http://exam2.loc/bitrix/admin/perfmon_hit_list.php?lang=ru&set_filter=Y&find_script_name=%2Fproducts%2Findex.php">/products/index.php</a>&nbsp;доля:&nbsp;32.52%<br>
 Самый медленный компонент: bitrix:catalog:&nbsp;<nobr>0.955 с<br>
 </nobr><br>
 <b>ex2-10<br>
 </b>Сама ресурсоёмкая страница&nbsp;<a href="http://exam2.loc/bitrix/admin/perfmon_hit_list.php?lang=ru&set_filter=Y&find_script_name=%2Fproducts%2Findex.php">/products/index.php</a>&nbsp;доля:&nbsp;32.52%<br>
 Компонент с наибольшим количеством запросов:&nbsp;bitrix:catalog.section:&nbsp;<nobr>0.9373 с</nobr>;&nbsp;Запросов: 8 (0.0154 с)<nobr>;</nobr><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>