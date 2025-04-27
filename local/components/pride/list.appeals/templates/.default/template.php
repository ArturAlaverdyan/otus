<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php 
if ($arResult["BUTTON_CREATE"] == 'Y') 
{
    \Bitrix\UI\Toolbar\Facade\Toolbar::addButton([
        "classList" => ["ui-btn ui-btn-success"],
        "link" => $arResult['APPEAL_ADD'],
        "text" => "Добавить"
    ]);
}
\Bitrix\UI\Toolbar\Facade\Toolbar::addButton([
    "classList" => ["ui-btn ui-btn-primary"],
	"link" => "/services",
	"text" => "Список документов"
]);
$grid_options = new Bitrix\Main\Grid\Options('PRIDE');
$sort = $grid_options->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
$nav_params = $grid_options->GetNavParams();

$nav = new Bitrix\Main\UI\PageNavigation('PRIDE');
$nav->allowAllRecords(true)
    ->setPageSize($nav_params['nPageSize'])
    ->initFromUri();

 
$APPLICATION->includeComponent(
    "bitrix:main.ui.grid",
    "",
    [
        "GRID_ID" => "PRIDE",
        "COLUMNS" => $arResult['COLUMNS'],
        "ROWS" => $arResult['ROWS'],
        'PAGE_SIZES' => [
            ['NAME' => "5", 'VALUE' => '5'],
            ['NAME' => '10', 'VALUE' => '10'],
            ['NAME' => '20', 'VALUE' => '20'],
            ['NAME' => '50', 'VALUE' => '50'],
            ['NAME' => '100', 'VALUE' => '100']
        ],
        'AJAX_MODE' => 'Y', 
        'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
        'NAV_OBJECT' => $nav,
        'AJAX_OPTION_JUMP'          => 'N', 
        'SHOW_CHECK_ALL_CHECKBOXES' => false, 
        "SHOW_ROW_CHECKBOXES" => false,
        'SHOW_ROW_ACTIONS_MENU'     => false, 
        'SHOW_GRID_SETTINGS_MENU'   => false, 
        'SHOW_NAVIGATION_PANEL'     => true, 
        'SHOW_PAGINATION'           => true, 
        'SHOW_SELECTED_COUNTER'     => false, 
        'SHOW_TOTAL_COUNTER'        => false, 
        'SHOW_PAGESIZE'             => true, 
        'SHOW_ACTION_PANEL'         => false, 
        'ALLOW_COLUMNS_SORT'        => false, 
        'ALLOW_COLUMNS_RESIZE'      => true, 
        'ALLOW_HORIZONTAL_SCROLL'   => true, 
        'ALLOW_SORT'                => false, 
        'ALLOW_PIN_HEADER'          => true, 
        'AJAX_OPTION_HISTORY'       => 'N' 
    ]
);
?>