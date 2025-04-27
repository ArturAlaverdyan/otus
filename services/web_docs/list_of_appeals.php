<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$APPLICATION->setTitle("Компонент Валюта");
?>

<? $APPLICATION->IncludeComponent(
	"pride:list.appeals",
	"",
	Array(),
	false
);
?>

<?
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";
?>