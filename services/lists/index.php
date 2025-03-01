<?php
/**
 * @global  \CMain $APPLICATION
 */
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/intranet/public/services/lists/index.php');
$APPLICATION->SetTitle(GetMessage('SERVICES_TITLE'));

$APPLICATION->IncludeComponent(
	'bitrix:lists',
	'.default',
	[
		'IBLOCK_TYPE_ID' => 'lists',
		'SEF_MODE' => 'Y',
		'SEF_FOLDER' => SITE_DIR.'services/lists/',
		'CACHE_TYPE' => 'A',
		'CACHE_TIME' => '36000000',
		'SEF_URL_TEMPLATES' => [
			'lists' => '',
			'list' => '#list_id#/view/#section_id#/',
			'list_sections' => '#list_id#/edit/#section_id#/',
			'list_edit' => '#list_id#/edit/',
			'list_fields' => '#list_id#/fields/',
			'list_field_edit' => '#list_id#/field/#field_id#/',
		]
	],
	false
);

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
if ($request["error"] == '1')
{
    $request->modifyByQueryString('&error=2');
    $result = '<script>alert("Вы не ввели все данные");
window.location.href = "/services/lists/18/view/0/?login=yes&list_section_id";</script>';
}
if ($request["error"] == '2')
{
    $request->modifyByQueryString('error=0');
    $result = '<script>alert("Это время уже забронировано в процедуре");
window.location.href = "/services/lists/18/view/0/?login=yes&list_section_id";</script>';
}
echo $result;

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');