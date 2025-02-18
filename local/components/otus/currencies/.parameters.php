<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
    return;

$arComponentParameters = array(
    "GROUPS" => array(
        "LIST"=>array(
            "NAME"=>"Параметры",
            "SORT"=>"100"
        )
    ),
    "PARAMETERS" => array(
        "CURRENCIES" =>  array(
            "PARENT" => "LIST",
            "NAME"=>"Валюта для вывода",
            "TYPE"=>"LIST",
            "VALUES"=>['RUB'=>'Российский рубль','USD'=>'Доллар','EUR'=>'Евро','UAH'=>'Гривна','BYN'=>'Беллоруский рубль'],
            "DEFAULT"=>"RUB"
        )
    )
);


