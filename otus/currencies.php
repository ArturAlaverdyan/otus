<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$APPLICATION->setTitle("Компонент Валюта");

$APPLICATION->IncludeComponent(
	"otus:currencies", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CURRENCIES" => "RUB"
	),
	false
);



require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";


?>