<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$APPLICATION->setTitle("Тесты");
\Bitrix\Main\Loader::includeModule('iblock');
//\Bitrix\Iblock\Iblock::wakeUp(16)->getEntityDataClass();
//\Bitrix\Iblock\Iblock::wakeUp(17)->getEntityDataClass();

/*
$res = \Bitrix\Iblock\Elements\ElementcarsTable::getByPrimary(29, [
    // сортировка
    'order' => array('SORT' => 'ASC'),
    // выбираемые поля без свойств, свойства можно получать только при обращении к ORM классу, конкретного инфоблока
    'select' => array('ID', 'NAME', 'IBLOCK_ID','stroka'),
    // фильтр только по полям элемента
    'filter' => array('IBLOCK_ID' => 16)
    // группировка по полю, order должен быть пустой
]);
*/

$n = Models\Tables\CarsTable::query()
    ->setSelect([
        '*',
        'NAME111111' => 'ELEMENT.NAME',
        'CLIENT_NAME' => 'CLIENTS.ELEMENT.NAME'
    ])
    ->fetchAll();

    print_r($n);

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";