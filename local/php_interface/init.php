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
