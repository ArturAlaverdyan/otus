<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Сервисы');
?>
<? $APPLICATION->IncludeComponent(
	"pride:web.docs",
	"",
	Array(),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>