<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => 'Обращения (форма pride)',
    "DESCRIPTION" =>  'Обращения (форма pride)',
    "SORT" => 20,
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "appealPride",
        "CHILD" => array(
            "ID" => "tableappeal",
            "NAME" => 'Обращение',
            "SORT" => 10,
            "CHILD" => array(
                "ID" => "viewsappeal",
            ),
        ),
    ),
);

?>