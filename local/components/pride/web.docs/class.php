<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class WebDocs extends CBitrixComponent
{
    /**
     * @return [type]
     */
    public function executeComponent()
    {
        try {
            $this->getDataParameters(); // Получение данных
            global $USER;
            $this->userId = $USER->GetID();
            $this->userGroup = $USER->GetUserGroupArray();
            $this->arResult['LISTS'] = [];
            $this->addElement(); // Сохранение элементов для отображения, с учетом прав на просмотр
            $this->IncludeComponentTemplate(); // Вывод
        }
        catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

    /**
     * @return [type]
     */
    public function getDataParameters() // Получение данных о выводимых элементах
    {
        $this->arResult['ALL_DATA'] = include $_SERVER["DOCUMENT_ROOT"] . $this->GetPath() . "/data.php";
        if (!is_array($this->arResult['ALL_DATA']))
        {
            echo '<b style="color:red;">Нет данных о формах</b>';
            die();
        }
    }

    /**
     * @return [type]
     */
    public function addElement () {

        foreach ($this->arResult['ALL_DATA'] as $title => $data) // Сбор данных для отображения у текущего пользователя
        {
            $this->arResult['LISTS'][$title] = [];

            foreach ($data as $element)
            {
                $res = false;

                if (!empty($element['ACCESS']) && is_array($element['ACCESS'])) // Проверка прав для отображения
                {
                    $res = $this->checkAccess($element['ACCESS']);
                }
                if ($res == true || $element['ACCESS'] == 'all') // Добавить элемент
                {
                    $this->arResult['LISTS'][$title][] = $element;
                }
            }
            if (empty($this->arResult['LISTS'][$title]))
            {
                unset($this->arResult['LISTS'][$title]);
            }
        }
    }

    /**
     * @param mixed $array
     * 
     * @return [type]
     */
    public function checkAccess ($array) {

        $res = false;

        foreach ($array as $access)
        {
            if (str_contains($access, 'user'))
            {
                $res = $this->checkUser(substr($access,4));
                if ($res == true) break;
            }
            if (str_contains($access, 'department'))
            {
                $res = $this->checkDepartment(substr($access,10));
                if ($res == true) break;
            }
            if (str_contains($access, 'group'))
            {
                $res = $this->checkGroup(substr($access,5));
                if ($res == true) break;
            }
        }

        return $res;
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function checkUser ($id) {

        if ($this->userId == $id)
        {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $dep
     * 
     * @return [type]
     */
    public function checkDepartment ($dep) {
        $userDep = \Bitrix\Main\UserTable::getList([
            'select' => ['ID','UF_DEPARTMENT'],
            'filter' => ['=ID'=>$this->userId]
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

    /**
     * @param mixed $group
     * 
     * @return [type]
     */
    public function checkGroup ($group) {

        return in_array($group, $this->userGroup);
    }

}