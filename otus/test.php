<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$APPLICATION->setTitle("Компонент Валюта");

\Bitrix\Main\Loader::includeModule('iblock');
$data = \Bitrix\Iblock\Elements\ElementDoctorsTable::getByPrimary(55, [
    'select' => ['PROCEDURES_ID.ELEMENT'],
])->fetchObject();
$elArray = [];
foreach ($data->getProcedures_id()->getAll() as $el){
    echo $el->getElement()->getName();
}
//($elArray);

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";


?>