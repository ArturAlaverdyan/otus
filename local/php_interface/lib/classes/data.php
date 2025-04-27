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
    "37" => [ // МАРКЕТПЛЕЙС/ПОКАЗАТЕЛИ
        "TITLE" => "Маркетплейс/показатели",
        "TITLE_LIST" => "Маркетплейс/показатели",
        "ACCESS" => [
            "READ" => ['user1'],
            "ADD" => ['user1'],
            "EDIT" => ['user1'],
            "DELETE" => ['user1'],
        ],
        "TOP_TEXT" => ["Данные за дату ".date("d.m.Y")],
        "BOTTOM_TEXT" => [],
        "COLUMNS" => [
            ['id' => 'NAME', 'name' => 'Название', 'sort' => 'NAME', 'default' => true],
            ['id' => 'CREATED_BY', 'name' => 'Автор', 'sort' => 'CREATED_BY', 'default' => true],
            ['id' => 'DATE_CREATE', 'name' => 'Дата создания', 'sort' => 'DATE', 'default' => true],
            ['id' => '116', 'name' => 'Марктеплейс', 'sort' => 'ID', 'default' => true],
            ['id' => '117', 'name' => 'Заказано шт.', 'sort' => 'ID', 'default' => true],
            ['id' => '118', 'name' => 'Заказано руб.', 'sort' => 'ID', 'default' => true],
            ['id' => '119', 'name' => 'Выкуплено шт.', 'sort' => 'ID', 'default' => true],
            ['id' => '120', 'name' => 'Выкуплено руб.', 'sort' => 'ID', 'default' => true],
            ['id' => '121', 'name' => 'Возврат шт.', 'sort' => 'ID', 'default' => true],
            ['id' => '122', 'name' => 'Возврат руб.', 'sort' => 'ID', 'default' => true],
            ['id' => '123', 'name' => 'Остаток шт.', 'sort' => 'ID', 'default' => true],
            ['id' => '124', 'name' => 'Остаток руб.', 'sort' => 'ID', 'default' => true],
            ['id' => 'FAVOURITES', 'name' => 'Избранное', 'sort' => 'ID', 'default' => true],
        ],
        "VALUES" => [
            "116" => [
                "TYPE" => "SELECT",
                "OPTIONS" => ['Ozon', 'Ламода', 'Wildberries', 'Мега маркет','Яндекс маркет'],
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Маркетплейс'
            ],
			"117" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "first",
                "LABEL_AFTER" => "шт.",
                "QUESTION" => 'Заказано'
            ],
			"118" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "first",
                "LABEL_AFTER" => "руб.",
                "QUESTION" => 'Заказано'
            ],
			"119" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "second",
                "LABEL_AFTER" => "шт.",
                "QUESTION" => 'Выкуплено'
            ],
			"120" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "second",
                "LABEL_AFTER" => "руб.",
                "QUESTION" => 'Выкуплено'
            ],
			"121" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "third",
                "LABEL_AFTER" => "шт.",
                "QUESTION" => 'Возврат'
            ],
			"122" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "third",
                "LABEL_AFTER" => "руб.",
                "QUESTION" => 'Возврат'
            ],
			"123" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "four",
                "LABEL_AFTER" => "шт.",
                "QUESTION" => 'Остаток'
            ],
			"124" => [
                "TYPE" => "NUMBER",
                "NECESSARILY" => 'Y',
                "IS_CHANGEABLE" => "Y",
                "PAIRED_CODE" => "four",
                "LABEL_AFTER" => "руб.",
                "QUESTION" => 'Остаток'
            ],
        ]
    ],
    "33" => [ // ОТПУСК
        "TITLE" => "Редактирование отпуска",
        "TITLE_LIST" => "Список отпусков",
        "ID_BP" => '16',
        "ACCESS" => [
            "READ" => 'all',
            "ADD" => 'all',
            "EDIT" => 'author',
            "DELETE" => 'author',
        ],
        "TOP_TEXT" => ["Прошу предоставить вас мне:"],
        "BOTTOM_TEXT" => [],
        "COLUMNS" => [
            ['id' => 'NAME', 'name' => 'Название', 'sort' => 'NAME', 'default' => true],
            ['id' => 'STATUS', 'name' => 'Статус', 'sort' => 'STATUS', 'default' => true],
            ['id' => 'CREATED_BY', 'name' => 'Автор', 'sort' => 'CREATED_BY', 'default' => true],
            ['id' => 'DATE_CREATE', 'name' => 'Дата создания', 'sort' => 'DATE', 'default' => true],
            ['id' => '99', 'name' => 'Сотрудник', 'sort' => 'ID', 'default' => true],
            ['id' => '95', 'name' => 'Вид отпуска', 'sort' => 'ID', 'default' => true],
            ['id' => '96', 'name' => 'Начало отпуска', 'sort' => 'ID', 'default' => true],
            ['id' => '97', 'name' => 'Конец отпуска', 'sort' => 'ID', 'default' => true],
            ['id' => '102', 'name' => 'Кто подтвредил', 'sort' => 'ID', 'default' => true],
            ['id' => 'FAVOURITES', 'name' => 'Избранное', 'sort' => 'ID', 'default' => true],
        ],
        "VALUES" => [
            "99" => [
                "TYPE" => "DATALIST",
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "DEFAULT" => $USER->GetLastName()." ".$USER->GetFirstName()." ".$USER->GetID(),
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Сотрудник'
            ],
			"95" => [
                "TYPE" => "SELECT",
                "OPTIONS" => ['Оплачиваемый','Неоплачиваемый'],
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Вид отпуска'
            ],
			"96" => [
                "TYPE" => "DATE",
                "NECESSARILY" => 'Y',
                "MIN" => "TODAY",
                "QUESTION" => 'Дата начала отпуска'
            ],
			"97" => [
                "TYPE" => "DATE",
                "MIN" => "TODAY",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Дата завершения отпуска (включительно)'
            ],
			"98" => [
                "OPTIONS" => ['Да'],
                "TYPE" => "CHECKBOX",
                "NECESSARILY" => 'Y',
                "INVISIBLE" => 'Y',
                "QUESTION" => 'Вы точно проверили даты своего отпуска?'
            ],
        ]
    ],
    "34" => [ // БОЛЬНИЧНЫЙ
        "TITLE" => "Редактирование заявки на больничный",
        "TITLE_LIST" => "Редактирование заявки на больничный",
        "ID_BP" => '17',
        "ACCESS" => [
            "READ" => 'all',
            "ADD" => 'all',
            "EDIT" => [],
            "DELETE" => [],
        ],
        "TOP_TEXT" => ["Введите даты выхода на больничный."],
        "BOTTOM_TEXT" => ["Если вы не знаете дату закрытия, напишите дату следующего посещения врача."],
        "COLUMNS" => [
            ['id' => 'NAME', 'name' => 'Название', 'sort' => 'NAME', 'default' => true],
            ['id' => 'STATUS', 'name' => 'Статус', 'sort' => 'STATUS', 'default' => true],
            ['id' => 'CREATED_BY', 'name' => 'Автор', 'sort' => 'CREATED_BY', 'default' => true],
            ['id' => 'DATE_CREATE', 'name' => 'Дата создания', 'sort' => 'DATE', 'default' => true],
            ['id' => '106', 'name' => 'Сотрудник', 'sort' => 'ID', 'default' => true],
            ['id' => '105', 'name' => 'Дата начала больничного', 'sort' => 'ID', 'default' => true],
            ['id' => '104', 'name' => 'Дата окончания больничного', 'sort' => 'ID', 'default' => true],
            ['id' => 'FAVOURITES', 'name' => 'Избранное', 'sort' => 'ID', 'default' => true],
        ],
        "VALUES" => [
            "106" => [
                "TYPE" => "DATALIST",
                "LIST" => "USERS",
                "PLACEHOLDER" => ' Введите фамилию сотрудника',
                "DEFAULT" => $USER->GetLastName()." ".$USER->GetFirstName()." ".$USER->GetID(),
                "NECESSARILY" => 'Y',
                "QUESTION" => 'Сотрудник'
            ],
			"105" => [
                "TYPE" => "DATE",
                "MIN" => "TODAY",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'День открытия больничного'
            ],
			"104" => [
                "TYPE" => "DATE",
                "MIN" => "TODAY",
                "NECESSARILY" => 'Y',
                "QUESTION" => 'День закрытия больничного'
            ],
        ]
    ],
    "36" => [ // ИЗБРАННОЕ
        "TITLE_LIST" => "Избранное",
        "ACCESS" => [
            "READ" => 'all',
            "ADD" => '',
            "EDIT" => '',
            "DELETE" => '',
        ],
        "COLUMNS" => [
            ['id' => '110', 'name' => 'Заметка', 'sort' => 'ID', 'default' => true],
            ['id' => '113', 'name' => 'Описание', 'sort' => 'ID', 'default' => true],
            ['id' => 'DATE_CREATE', 'name' => 'Дата создания', 'sort' => 'DATE', 'default' => true],
        ],
    ],
];