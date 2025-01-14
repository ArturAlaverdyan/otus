<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$APPLICATION->setTitle("Получение данных из таблицы и инфоблока");

\Bitrix\Main\Loader::includeModule('iblock');

$res = \Models\Tables\DocsTable::getList([
    'select' => [
        'ID' => 'ELEMENT.ID',
        'NAME' => 'ELEMENT.NAME',
        'IMYA',
        'FAMILIYA',
        'first_name' => 'CLIENT.first_name',
        'last_name' => 'CLIENT.last_name'
    ]
])->fetchAll();

$i = 1;
foreach ($res as $r)
{
    echo "<b>Инфоблок 1. Врач №".$i.'</b><br>';
    echo 'Имя: '.$r['IMYA'].' <br>';
    echo 'Фамилия: '.$r['FAMILIYA'].' <br>';
    echo 'Имя клиента из таблицы: '.$r['first_name'].' '.$r['last_name'].'<br>';
    $i++;
    echo '<br>';
}

echo '<br><br>';

$res2 = \Models\Tables\VisitTable::getList([
    'select' => [
        'ID' => 'ELEMENT.ID',
        'time_visit',
        'first_name' => 'CLIENT.first_name',
        'last_name' => 'CLIENT.last_name'
    ]
])->fetchAll();

$i = 1;

foreach ($res2 as $r)
{
    echo "<b>Инфоблок 2. Посещение №".$i.'</b><br>';
    echo 'Время: '.$r['time_visit'].' <br>';
    echo 'Имя клиента из таблицы: '.$r['first_name'].' '.$r['last_name'].'<br>';
    $i++;
    echo '<br>';
}

echo '<br><br>';

$hosp = \Models\Tables\HospitalTable::getList([
'select' => [
    '*',
    'IBLOCK.*',
    'IMYA'=>'IBLOCK.IMYA',
    'FAMILIYA'=>'IBLOCK.FAMILIYA',
    'IBLOCK2.time_visit'
]
])->fetchCollection();

$i = 1;
foreach ($hosp as $hc)
{
        echo "<b>Таблица. Клиент №".$i.'</b><br>';
        echo 'Имя: '.$hc->getFirstName().' <br>';
        echo 'Фамилия: '.$hc->getLastName().' <br>';
      echo 'Имя врача из инфоблока Врачи: '.$hc->get('IBLOCK')->get('IMYA')->getValue().' '.$hc->get('IBLOCK')->get('FAMILIYA')->getValue().'<br>';
    echo 'Время из инфоблока Посещение: '.$hc->get('IBLOCK2')->get('time_visit')->getValue().'<br>';

    $i++;
    echo '<br>';
}

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";