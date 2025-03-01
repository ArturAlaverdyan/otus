<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => 'otushome',
    "DESCRIPTION" =>  'То что в сделке',
    "SORT" => 20,
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "otushome",
        "CHILD" => array(
            "ID" => "table",
            "NAME" => 'в сделке',
            "SORT" => 10,
            "CHILD" => array(
                "ID" => "views",
            ),
        ),
    ),
);

?>