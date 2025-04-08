<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($request["first"] == '' || empty($request["second"]) || empty($request["third"]))
{
    header("Location: https://ca43694.tw1.ru/services/lists/18/view/0/?list_section_id=&error=1");
    die();
}

\Bitrix\Main\Loader::includeModule('iblock');
$newDate = date("d.m.Y", strtotime($request["second"])).' '.$request["third"].':00';
$dateNow = new DateTime('2025-03-01 12:54:00', new DateTimeZone('UTC'));
$check = CIBlockElement::GetList(
    $arOrder = Array("SORT"=>"ASC"),
    $arFilter = ["PROCED" => $request["four"], "=PROPERTY_WHEN" => $request["second"].' '.$request["third"].':00']
)->fetch();

if (!empty($check['ID']))
{
    header("Location: https://ca43694.tw1.ru/services/lists/18/view/0/?list_section_id=&error=2");
    die();
}
else {
    $PROP = [
        'FIO' => $request["first"],
        'WHEN' => $newDate,
        'PROCED' => $request["four"]
    ];

    $el = new CIBlockElement;
    $arLoadProductArray = array(
        "ACTIVE_FROM" => date('d.m.Y H:i:s'),
        "IBLOCK_ID" => 29,
        "NAME" => "Запись",
        "ACTIVE" => "Y",
        "CODE" => "record",
        "PROPERTY_VALUES" => $PROP,
        "SORT" => 100,
    );
    if ($newElement = $el->Add($arLoadProductArray)) {
        header("Location: https://ca43694.tw1.ru/services/lists/29/view/0/?list_section_id=");
    }
}
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";