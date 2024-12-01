<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    // ключ - имя класса с простанством имен, значение - путь относительно корня сайта к файлу
    'Classes\Diagnostic\Helper' => '/local/php_interface/lib/classes/diagnostic/helper.php',
    'Classes\Diagnostic\OtusFileExceptionHandlerLog' => '/local/php_interface/lib/classes/diagnostic/otusfileexceptionhandlerlog.php'
]);
/*
spl_autoload_register(function(string $class): void
{
    if(!str_contains($class, 'classes'))
    {
        return;
    }

    $class = str_replace('\\','/');
    $path = __DIR__.$class.'.php';

    if (is_file($path))
    {
        require_once $path;
    }

}
);
*/
