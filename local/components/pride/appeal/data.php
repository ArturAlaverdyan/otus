<?php
/*
 В ACCESS записать all если добавлять просмотр всем сотрудникам, если есть выборка - обязательно массив, где
 author - автор текущей заявки,
 user*** - будет отображено пользователю,
 group*** - будет отображено группе пользователей,
 department*** - будет отображено подразделению.
 */
global $USER;

return [
    "825" => [ //  СЛУЖЕБНАЯ ЗАПИСКА 4
        "TITLE" => "Служебная записка №4 на предоставление расширенного доступа в интернет",
        "ID_BP" => '317',
        "ACCESS" => [
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => 'all',
        ],
        "TOP_TEXT" => ["Доступ к сети Интернет предоставляется с ограничениями согласно приказу Генерального Директора ООО «Трейд Менеджмент» №92 от 19 сентября 2019 г. Доступ к внутренним ресурсам предоставляется без ограничений (корпоративная почта, корпоративный портал, корпоративный чат, файлобменник и другие ресурсы).", "Прошу предоставить расширенный доступ."],
        "BOTTOM_TEXT" => ["Ознакомлен(а) и обязуюсь выполнять утвержденные правила работы с Интернетом.","Принимаю ответственность на себя за все действия по снижению уровня информационной и антивирусной безопасности, а также возможной потери данных."],
        "VALUES" => [
            "766" => [
                "TYPE" => "DATALIST",
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Кому предоставить'
            ],
            "1130" => [
                "OPTIONS" => ['Доступ к мессенджерам (Whatsapp, Viber, ICQ, Skype и другие)', 'Доступ к внешней веб-почте (Mail.ru, Rambler.ru, Gmail.com, Yandex.ru и другие)','Доступ к облачным хранилищам (ЯндексДиск, Dropbox, icloud и другие)','Доступ к социальным сетям и развлекательному контенту'],
                "TYPE" => "CHECKBOX",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Уровень доступа (можно выбрать несколько)'
            ],
			"1129" => [
                "TYPE" => "TEXTAREA",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Обоснование (для выполнения каких рабочих задач)'
            ]
        ]
    ],
    "857" => [ // ЗАЯВКА В ОТДЕЛ АиД
        "TITLE" => "Заявка в отдел архитектуры и дизайна",
        "ID_BP" => '360',
        "ACCESS" => [
            "ADD" => ['group159', 'group157','user3275'],
            "EDIT" => ['author', 'group157','user3275'],
            "DELETE" => ['author','group157','user1342','user3275'],
        ],
        "TOP_TEXT" => [],
        "BOTTOM_TEXT" => [],
        "VALUES" => [
            "NAME" => [
                "TYPE" => "TEXT",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Наименование изделия/тмц'
            ],
			"1110" => [
                "TYPE" => "DATALIST",
                "LIST" => "SHOPS",
                "PLACEHOLDER" => ' Введите бренд/торговый центр',
                "QUESTION" => 'Выберите магазин'
            ],
			"1140" => [
                "TYPE" => "TEXTAREA",
                "IS_CHANGEABLE" => "Y",
                "QUESTION" => 'Описание (исходные данные)'
            ],
			"1080" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "QUESTION" => 'Количество'
            ],
			"1112" => [
                "TYPE" => "DATE",
                "QUESTION" => 'Срок реализации (крайний срок)'
            ],
			"1104" => [
                "TYPE" => "FILE",
                "MULTI" => 3,
                "QUESTION" => 'Дополнительные материалы (при наличии)'
            ]
        ]
    ],
    "863" => [ // ПОЛУЧЕНИЕ SMS ОПОВЕЩЕНИЙ ОБ АВАРИЯХ
        "TITLE" => "Получать sms оповещения на телефон о тикетах",
        "ID_BP" => '469',
        "ACCESS" => [
            "ADD" => ['group157','user3275'],
            "EDIT" => ['group157','user3275'],
            "DELETE" => ['group157','user3275'],
        ],
        "TOP_TEXT" => [],
        "BOTTOM_TEXT" => [],
        "VALUES" => [
            "1143" => [
                "TYPE" => "DATALIST",
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Кому предоставить'
            ],
			"1144" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "QUESTION" => 'Телефон без +7'
            ],
        ]
    ],
    "864" => [ // МАРКЕТПЛЕЙС/ПОКАЗАТЕЛИ
        "TITLE" => "Маркетплейс/показатели",
        "ID_BP" => '474',
        "ACCESS" => [
            "ADD" => ['user3275'],
            "EDIT" => ['user3275'],
            "DELETE" => ['user3275'],
        ],
        "TOP_TEXT" => ["Данные за дату ".date("d.m.Y")],
        "BOTTOM_TEXT" => [],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "ADMIN",
        "VALUES" => [
            "1148" => [
                "TYPE" => "SELECT",
                "OPTIONS" => ['Ozon', 'Ламода', 'Wildberries', 'Мега маркет','Яндекс маркет'],
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Маркетплейс'
            ],
			"1149" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "first",
                "LABEL_AFTER" => "шт.",
                "QUESTION" => 'Заказано'
            ],
			"1150" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "first",
                "LABEL_AFTER" => "руб.",
                "QUESTION" => 'Заказано'
            ],
			"1151" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "second",
                "LABEL_AFTER" => "шт.",
                "QUESTION" => 'Выкуплено'
            ],
			"1152" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "second",
                "LABEL_AFTER" => "руб.",
                "QUESTION" => 'Выкуплено'
            ],
			"1153" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "third",
                "LABEL_AFTER" => "шт.",
                "QUESTION" => 'Возврат'
            ],
			"1154" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "third",
                "LABEL_AFTER" => "руб.",
                "QUESTION" => 'Возврат'
            ],
			"1155" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "four",
                "LABEL_AFTER" => "шт.",
                "QUESTION" => 'Остаток'
            ],
			"1156" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "four",
                "LABEL_AFTER" => "руб.",
                "QUESTION" => 'Остаток'
            ],
        ]
    ],
    "866" => [ // ПОТЕРИ КОМПАНИИ
        "TITLE" => "Потери компании",
        "ID_BP" => '475',
        "ACCESS" => [
            "ADD" => ['user3275'],
            "EDIT" => ['user3275'],
            "DELETE" => ['user3275'],
        ],
        "TOP_TEXT" => [],
        "BOTTOM_TEXT" => [],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "ADMIN",
        "VALUES" => [
            "1164" => [
                "TYPE" => "TEXTAREA",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "QUESTION" => 'Описание'
            ],
			"1165" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "QUESTION" => 'Сумма (руб.)'
            ],
			"1166" => [
                "TYPE" => "TEXTAREA",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "QUESTION" => 'Преднинятые действия'
            ],
			"1167" => [
                "TYPE" => "TEXTAREA",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "QUESTION" => 'Результат'
            ],
        ]
    ],
    "867" => [ // ОТПУСК
        "TITLE" => "Редактирование отпуска",
        "ID_BP" => '481',
        "ACCESS" => [
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => [],
        ],
        "TOP_TEXT" => ["Прошу предоставить вас мне:"],
        "BOTTOM_TEXT" => [],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "Y",
        "VALUES" => [
            "1173" => [
                "TYPE" => "DATALIST",
                //"MY_EMPLOYEES" => 'Y',
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "DEFAULT" => $USER->GetLastName()." ".$USER->GetFirstName()." ".$USER->GetID(),
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Сотрудник'
            ],
			"1169" => [
                "TYPE" => "SELECT",
                "OPTIONS" => ['Оплачиваемый','Неоплачиваемый', 'Плановый'],
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Вид отпуска'
            ],
			"1170" => [
                "TYPE" => "DATE",
                "NECESSARILY" => 'Y',
                "MIN" => "TODAY",
                "QUESTION" => 'Дата начала отпуска'
            ],
			"1171" => [
                "TYPE" => "DATE",
                "MIN" => "TODAY",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Дата завершения отпуска (включительно)'
            ],
			"1172" => [
                "OPTIONS" => ['Да'],
                "TYPE" => "CHECKBOX",
                "NECESSARILY" => 'Y',
                "INVISIBLE" => 'Y',
                "QUESTION" => 'Даты отпуска подтверждены отделом кадров?'
            ],
        ]
    ],
    "868" => [ // НЕВЫХОД
        "TITLE" => "Редактирование невыхода",
        "ID_BP" => '482',
        "ACCESS" => [
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => [],
        ],
        "TOP_TEXT" => ["Введите сотрудника, отсутствующего на рабочем месте, и дату отсутствия."],
        "BOTTOM_TEXT" => [],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "Y",
        "VALUES" => [
            "1178" => [
                "TYPE" => "DATALIST",
                //"MY_EMPLOYEES" => 'Y',
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Сотрудник'
            ],
			"1177" => [
                "TYPE" => "DATE",
                "DEFAULT" => date('Y-m-d'),
                "NECESSARILY" => 'Y',
                "QUESTION" => 'День невыхода на работу'
            ],
        ]
    ],
    "869" => [ // БОЛЬНИЧНЫЙ
        "TITLE" => "Редактирование заявки на больничный",
        "ID_BP" => '483',
        "ACCESS" => [
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => [],
        ],
        "TOP_TEXT" => ["Введите даты выхода на больничный."],
        "BOTTOM_TEXT" => ["Если вы не знаете дату закрытия, напишите дату следующего посещения врача."],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "Y",
        "VALUES" => [
            "1181" => [
                "TYPE" => "DATALIST",
                //"MY_EMPLOYEES" => 'Y',
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "DEFAULT" => $USER->GetLastName()." ".$USER->GetFirstName()." ".$USER->GetID(),
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Сотрудник'
            ],
			"1180" => [
                "TYPE" => "DATE",
                "MIN" => "TODAY",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'День открытия больничного'
            ],
			"1179" => [
                "TYPE" => "DATE",
                "MIN" => "TODAY",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'День закрытия больничного'
            ],
        ]
    ],
    "870" => [ // ВЫХОД В ПРАЗДНИК
        "TITLE" => "Редактирование выхода в праздничный/выходной день",
        "ID_BP" => '484',
        "ACCESS" => [
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => [],
        ],
        "TOP_TEXT" => ["Прошу вас разрешить мне выйти на работу в связи со служебной необходимостью в мой выходной день на полный рабочий день."],
        "BOTTOM_TEXT" => ["Прошу вас оплатить отработанное время сверхурочно."],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "Y",
        "VALUES" => [
            "1185" => [
                "TYPE" => "DATALIST",
                //"MY_EMPLOYEES" => 'Y',
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "DEFAULT" => $USER->GetLastName()." ".$USER->GetFirstName()." ".$USER->GetID(),
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Сотрудник'
            ],
			"1184" => [
                "TYPE" => "DATE",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Выход на работу в день'
            ],
			"1183" => [
                "TYPE" => "TEXTAREA",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Комментарий<br>(какая работа будет выполняться и по каким тикетам)'
            ],
        ]
    ],
    "871" => [ // КОМАНДИРОВКА
        "TITLE" => "Редактирование командировки",
        "ID_BP" => '485',
        "ACCESS" => [
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => [],
        ],
        "TOP_TEXT" => [],
        "BOTTOM_TEXT" => [],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "Y",
        "VALUES" => [
            "1196" => [
                "TYPE" => "DATALIST",
                //"MY_EMPLOYEES" => 'Y',
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "DEFAULT" => $USER->GetLastName()." ".$USER->GetFirstName()." ".$USER->GetID(),
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Сотрудник'
            ],
			"1195" => [
                "TYPE" => "DATETIME",
                "MIN" => "TODAY",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Начало командировки'
            ],
			"1194" => [
                "TYPE" => "DATETIME",
                "MIN" => "TODAY",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Конец командировки'
            ],
			"1191" => [
                "TYPE" => "DATALIST",
                "LIST" => "MALLS",
                "PLACEHOLDER" => ' Введите тоговый центр',
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Тоговый центр/офис (можно не из списка)'
            ],
			"1189" => [
                "TYPE" => "TEXTAREA",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Комментарий<br>(какая работа будет выполняться и по каким тикетам)'
            ],
        ]
    ],
    "872" => [ // ОТКЛЮЧЕНИЕ ОТ ИС КОМПАНИИ
        "TITLE" => "Отключение от информационных систем компании",
        "ID_BP" => '486',
        "ACCESS" => [
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => [],
        ],
        "TOP_TEXT" => ["Введите данные:"],
        "BOTTOM_TEXT" => [],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "Y",
        "PRINT" => "Y",
        "VALUES" => [
            "1202" => [
                "TYPE" => "DATALIST",
                "LIST" => "USERS2",
                "PLACEHOLDER" => ' Введите ФИО сотрудника',
                "NECESSARILY" => 'Y',
                "QUESTION" => 'ФИО работника (если нет в списке, введите вручную)'
            ],
			"1198" => [
                "TYPE" => "DATETIME",
                "NECESSARILY" => 'Y',
                "DEFAULT" => date('Y-m-d').' '.(substr('0'.(date('H')+1), -2)).':'.date('i'),
                "QUESTION" => 'Дата и время планируемоего отключения'
            ],
			"1199" => [
                "OPTIONS" => ['Оставить компьютерную технику', 'Заблокировать как можно скорее','Не блокировать пропуск','Не блокировать учетные записи (напишите в комментарии, что необходимо  оставить и не блокировать: почта, портал, какие то другие системы)','Связаться для уточнения деталей блокировки'],
                "TYPE" => "CHECKBOX",
                "QUESTION" => 'Параметры'
            ],
			"1200" => [
                "TYPE" => "TEXTAREA",
                "QUESTION" => 'Комментарий'
            ],
			"1214" => [
                "TYPE" => "FILE",
                "MULTI" => 2,
                "QUESTION" => 'Вложения'
            ],
        ]
    ],
    "873" => [ // ЗВОНОК С ПРОФАЙЛА КОМПАНИИ
        "TITLE" => "Звонок с профайла компании",
        "ID_BP" => '497',
        "ACCESS" => [
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => [],
        ],
        "TOP_TEXT" => ["Введите данные:"],
        "BOTTOM_TEXT" => [],
        "RESTRICT_DELETION" => "Y",
        "RESTRICT_EDITING" => "Y",
        "VALUES" => [
            "1209" => [
                "TYPE" => "TEXT",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Тема звонка'
            ],
			"1210" => [
                "TYPE" => "TEXT",
                "QUESTION" => 'Название компании'
            ],
			"1211" => [
                "TYPE" => "TEXT",
                "QUESTION" => 'ФИО контактного лица/Должность'
            ],
			"1212" => [
                "TYPE" => "TEXT",
                "QUESTION" => 'Телефон для связи'
            ],
			"1213" => [
                "TYPE" => "TEXTAREA",
                "QUESTION" => 'Описание звонка'
            ],
        ]
    ]
];