<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
Bitrix\Main\Loader::includeModule("iblock");

Bitrix\Iblock\Iblock::wakeUp(16)->getEntityDataClass();

$res = \Bitrix\Iblock\Elements\ElementcarsTable::getByPrimary(29,['select' => ['ID','list.ITEM']])->fetchObject();

print_r($res->Get('list')->getItem()->getValue());





require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";