<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;

class Deal extends CBitrixComponent
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
        return $arParams;
    }

    protected function getResult()
    {
        $this->arResult['DEAL'] = [];
        $factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
        $this->arResult['ITEM'] = $factory->getItem($this->arParams['dealId']);
        $this->IncludeComponentTemplate();
    }


}