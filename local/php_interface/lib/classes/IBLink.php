<?php
namespace UserTypes;

class IBLink
{
    public $error = 0;

    public static function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE'        => 'S', // тип поля
            'USER_TYPE'            => 'iblock_link', // код типа пользовательского свойства
            'DESCRIPTION'          => 'Запись на процедуру', // название типа пользовательского свойства
            'GetPropertyFieldHtml' => array(self::class, 'GetAdminViewHTML'), // метод отображения свойства
            'GetSearchContent' => array(self::class, 'GetSearchContent'), // метод поиска
            'GetAdminListViewHTML' => array(self::class, 'GetAdminViewHTML'),  // метод отображения значения в списке
            'GetPublicEditHTML' => array(self::class, 'GetPublicViewHTML'), // метод отображения значения в форме редактирования
            'GetPublicViewHTML' => array(self::class, 'GetPublicViewHTML'), // метод отображения значения
        );
    }


    public static function GetAdminViewHTML()
    {
        return 'Отображение только в публичной части';
    }

    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {
        $result = '';
        \CJSCore::Init(['popup']);
        $inpid = md5('link_' . rand(0, 999));
        $valuesElement = self::getDataValues($arProperty['ELEMENT_ID']);
        if (empty($valuesElement))
        {
            return 'У врача нет процедур';
        }
        $count = 0;

        foreach ($valuesElement as $id => $el)
        {
            $result .= '<a data-value="'.$id.'" style="cursor:pointer;" id="elem'.$count.''.$inpid.'">'.$el.'</a><br>';
            $count++;
        }

        $result .= '
<script>
    BX.ready(function () {
        for(let i = 0; i < '.$count.'; i++)
            {
                BX.bind(BX("elem"+i+"'.$inpid.'"), "click", record);  
            }  
    });
        
        function record (e) {
        var popup = BX.PopupWindowManager.create("popup-message", e.targent, {
            content: \'<div style="width:100%;"><input type="text" id="firstfield" placeholder="Введите ФИО" style="padding:4px 5px;width:90%;" /></div><br><div><input type="date" id="secondfield" style="padding:4px 5px;" /><input type="time" id="thirdfield" style="padding:4px 5px;" /></div> \',
            width: 400, // ширина окна
            height: 250, // высота окна
            zIndex: 100, // z-index
            closeIcon: {
                // объект со стилями для иконки закрытия, при null - иконки не будет
                opacity: 1
            },
            titleBar: "Запись клиента",
            closeByEsc: true, // закрытие окна по esc
            darkMode: false, // окно будет светлым или темным
            autoHide: false, // закрытие при клике вне окна
            draggable: true, // можно двигать или нет
            resizable: true, // можно ресайзить
            min_height: 250, // минимальная высота окна
            min_width: 300, // минимальная ширина окна
            lightShadow: true, // использовать светлую тень у окна
            angle: false, // появится уголок
            overlay: {
                // объект со стилями фона
                backgroundColor: "black",
                opacity: 500
            }, 
            buttons: [
                new BX.PopupWindowButton({
                    text: "Записать", // текст кнопки
                    id: "save-btn", // идентификатор
                    className: "ui-btn ui-btn-success", // доп. классы
                    events: {
                      click: function() {
                          let first = BX("firstfield").value;
                          let sec = BX("secondfield").value;
                          let th = BX("thirdfield").value;
                          let four = e.target.getAttribute("data-value");
                          window.location.href = "/otus/create_record.php?first="+first+"&second="+sec+"&third="+th+"&four="+four;
                      }
                    }
                }),
                new BX.PopupWindowButton({
                    text: "Закрыть",
                    id: "copy-btn",
                    className: "ui-btn ui-btn-primary",
                    events: {
                      click: function() {
                          popup.close();
                      }
                    }
                })
            ],
            events: {
               onPopupShow: function() {
                  // Событие при показе окна
               },
               onPopupClose: function() {
                  // Событие при закрытии окна                
               }
            }
        });
        popup.show();
    }
</script>';

        return $result;
    }


    public static function GetSearchContent($arProperty, $value, $strHTMLControlName)
    {
        if (trim($value['VALUE']) != '') {
            return $value['VALUE'] . ' ' . $value['DESCRIPTION'];
        }

        return '';
    }

    public static function getDataValues($id) {

        \Bitrix\Main\Loader::includeModule('iblock');
        $data = \Bitrix\Iblock\Elements\ElementDoctorsTable::getByPrimary($id, [
            'select' => ['PROCEDURES_ID.ELEMENT'],
        ])->fetchObject();

        $valuesElement = [];
        foreach ($data->getProcedures_id()->getAll() as $el){
            $valuesElement[$el->getElement()->getId()] = $el->getElement()->getName();
        }
        
        return $valuesElement;
    }
}

