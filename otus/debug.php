<?php
namespace Bitrix\Main\Diag;
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";

$APPLICATION->setTitle("Отладка примера");
print_r('Привет, сейчас <b>'.date('Y-m-d H:i:s').'</b> вы можете увидеть эту дату в файле <i>logs/my_logs.log</i>');
Debug::writeToFile(date('Y-m-d H:i:s'), "Function Date", '/logs/my_logs.log');
print_r(\Classes\Diagnostic\OtusFileExceptionHandlerLog::testr()); // ДЛЯ ВЫВЕДЕНИЯ В ЛОГАХ ОШИБКИ



require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";