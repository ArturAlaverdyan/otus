<?php
namespace Classes\Diagnostic;
use Bitrix\Main\Diag\FileExceptionHandlerLog;
use Bitrix\Main\Diag\ExceptionHandlerFormatter;

class OtusFileExceptionHandlerLog extends FileExceptionHandlerLog
{
    public static function test()
    {
        return 9;
    }
    public function write($exception, $logType){

        $text = ExceptionHandlerFormatter::format($exception, false, $this->level);

        $context = [
            'type' => static::logTypeToString($logType),
        ];

        $logLevel = static::logTypeToLevel($logType);

        $message = "\n {date} - Host: {host} - {type} - {$text}\n";

        $message = preg_replace('#\n#',"\n OTUS ", $message);

        $this->logger->log($logLevel, $message, $context);

    }

}