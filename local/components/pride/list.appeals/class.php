<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\Context;

class ListOfAppealsPride extends CBitrixComponent
{

    /**
     * @return [type]
     */
    public function executeComponent ()
    {
        try {
            $this->checkModules();
            $request = Context::getCurrent()->getRequest();
            $this->arResult["APPEAL"] = $request["APPEAL"];
            $this->arResult['APPEAL_ADD'] = '/services/web_docs/appeal.php?APPEAL='.$this->arResult["APPEAL"];
            $this->getDataArray();
            global $APPLICATION;
            $APPLICATION->SetTitle($this->arResult["TITLE_LIST"]);
            global $USER;
            $this->userId = $USER->GetID();
            $this->userGroup = $USER->GetUserGroupArray();

            $this->arResult['ROWS'] = $this->getValuesElement($this->userId);
            $this->createTools('addButton', $this->userId);

            $this->IncludeComponentTemplate();
        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }
    }

    
    /**
     * @return [type]
     */
    protected function checkModules() // ПРОВЕРКА УСТАНОВКИ МОДУЛЕЙ
    {
        \Bitrix\Main\UI\Extension::load('list.pride');
        
        if (!Loader::includeModule('iblock'))
            throw new SystemException(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
    }

    
    /**
     * @return [type]
     */
    protected function getDataArray () // ПОЛУЧЕНИЕ ВХОДНЫХ ДАННЫХ ОБ ОБРАЩЕНИИ
    {
        if (empty($this->arResult["APPEAL"]))
        {
            echo '<b style="color:red; font-size:15px;">'.Loc::getMessage('NOT_FORM').'</b>';
            die();
        }
        else {
            $dataArr = include $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/lib/classes/data.php';
            if (!empty($dataArr[$this->arResult["APPEAL"]])) $this->arResult += $dataArr[$this->arResult["APPEAL"]];

            if (empty($dataArr[$this->arResult["APPEAL"]]))
            {
                echo '<b style="color:red; font-size:15px;">'.Loc::getMessage('NOT_DATA').'</b>';
                die();
            }
        }
    }


    
    /**
     * @param mixed $userId
     * 
     * @return [type]
     */
    protected function getValuesElement ($userId) // ПОЛУЧЕНИЕ ЗНАЧЕНИЙ КОНКРЕТНОГО ОБРАЩЕНИЯ
    {        
        $allProps = [];
        $multiProps = [];
        $filter = $this->createTools('tableFilter', $userId);

        $fieldsAppeal = \CIBlockElement::GetList(
            ["ID" => 'ABS'],
            $filter,
            false,
            false
        );

        while ($elementFields = $fieldsAppeal->getNext())
        {
            $arrProps = [];
            $arrProps["NAME"] = '<a href ="/services/web_docs/appeal.php?APPEAL='.$elementFields['IBLOCK_ID'].'&CODE='.$elementFields['ID'].'">'.$elementFields['NAME'].'</a>';
            $dataUser = (\CUser::GetByID($elementFields["CREATED_BY"]))->Fetch();
            $arrProps["CREATED_BY"] = '<a href = "/company/personal/user/'.$elementFields["CREATED_BY"].'/">'.$dataUser['LAST_NAME'].' '.$dataUser['NAME'].'</a>';
            $arrProps["DATE_CREATE"] = $elementFields['DATE_CREATE'];

            $propsAppeal = \CIBlockElement::GetProperty(
                $this->arResult["APPEAL"],
                $elementFields['ID'],
                ["id" => "asc"]
            );

            while ($elementProperties = $propsAppeal->getNext())
            {
                if (is_array($elementProperties['VALUE']))
                {
                    $arrProps[(string) $elementProperties["ID"]] = htmlspecialchars_decode(preg_replace('#amp;#', '', $elementProperties["VALUE"]["TEXT"]));
                }
                else if ($elementProperties['PROPERTY_TYPE'] == 'F')
                {
                    $arrProps[(string) $elementProperties["ID"]] = \CFile::GetFileArray($elementProperties['VALUE'])['SRC'];
                }
                else if ($elementProperties['PROPERTY_TYPE'] == 'N')
                {
                    $dataUser = (\CUser::GetByID($elementProperties["VALUE"]))->Fetch();
                    $link = '<a href = "/company/personal/user/'.$elementProperties["VALUE"].'/">'.$dataUser['LAST_NAME'].' '.$dataUser['NAME'].'</a>';
                    $arrProps[(string) $elementProperties["ID"]] = $link;
                }
                else if ((string) $elementProperties["CODE"] == 'FAVOURITES')
                {
                    $elementProperties["ELEMENT_ID"] = $elementFields['ID'];
                    $arrProps[(string) $elementProperties["ID"]] = \UserTypes\PrideField::GetPublicViewHTML($elementProperties, [],[]);
                }
                else
                {
                    $arrProps[(string) $elementProperties["ID"]] = htmlspecialchars_decode(preg_replace('#amp;#', '', $elementProperties["VALUE"]));
                }

                if ($elementProperties['MULTIPLE'] == "Y")
                {
                    if(empty($multiProps[$elementProperties["ID"]])) $multiProps[$elementProperties["ID"]] = [];

                    $multiProps[$elementProperties["ID"]][] = $arrProps[(string) $elementProperties["ID"]];
                    $arrProps[(string) $elementProperties["ID"]] = $multiProps[$elementProperties["ID"]];
                }

                if (!empty($elementProperties["CODE"]))
                {
                    $arrProps[(string) $elementProperties["CODE"]] = $arrProps[(string) $elementProperties["ID"]];
                }
            }

            $allProps[] = array('data' => $arrProps);
        }

        return $allProps;
    }


    /**
     * @param mixed $tool
     * @param mixed $userId
     * 
     * @return [type]
     */
    protected function createTools ($tool, $userId) // ДОБАВЛЕНИЕ ИНСТРУМЕНТОВ В ЗАВИСИМОСТИ ОТ ПРАВ
    {
        if ($tool == 'tableFilter')
        {
            if ($this->arResult['ACCESS']['READ'] == 'all')
            {
                $filter = ['IBLOCK_ID' => $this->arResult["APPEAL"]];
            }
            else if (is_array($this->arResult['ACCESS']['READ']))
            {
                if ($this->checkAccess($this->arResult['ACCESS']['READ']))
                {
                    $filter = ['IBLOCK_ID' => $this->arResult["APPEAL"]];
                }
            }
            else
            {
                $filter = ['IBLOCK_ID' => $this->arResult["APPEAL"], 'CREATED_USER_ID' => $userId];
            }    

            if ($this->arResult["APPEAL"] == '36') // ИЗБРАННОЕ
            {
                $filter = ['IBLOCK_ID' => $this->arResult["APPEAL"], 'PROPERTY_114' => $userId];
            }
        
            return $filter;
        }

        if ($tool == 'addButton')
        {
            if ($this->checkAccess($this->arResult['ACCESS']['ADD']))
            {
                $this->arResult["BUTTON_CREATE"] = 'Y';
            }
        }
    }


    /**
     * @param mixed $arrAccess
     * 
     * @return [type]
     */
    public function checkAccess ($arrAccess) // ПРОВЕРКА ПРАВ
    {
        $res = false;

        if ($arrAccess == 'all') return true;

        foreach ($arrAccess as $access)
        {
            if ($access == 'author')
            {
                if ($this->authorAppeal == $this->userId)
                {
                    $res = true;
                    break;
                }
            }

            if (str_contains($access, 'user'))
            {
                if (substr($access, 4) == $this->userId)
                {
                    $res = true;
                    break;
                }
            }

            if (str_contains($access, 'department'))
            {
                $res = $this->checkDepartment(substr($access,10));
                if ($res == true) break;
            }

            if (str_contains($access, 'group'))
            {
                $res = in_array(substr($access,5), $this->userGroup);
                if ($res == true) break;
            }
        }

        return $res;
    }


    /**
     * @param mixed $dep
     * 
     * @return [type]
     */
    public function checkDepartment ($dep) // ПРОВЕРКА ПРАВ ПО ДЕПАРТАМЕНТУ
    {
        $userDep = \Bitrix\Main\UserTable::getList([
            'select' => ['ID', 'UF_DEPARTMENT'],
            'filter' => ['=ID' => $this->userId]
        ])->fetchObject();

        foreach ($userDep->getUf_department() as $item)
        {
            if ($item == $dep)
            {
                return true;
            }
        }

        return false;
    }
}


/*
<div class = "toolsBeforeTable">
 	<?php if ($arResult['APPEAL'] != 'all') { ?><a href = "<?php echo $arResult["CREATE_APPEAL_LINK"]; ?>" target="_self" class = "buttAdd">Добавить</a> <?php } ?>
	<a href = "/services/web_docs/" target="_self" class = "buttBack">Список документов</a>
	<input type = "text" class = "searchByWord" placeholder = " Поиск по ключевому слову" />
</div>
*/