<?php
namespace Otus\Events;

class Update {

    public static function updateDeal (&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == '30') {
            \Bitrix\Main\Loader::includeModule('iblock');
            \Bitrix\Main\Loader::includeModule('crm');
            $el = \CIBlockElement::GetProperty(
                $arFields['IBLOCK_ID'],
                $arFields['ID'],
            );

            $newArr = [];
            while ($e = $el->GetNext()) {
                $newArr[$e['CODE']] = $e['VALUE'];
            }

            $dealOrder = [
                'ID' => 'ASC',
            ];
            $dealFilterFields = [
                'ID' => $newArr['DEAL_ID'],
            ];
            $deal = \CCrmDeal::GetList(
                $dealOrder,
                $dealFilterFields,
            )->fetch();

            if (!empty($deal) && ($deal['OPPORTUNITY'] != $newArr['SUMMA'] || $deal['ASSIGNED_BY_ID'] != $newArr['OTVET']))
            {
                $deal = new \CCrmDeal(false);
                $arUpdateData = ['OPPORTUNITY' => $newArr['SUMMA'], "ASSIGNED_BY_ID" => $newArr['OTVET']];
                $deal->Update(
                    $newArr['DEAL_ID'],
                    $arUpdateData,
                );
            }
        }
    }
    public static function updateElement (&$arFields) {

        \Bitrix\Main\Loader::includeModule('iblock');
        \Bitrix\Main\Loader::includeModule('crm');

        $dealOrder = [
            'ID' => 'ASC',
        ];
        $dealFilterFields = [
            'ID' => $arFields['ID'],
        ];
        $deal = \CCrmDeal::GetList(
            $dealOrder,
            $dealFilterFields,
        )->fetch();

        $el = \CIBlockElement::GetList(
            $arOrder = Array("SORT"=>"ASC"),
            $arFilter = ['IBLOCK_ID' => '30', 'PROPERTY_85' => $deal['ID']],
        )->fetch();

        if (!empty($el['ID']))
        {
            $upd = new \CIBlockElement;
            $upd->Update(
                $el['ID'],
                ['PROPERTY_VALUES' => ['DEAL_ID' => $deal['ID'], 'OTVET' => $deal['ASSIGNED_BY_ID'], 'SUMMA' => $deal['OPPORTUNITY']]],
            );
        }
    }
}