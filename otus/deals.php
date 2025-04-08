<?php
use \Bitrix\Main\Loader;
use \Bitrix\Crm\Service\Container;

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$APPLICATION->setTitle("Отладка примера");

Loader::includeModule("crm");

//$dealFactory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
$dealFactory = \Bitrix\CRM\DealTable::getFactory();

$dealItems = $dealFactory->getItems([
    "order" => ["TITLE" => "ASC"],
    "filter" => [],
    "select" => ['TITLE']
]);

foreach ($dealItems as $item)
{
    echo $item->get('TITLE').' ';
}



require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";