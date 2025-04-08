<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$list = array(
    [
        'data'    => [ //Данные ячеек
            "ID" => $arResult['ITEM']->getId(),
            "NAME" => $arResult['ITEM']->getTitle(),
        ],
    ]);

$nav = new \Bitrix\Main\UI\PageNavigation('CURRENCY');
$nav->allowAllRecords(true)
    ->setPageSize('1')
    ->initFromUri();


$APPLICATION->includeComponent(
    "bitrix:main.ui.grid",
    "",
    [
        "GRID_ID" => "DEAL",
        "COLUMNS" => [
            ['id' => 'ID', 'name' => 'ID сделки', 'sort' => '1', 'default' => true],
            ['id' => 'NAME', 'name' => 'Название', 'sort' => '1', 'default' => true],

        ],
        "ROWS" => $list,
        'PAGE_SIZES' => [
            ['NAME' => "5", 'VALUE' => '5'],
            ['NAME' => '10', 'VALUE' => '10'],
            ['NAME' => '20', 'VALUE' => '20'],
            ['NAME' => '50', 'VALUE' => '50'],
            ['NAME' => '100', 'VALUE' => '100']
        ],
        'AJAX_OPTION_JUMP'          => 'N',
        'NAV_OBJECT' => $nav,
        'SHOW_ROW_CHECKBOXES' => false,
        'SHOW_CHECK_ALL_CHECKBOXES' => false,
        'SHOW_ROW_ACTIONS_MENU'     => true,
        'SHOW_GRID_SETTINGS_MENU'   => true,
        'SHOW_NAVIGATION_PANEL'     => true,
        'SHOW_PAGINATION'           => true,
        'SHOW_SELECTED_COUNTER'     => false,
        'SHOW_TOTAL_COUNTER'        => true,
        'SHOW_PAGESIZE'             => true,
        'SHOW_ACTION_PANEL'         => true,
        'ALLOW_COLUMNS_SORT'        => true,
        'ALLOW_COLUMNS_RESIZE'      => true,
        'ALLOW_HORIZONTAL_SCROLL'   => true,
        'ALLOW_SORT'                => true,
        'ALLOW_PIN_HEADER'          => true,
        'AJAX_OPTION_HISTORY'       => 'N'
    ]
);

?>