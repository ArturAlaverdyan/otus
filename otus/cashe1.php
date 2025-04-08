<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";

$APPLICATION->setTitle("Отладка примера");

$arElements = \Bitrix\Iblock\ElementTable::getList([
    'select' => ['ID'],
    'filter' => ['IBLOCK_ID' => 18, 'ACTIVE' => 'Y'],
    'limit' => 4,
    'cache' => [
        'ttl' => 3600,
        'cashe_joins' => true
    ]
])->fetchAll();

var_dump($arElements);



//настройки времени кеширования таблиц в /bitrix/.settings.php



require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";