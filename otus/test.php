<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$APPLICATION->setTitle("Компонент Валюта");
?>

<? $APPLICATION->IncludeComponent(
	"pride:web.docs",
	".default",
	Array(
	),
	false
);?>

<?
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";
?>