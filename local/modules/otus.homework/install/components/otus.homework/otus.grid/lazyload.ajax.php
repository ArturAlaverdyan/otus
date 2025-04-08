<?php

declare(strict_types=1);

use Bitrix\Crm\Service\Container;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;


require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!CModule::IncludeModule('crm') || !CCrmSecurityHelper::IsAuthorized() || !check_bitrix_sessid()) {
    die();
}

$dealId = Application::getInstance()->getContext()->getRequest()->get('PARAMS')['params']['DEAL_ID'];

$APPLICATION->IncludeComponent(
    'otus.homework:otus.grid',
    '.default',
    [
        'dealId' => $dealId,
    ],
);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');
die();
