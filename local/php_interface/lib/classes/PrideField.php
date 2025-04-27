<?php
namespace UserTypes;

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class PrideField
{ 
    public $error = 0;

    /**
     * @return [type]
     */
    public static function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE'        => 'S', // тип поля
            'USER_TYPE'            => 'iblock_link', // код типа пользовательского свойства
            'DESCRIPTION'          =>  Loc::getMessage('NAME'), // название типа пользовательского свойства
            'GetPropertyFieldHtml' => array(self::class, 'GetAdminViewHTML'), // метод отображения свойства
            'GetSearchContent' => array(self::class, 'GetSearchContent'), // метод поиска
            'GetAdminListViewHTML' => array(self::class, 'GetAdminViewHTML'),  // метод отображения значения в списке
            'GetPublicEditHTML' => array(self::class, 'GetPublicViewHTML'), // метод отображения значения в форме редактирования
            'GetPublicViewHTML' => array(self::class, 'GetPublicViewHTML'), // метод отображения значения
        );
    }


    /**
     * @return [type]
     */
    public static function GetAdminViewHTML()
    {
        return '<span style="font-size:30px;color:rgb(247 214 89);cursor:pointer;">★</span>';
    }

    /**
     * @param mixed $arProperty
     * @param mixed $arValue
     * @param mixed $strHTMLControlName
     * 
     * @return [type]
     */
    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {
        global $USER;
        $code = static::getDataValues($arProperty['ELEMENT_ID'], $arProperty['IBLOCK_ID'], $USER->GetID());

        if ($code)
        {
            $result = '<span data-user="'.$USER->GetID().'" data-elem="'.$arProperty['ELEMENT_ID'].'" data-iblock="'.$arProperty['IBLOCK_ID'].'" data-id="'.$code.'" style="font-size:30px;color:rgb(247 214 89);cursor:pointer;" class = "prideField">★</span>';
        }
        else {
            $result = '<a style="font-size:30px;text-decoration:none;color:gray;cursor:pointer;" data-user="'.$USER->GetID().'" data-elem="'.$arProperty['ELEMENT_ID'].'" data-iblock="'.$arProperty['IBLOCK_ID'].'" class = "prideField">★</a>';
        }

        return $result;
    }


    /**
     * @param mixed $arProperty
     * @param mixed $value
     * @param mixed $strHTMLControlName
     * 
     * @return [type]
     */
    public static function GetSearchContent($arProperty, $value, $strHTMLControlName)
    {
        if (trim($value['VALUE']) != '') {
            return $value['VALUE'] . ' ' . $value['DESCRIPTION'];
        }

        return '';
    }

    /**
     * @param mixed $id
     * @param mixed $iblock
     * @param mixed $userID
     * 
     * @return [type]
     */
    public static function getDataValues($id, $iblock, $userID) {

        \Bitrix\Main\Loader::includeModule('iblock');
        $fieldsAppeal = \CIBlockElement::GetList(
            [],
            [
                'PROPERTY_112' => $iblock,
                'PROPERTY_111' => $id,
                "PROPERTY_114" => $userID
            ],
            false,
            false
        );

        if ($elementFields = $fieldsAppeal->getNext())
        {
            return $elementFields['CODE'];
        }

        return false;
    }
}