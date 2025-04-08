<?php
define('DEBUG_FILE_NAME', $_SERVER["DOCUMENT_ROOT"] .'/logs/'.date("Y-md").'.log');
if (file_exists(__DIR__.'/lib/autoload.php'))
{
    require_once(__DIR__.'/lib/autoload.php');
}

if (file_exists(__DIR__.'/vendor/autoload.php'))
{
    require_once(__DIR__.'/vendor/autoload.php');
}

if (file_exists(__DIR__.'/vendor/autoload.php'))
{
    require_once(__DIR__.'/vendor/autoload.php');
}

\Bitrix\Main\UI\Extension::load(['popup', 'crm.currency', 'timeman.custom']);
\Bitrix\Main\UI\Extension::load(['main.footer_edit']);

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->AddEventHandler(
    'main',
    'OnUserTypeBuildList',
    [
        'UserTypes\FormatTelegramLink', // класс обработчик пользовательского типа UF поля
        'GetUserTypeDescription'
    ]
);

$eventManager->AddEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    [
        'UserTypes\IBLink', // класс обработчик пользовательского типа свойства
        'GetUserTypeDescription'
    ]
);

$eventManager->AddEventHandler(
    'iblock',
    'OnAfterIBlockElementUpdate',
    [
        'Otus\Events\Update', // класс при изенении элемента
        'updateDeal'
    ]
);

$eventManager->AddEventHandler(
    'crm',
    'OnAfterCrmDealUpdate',
    [
        'Otus\Events\Update', // класс при изменении сделки
        'updateElement'
    ]
);