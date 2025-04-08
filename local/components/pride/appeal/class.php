<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\Context;

class AppealPride extends CBitrixComponent
{
    private static $idAllUsers = [];
    
    public function executeComponent ()
    {
        try {
            $this->checkModules();
            $request = Context::getCurrent()->getRequest();
            global $USER;
            $this->userId = $USER->GetID();
            $this->userGroup = $USER->GetUserGroupArray();
            $this->arResult["APPEAL"] = $request["APPEAL"];
            $this->arResult['TABLE_LINK'] = '/services/web_docs/list_of_appeals.php?APPEAL='.$this->arResult["APPEAL"];
            $this->getDataArray();
            global $APPLICATION;
            $APPLICATION->SetTitle($this->arResult["TITLE"]);

            if (!empty($request["CODE"])) // ЕСЛИ УКАЗАН КОНКРЕТНЫЙ ДОКУМЕНТ
            {
                $arrProps = $this->getValuesElement($request["CODE"]);

                if ($arrProps !== false)
                {
                    $this->addValues($arrProps);
                }
            }

            $this->createFields();
            $this->setButtons();

            if (!empty($request["buttSend"]) || !empty($request["buttChange"])) // ПРИ НАЖАТИИ КНОПОК
            {
                $newValues = $this->checkValuesBeforeSend();

                if (($newValues != false) && (!empty($request["buttSend"])))
                {
                    $this->addElement($newValues);
                }
                if (($newValues != false) && (!empty($request["buttChange"])))
                {
                    $this->updateElement($newValues, $arrProps);
                }
            }
            if (!empty($request["buttAnnul"]))
            {
                $this->annulElement();
            }
            if (!empty($request["buttRestart"]))
            {
                $this->restartElement();
            }

            $this->IncludeComponentTemplate();
        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }
    }

    
    protected function checkModules() // ПРОВЕРКА УСТАНОВКИ МОДУЛЕЙ
    {
        if (!Loader::includeModule('iblock'))
            throw new SystemException(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
    }

    
    protected function getDataArray () // ПОЛУЧЕНИЕ ВХОДНЫХ ДАННЫХ ОБ ОБРАЩЕНИИ
    {
        if (empty($this->arResult["APPEAL"]))
        {
            $this->arResult["APPEAL"] = ((strpos($_SERVER['REQUEST_URI'], "edit-blank825")) !=  '')? '825' : (((strpos($_SERVER['REQUEST_URI'], "sozdanie-zayavki-v-arkhitekturnyy-otdel.php")) !=  '')? '857' : '');
        }

        if (empty($this->arResult["APPEAL"]))
        {
            echo '<b style="color:red; font-size:15px;">Не указана форма документа</b>';
            die();
        }
        else {
            $dataArr = include $_SERVER["DOCUMENT_ROOT"] . $this->GetPath() . '/data.php';
            $this->arResult += $dataArr[$this->arResult["APPEAL"]];

            if (empty($dataArr[$this->arResult["APPEAL"]]))
            {
                echo '<b style="color:red; font-size:15px;">Нет данных о форме документа</b>';
                die();
            }
        }
    }

    
    protected function getValuesElement ($code) // ПОЛУЧЕНИЕ ЗНАЧЕНИЙ КОНКРЕТНОГО ОБРАЩЕНИЯ
    {
        $multiProps = [];

        $fieldsAppeal = \CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => $this->arResult['APPEAL'],
                'ID' => $code
            ],
            false,
            false
        );

        if ($elementFields = $fieldsAppeal->getNext())
        {
            $arrProps = [];
            $arrProps["NAME"] = $elementFields['NAME'];
            $this->authorAppeal = $elementFields['CREATED_BY'];

            $propsAppeal = \CIBlockElement::GetProperty(
                $this->arResult["APPEAL"],
                $code,
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

            return $arrProps;
        }
        else {
            $this->arResult["ERROR"] = "Обращение не найдено &#129300;";
            return false;
        }
    }

    
    protected function addValues ($arrProps) // ДОБАВЛЕНИЕ ЗНАЧЕНИЙ ПОЛЯМ
    {
        $this->arResult['VALUES'] = [];
        $this->arResult['VALUES']['NAME'] = $arrProps['NAME'];

        foreach ($this->arResult['VALUES'] as $key => $value)
        {
            $this->arResult['VALUES'][$key]['VALUE'] = $arrProps[$key];
        }
    }

    
    protected function createFields () // СОЗДАНИЕ ПОЛЕЙ ДЛЯ ОТОБРАЖЕНИЯ
    {
        $this->arResult['FIELDS'] = [];

        foreach ($this->arResult['VALUES'] as $key => $value)
        {
            if (!empty($value["QUESTION"]))
            {
                $funcName = 'create_'.$value["TYPE"];
                $field = $this->$funcName($key, $value);

                if (!empty($value["LABEL_AFTER"]))
                {
                    $field .= '<label class = "explainer">'.$value["LABEL_AFTER"].'</label>';
                }

                $asterisk = (!empty($value["NECESSARILY"]))? ' <span style="color:red;">*</span>' : '';

                if (!empty($value["PAIRED_CODE"]))
                {
                    if (!empty($this->arResult['FIELDS'][$value["PAIRED_CODE"]])) $this->arResult['FIELDS'][$value["PAIRED_CODE"]][1] .= $field;
                    else $this->arResult['FIELDS'][$value["PAIRED_CODE"]] = [$value["QUESTION"].$asterisk, $field, $value["INVISIBLE"]];
                }
                else
                {
                    $this->arResult['FIELDS'][] = [$value["QUESTION"].$asterisk, $field, $value["INVISIBLE"]];
                }
            }
        }
    }

    
    protected function checkValuesBeforeSend () // ПРОВЕРКА ЗНАЧЕНИЙ ПЕРЕД ОТПРАВКОЙ В СПИСОК
    {
        $newValues = [];
        $arrNecFields = [];
        $requestAll = $request->getPostList() + $request->getFileList();

        foreach ($requestAll as $property => $value)
        {
            if (strpos($property, '!#!') != '')
            {
                $property = substr($property, 0, strpos($property, "!#!"));
            }

            if (!empty($this->arResult["VALUES"][$property]["NECESSARILY"]) && (!in_array($property, $arrNecFields)))
            {
                $arrNecFields[] = $property;
            }

            if (!empty($this->arResult["VALUES"][$property]["QUESTION"]))
            {
                $resultCheck = $this->transformValuesBeforeSend($value, $this->arResult["VALUES"][$property], $newValues[$property]);

                if ($resultCheck !== false)
                {
                    $newValues[$property] = $resultCheck;
                }
            }
        }

        foreach ($arrNecFields as $prop)
        {
            if (empty($newValues[$prop]))
            {
                $this->arResult['ERROR'] = "Заполните, пожалуйста, все поля с <span style='color:red;'> *</span>.";
                return false;
            }
        }

        return $newValues;
    }

    
    protected function transformValuesBeforeSend ($value, $prop, $fullValue) // ПРОВЕРКА НА ЗАПОЛНЕННОСТЬ ПОЛЯ ПЕРЕД ОТПРАВКОЙ
    {
        if (empty($value))
        {
            return false;
        }

        if ($prop["TYPE"] == 'DATE' || $prop["TYPE"] == 'DATETIME')
        {
            if (strlen($value) == 10)
            {
                $value = substr($value, 8, 2).'.'.substr($value, 5, 2).'.'.substr($value, 0, 4);
            }
            if (strlen($value) == 5)
            {
                if (empty($fullValue)) return false;
                $value = substr($fullValue, 0, 10).' '.$value.':00';
            }
        }

        if ($prop["TYPE"] == 'DATALIST')
        {
            if ($prop["LIST"] == 'USERS')
            {
                $pieces = explode(' ', $value);
                $userSelectId = array_pop($pieces);

                if(!in_array($userSelectId, self::$idAllUsers))
                {
                    return false;
                }
                else {
                    $value = $userSelectId;
                }
            }
        }

        if (!empty($prop["MULTI"]))
        {
            if (empty($fullValue)) $fullValue = [];
            $fullValue[] = $value;
            return $fullValue;
        }

        return $value;
    }


    protected function create_TEXT ($name, $value) // СОЗДАНИЕ ТЕКСТОВОГО ИНПУТА
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y")
        {
            if (is_array($value["VALUE"]) == false)
            {
                return $value["VALUE"];
            }
            else
            {
                $field = '';
                foreach ($value["VALUE"] as $v)
                {
                    $field .= $v.'<br>';
                }
                return $field;
            }
        }

        if (empty($value["MULTI"]))
        {
            $field = '<input type = "text" ';
            $field .= (!empty($value['PLACEHOLDER']))? 'placeholder="'.$value['PLACEHOLDER'].'" ' : '';
            $field .= 'name = "'.$name.'" '.((!empty($value["VALUE"]))? 'value = "'.$value["VALUE"].'" ' : ' ');
            $field .= ' /> ';
        }
        else
        {
            $field = '';
            for ($i = 0; $i < $value["MULTI"]; $i++)
            {
                $field .= '<input type = "text" ';
                $field .= (!empty($value['PLACEHOLDER']))? 'placeholder="'.$value['PLACEHOLDER'].'" ' : '';
                $field .= 'name = "'.$name.'!#!'.$i.'" '.((!empty($value["VALUE"][$i]))? 'value = "'.$value["VALUE"][$i].'" ' : ' ');
                $field .= ' /> ';
            }
        }

        return $field;
    }


    protected function create_NUMBER ($name, $value) // СОЗДАНИЕ ЧИСЛОВОГО ИНПУТА
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y")
        {
            if (is_array($value["VALUE"]) == false)
            {
                return $value["VALUE"];
            }
            else
            {
                $field = '';
                foreach ($value["VALUE"] as $v)
                {
                    $field .= $v.'<br>';
                }
                return $field;
            }
        }

        if (empty($value["MULTI"]))
        {
            $field = '<input type = "number" min = "1" ';
            $field .= 'name = "'.$name.'" '.((!empty($value["VALUE"]))? 'value = "'.$value["VALUE"].'" ' : ' ');
            $field .= ' />';
        }
        else
        {
            $field = '';
            for ($i = 0; $i < $value["MULTI"]; $i++)
            {
                $field .= '<input type = "number" min = "1" ';
                $field .= 'name = "'.$name.'!#!'.$i.'" '.((!empty($value["VALUE"][$i]))? 'value = "'.$value["VALUE"][$i].'" ' : ' ');
                $field .= ' />';
            }
        }

        return $field;
    }


    protected function create_TEXTAREA ($name, $value) // СОЗДАНИЕ ТЕКСТОВОГО ПОЛЯ
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y") return $value["VALUE"];

        $field = '<textarea cols = "30" rows = "12" ';
        $field .= 'name = "'.$name.'" ';
        $field .= ' />';
        $field .= $value["VALUE"].'</textarea>';

        return $field;
    }


    protected function create_FILE ($name, $value) // СОЗДАНИЕ ФАЙЛОВОГО ИНПУТА
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y")
        {
            if (is_array($value["VALUE"]) == false)
            {
                if (empty($value["VALUE"])) return ' ';
                return '<a target = "_blank" href = "https://' . $_SERVER['HTTP_HOST'] . $value["VALUE"] . '">Открыть файл</a>';
            } 
            else {
                $field = '';
                foreach ($value["VALUE"] as $v) 
                {
                    $field .= '<a target = "_blank" href = "https://' . $_SERVER['HTTP_HOST'] . $v . '">Открыть файл</a><br>';
                }
                return $field;
            }
        }
        
        if (!empty($value["MULTI"]))
        {
            $field = '';

            for ($i = 0; $i < $value["MULTI"]; $i++)
            {
                $field .= '<label class = "input-file">';
                $field .= '<input type = "file" ';
                $field .= 'name = "'.$name.'!#!'.$i.'" ';
                $field .= ' />';
                $field .= '<span>'.((!empty($value["VALUE"][$i]))? $value["VALUE"][$i] : "Выберите файл").'</span> </label>';
            }
        }
        else {
            $field = '<label class = "input-file">';
            $field .= '<input type = "file" ';
            $field .= 'name = "'.$name.'" ';
            $field .= ' />';
            $field .= '<span>'.((!empty($value["VALUE"]))? $value["VALUE"] : "Выберите файл").'</span> </label>';
        }

        return $field;
    }


    protected function create_DATETIME ($name, $value) // СОЗДАНИЕ ДАТЫ
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y") return $value["VALUE"];
        
        if (!empty($value["VALUE"]))
        {
            $value["VALUE_DATE"] = substr($value["VALUE"], 6, 4).'-'.substr($value["VALUE"], 3, 2).'-'.substr($value["VALUE"], 0, 2);
            $value["VALUE_TIME"] = substr($value["VALUE"], 11);
        }
        if (!empty($value["DEFAULT"]))
        {
            $value["DEFAULT_DATE"] = substr($value["DEFAULT"], 0, 10);
            $value["DEFAULT_TIME"] = substr($value["DEFAULT"], 11);
        }

        $field = '<input type = "date" ';
        $field .= 'name = "'.$name.'!#!1" ';
        $field .= (!empty($value['MIN']))? 'min = "'.date('Y-m-d').'"':'';
        $field .= ($value["VALUE_DATE"])? ' value = "'.$value["VALUE_DATE"].'" ' : (($value["DEFAULT_DATE"])? ' value = "'.$value["DEFAULT_DATE"].'" ' : ' ');
        $field .= ' /> ';
        $field .= '<input type = "time" ';
        $field .= 'name = "' . $name . '!#!2"';
        $field .= ($value["VALUE_TIME"]) ? ' value = "' . $value["VALUE_TIME"] . '" ' : (($value["DEFAULT_TIME"])? ' value = "'.$value["DEFAULT_TIME"].'" ' : ' value = "00:00" ');
        $field .= ' /> ';

        return $field;
    }


    protected function create_DATE ($name, $value) // СОЗДАНИЕ ДАТЫ
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y") return $value["VALUE"];

        if (!empty($value["VALUE"]))
        {
            $value["VALUE"] = substr($value["VALUE"], 6, 4).'-'.substr($value["VALUE"], 3, 2).'-'.substr($value["VALUE"], 0, 2);
        }

        $field = '<input type = "date" ';
        $field .= 'name = "'.$name.'"';
        $field .= (!empty($value['MIN']))? 'min = "'.date('Y-m-d').'"':'';
        $field .= ($value["VALUE"])? ' value = "'.$value["VALUE"].'" ' : (($value["DEFAULT"])? ' value = "'.$value["DEFAULT"].'" ' : ' ');
        $field .= ' /> ';
    }


    protected function create_TIME ($name, $value, $hasTime = true) // СОЗДАНИЕ ВРЕМЕНИ
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y") return $value["VALUE"];

        $field .= '<input type = "time" ';
        $field .= 'name = "' . $name . '"';
        $field .= ($value["VALUE"]) ? ' value = "' . $value["VALUE"] . '" ' : (($value["DEFAULT"])? ' value = "'.$value["DEFAULT"].'" ' : ' value = "00:00" ');
        $field .= ' /> ';
    }


    protected function create_SELECT ($name, $value) // СОЗДАНИЕ СПИСКА
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y") return $value["VALUE"];
        
        $field = '<select name = "'.$name.'"';
        $field .= ($value["VALUE"])? ' value = "'.$value["VALUE"].'" >' : '>';
        $field .= '<option value = ""> </option>';

        for ($i = 0; $i < count($value["OPTIONS"]); $i++)
        {
            $field .= '<option value = "'.$value["OPTIONS"][$i].'">'.$value["OPTIONS"][$i].'</option>';
        }

        $field .= '</select>';

        return $field;
    }


    protected function create_RADIO ($name, $value) // СОЗДАНИЕ РАДИО КНОПОК (ПУНКТОВ)
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y") return $value["VALUE"];
        
        $field = '<input type="hidden" name="'.$name.'" value="0" >';
        for ($i = 0; $i < count($value["OPTIONS"]); $i++)
        {
            $field .= '<div class = "parentCheckboxOrRadio">';
            $field .= '<input type="radio" ';
            $field .= 'name = "'.$name.'" value="'.$value["OPTIONS"][$i].'"';
            $field .= (!empty($value["VALUE"]) && $value["OPTIONS"][$i] == $value["VALUE"])? ' checked ' : ' ';
            $field .= ' ><label>'.$value["OPTIONS"][$i].'</label></div>';
        }

        return $field;
    }


    protected function create_CHECKBOX ($name, $value) // СОЗДАНИЕ ЧЕКБОКСОВ
    {
        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y")
        {
           $field = '';
           
           foreach ($value["VALUE"] as $v)
           {
               $field .= $v.'<br>';
           }
           
           return $field;
        }
        
        $field = '';
        for ($i = 0; $i < count($value["OPTIONS"]); $i++)
        {
            $field .= '<div class = "parentCheckboxOrRadio">';
            $field .= '<input type = "hidden" name = "'.$name.'!#!'.$i.'" value = "0" >';
            $field .= '<input type = "checkbox" ';
            $field .= 'name = "'.$name.'!#!'.$i.'" value = "'.$value["OPTIONS"][$i].'" ';
            $field .= (!empty($value["VALUE"]) && in_array($value["OPTIONS"][$i], $value["VALUE"]))? ' checked ' : ' ';
            $field .= ' ><label>'.$value["OPTIONS"][$i].'</label></div>';
        }

        return $field;
    }


    protected function create_DATALIST ($name, $value)  // СОЗДАНИЕ СПИСКА
    {
        if (!empty($value["VALUE"]) && $value["LIST"] == 'USERS')
        {
            $selUser = (\CUser::GetByID($value["VALUE"]))->Fetch();
            $value["VALUE"] = $selUser['LAST_NAME']." ".$selUser['NAME']." ".$selUser['SECOND_NAME']." ".$selUser['ID'];
        }

        if (!empty($value["VALUE"]) && $value["IS_CHANGEABLE"] != "Y") return $value["VALUE"];

        $list = '';

        if ($value["LIST"] == "USERS" || $value["LIST"] == "USERS2") // СПИСОК ПОЛЬЗОВАТЕЛЕЙ
        {
            if (!empty($value["MY_EMPLOYEES"])) // ЕСЛИ НУЖНО ОТОБРАЖАТЬ ТОЛЬКО СЕБЕ ИЛИ СВОИХ СОТРУДНИКОВ
            {
                $dep = \CUser::GetList($by="name", $order="asc", array('ID' => (new \CUser)->GetID()), array("SELECT"=>["UF_DEPARTMENT"]));

                while($us = $dep->Fetch())
                {
                    if (empty($us["UF_DEPARTMENT"][0]))
                    {
                        $users = \CUser::GetList(
                            ($by="last_name"),
                            ($order="desc"),
                            ['ID' => \CUser::GetID()]
                        );
                    }
                    else {
                        $users = \CUser::GetList(
                            ($by = "last_name"),
                            ($order = "desc"),
                            ['UF_DEPARTMENT' => [$us["UF_DEPARTMENT"][0]], 'ACTIVE' => 'Y']
                        );
                    }
                }
            }
            else {
                $users = \CUser::GetList(
                    ($by="last_name"),
                    ($order="desc"),
                    ['ACTIVE' => 'Y', '!UF_DEPARTMENT' => '']
                );
            }

            $idAllUsers = [];

            while ($user = $users->Fetch())
            {
                $list .= '<option value = "'.$user['LAST_NAME'].' '.$user['NAME']." ".$user['SECOND_NAME']." ".$user['ID'].'"></option>';
                $idAllUsers[] = $user['ID'];
            }

            self::$idAllUsers = $idAllUsers;
        }

        if ($value["LIST"] == "SHOPS") // СПИСОК МАГАЗИНОВ
        {
            $shops = \CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => 858,
                ],
                false,
                false,
                ["NAME"]
            );

            while ($shop = $shops->Fetch())
            {
                $list .= '<option value = "'.$shop['NAME'].'"></option>';
            }
        }

        if ($value["LIST"] == "MALLS") // СПИСОК ТОРГОВЫХ ЦЕНТРОВ
        {
            $malls = \CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => 52,
                    'ACTIVE' => 'Y'
                ],
                false,
                false,
                ["NAME"]
            );
            $check = [];

            while ($mall = $malls->Fetch())
            {
                if (!in_array($mall['NAME'], $check)) {
                    $check[] = $mall['NAME'];
                    $list .= '<option value = "' . $mall['NAME'] . '"></option>';
                }
            }
        }

        $field = '<input list="'.$name.'" ';
        $field .= 'name = "'.$name.'" placeholder = "'.$value["PLACEHOLDER"].'"';
        $field .= (!empty($value["VALUE"]))? ' value = "'.$value["VALUE"].'"': ((!empty($value["DEFAULT"]))? ' value = "'.$value["DEFAULT"].'" ' : '');
        $field .= ' /> ';
        $field .= '<datalist id="'.$name.'">'.$list.'</datalist>';

        return $field;
    }


    protected function addElement ($newValues = []) // ДОБАВЛЕНИЕ ЭЛЕМЕНТА
    {
        $element = new \CIBlockElement;
        $newValues["NAME"] = (!empty($newValues["NAME"]))? $newValues["NAME"] : 'Обращение №';
        $dataOfElement = array(
            "ACTIVE_FROM" => date('d.m.Y H:i:s'),
            "MODIFIED_BY" => $this->userId,
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $this->arResult["APPEAL"],
            "NAME" => $newValues["NAME"],
            "ACTIVE" => "Y",
            "CODE" => "appeal",
            "PROPERTY_VALUES" => $newValues,
            "SORT" => 100
        );

        $newElement = $element->Add($dataOfElement);

        if (!empty($this->arResult["ID_BP"]))
        {
            $errorBp = [];
            $bp = \CBPDocument::StartWorkflow(
                $this->arResult['ID_BP'],
                array("lists", "BizprocDocument", $newElement),
                array_merge(array(), array("TargetUser" => "user_3275")),
                $errorBp
            );
        }

        $link = '';
        if (!empty($this->arResult["PRINT"])) $link = '&print=1';
        header('Location: https://'.$_SERVER['SERVER_NAME'].$this->arResult["TABLE_LINK"].$link);
    }


    protected function updateElement ($newValues = [], $arrProps = []) // ИЗМЕНЕНИЕ ЭЛЕМЕНТА
    {
        $element = new \CIBlockElement;
        $updArr = $newValues + $arrProps;
        $element->Update($this->arResult["APPEAL"], ["PROPERTY_VALUES" => $updArr, "MODIFIED_BY" => $this->userId]);

        if (!empty($this->arResult["ID_BP"]))
        {
            $arWorkflowParameters = ["Parameter1" => 'Изменить'];
            $errorBp = [];
            $bp = \CBPDocument::StartWorkflow(
                $this->arResult['ID_BP'],
                array("lists", "BizprocDocument", $this->arResult["APPEAL"]),
                array_merge($arWorkflowParameters, array("TargetUser" => "user_3275")),
                $errorBp
            );

            header('Location: https://'.$_SERVER['SERVER_NAME'].$this->arResult["TABLE_LINK"]);
        }
    }


    protected function annulElement () // АННУЛИРОВАНИЕ ЭЛЕМЕНТА
    {
        if (!empty($this->arResult["ID_BP"]))
        {
            $arWorkflowParameters = ["Parameter1" => 'Аннулировать'];
            $errorBp = [];
            $bp = \CBPDocument::StartWorkflow(
                $this->arResult['ID_BP'],
                array("lists", "BizprocDocument", $this->arResult["APPEAL"]),
                array_merge($arWorkflowParameters, array("TargetUser" => "user_3275")),
                $errorBp
            );

            header('Location: https://'.$_SERVER['SERVER_NAME'].$this->arResult["TABLE_LINK"]);
        }
    }


    protected function restartElement () // ВОЗОБНОВЛЕНИЕ ЭЛЕМЕНТА
    {
        if (!empty($this->arResult["ID_BP"]))
        {
            $arWorkflowParameters = [];
            $errorBp = [];
            $bp = \CBPDocument::StartWorkflow(
                $this->arResult['ID_BP'],
                array("lists", "BizprocDocument", $this->arResult["APPEAL"]),
                array_merge($arWorkflowParameters, array("TargetUser" => "user_3275")),
                $errorBp
            );

            header('Location: https://'.$_SERVER['SERVER_NAME'].$this->arResult["TABLE_LINK"]);
        }
    }


    protected function setButtons () // ДОБАВЛЕНИЕ КНОПОК
    {
        if (empty($this->arResult["APPEAL"]))
        {
            if ($this->checkAccess($this->arResult['ACCESS']['ADD']))
            {
                $this->arResult["BUTTON_SEND"] = 'Y';
            }
        }

        foreach ($this->arResult['VALUES'] as $key => $value)
        {
            if (!empty($value["IS_CHANGEABLE"]) && $this->checkAccess($this->arResult['ACCESS']['EDIT']))
            {
                $this->arResult["BUTTON_CHANGE"] = 'Y';
                break;
            }
        }

        if (!empty($arResult["VALUES"]["STATUS"]) && $arResult["VALUES"]["STATUS"] == "Аннулировано" && $this->checkAccess($this->arResult['ACCESS']['DELETE']))
        {
            $this->arResult["BUTTON_RESTART"] = 'Y';
        }

        if (!empty($arResult["APPEAL"]) && $this->checkAccess($this->arResult['ACCESS']['DELETE']))
        {
            $this->arResult["BUTTON_DELETE"] = 'Y';
        }

        if (!empty($arResult["VALUES"]["FOR_PRINT"]))
        {
            $this->arResult["BUTTON_PRINT"] = 'Y';
        }
    }


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