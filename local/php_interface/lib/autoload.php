<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    // ключ - имя класса с простанством имен, значение - путь относительно корня сайта к файлу
    'Classes\Diagnostic\Helper' => '/local/php_interface/lib/classes/diagnostic/helper.php',
    'Classes\Diagnostic\OtusFileExceptionHandlerLog' => '/local/php_interface/lib/classes/diagnostic/otusfileexceptionhandlerlog.php',
    'Models\Cars' => '/local/models/carsfield.php',
    'Models\Tables\CarsTable' => '/local/models/tables/carstable.php',
    'Models\AbstractIblockPropertyValuesTable' => '/local/models/AbstractIblockPropertyValuesTable.php',
    'Models\Tables\ClientsTable' => '/local/models/tables/clientstable.php',
    'Models\Tables\DoctorsTable' => '/local/models/tables/doctorstable.php',
    'Models\Tables\ProceduresTable' => '/local/models/tables/procedurestable.php',
    'Models\Tables\HospitalTable' => '/local/models/tables/hospital_clients.php',
    'Models\Tables\DocsTable' => '/local/models/tables/docs.php',
    'Models\Tables\VisitTable' => '/local/models/tables/visittable.php',
    'UserTypes\FormatTelegramLink' => '/local/php_interface/lib/classes/tgtype.php',
    'UserTypes\IBLink' => '/local/php_interface/lib/classes/IBLink.php',
    'Otus\Events\Update' => '/local/events/update.php',
    'Dadata' => '/local/php_interface/lib/classes/dadata.php'
]);

