<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;

class Currencies extends CBitrixComponent
{
    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->getResult();
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

    protected function checkModules()
    {
        if (!Loader::includeModule('iblock'))
            throw new SystemException(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
    }

    public function onPrepareComponentParams($arParams)
    {
        if (!isset($arParams['CACHE_TIME'])) {
            $arParams['CACHE_TIME'] = 3600;
        } else {
            $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
        }
        return $arParams;
    }

    protected function getResult()
    {
        $this->arResult['CURRENCIES'] = [];
        $res = \CCurrency::GetList(($by="name"), ($order="asc"), LANGUAGE_ID);
        while($lcur = $res->Fetch())
        {
            if ($lcur['CURRENCY'] == $this->arParams['CURRENCIES'])
            {
                $this->arResult['CURRENCIES'] = $lcur;
            }
        }

        $this->IncludeComponentTemplate();

    }



}