<?php

class DoctorsComp
{
    public static function getDataDoctors ()
    {
        $docs = \Models\Tables\DoctorsTable::query()
            ->setSelect([
                'ID' => 'ELEMENT.ID',
                'FAMILIYA',
                'IMYA',
                'OTCHESTVO',
                'PROCEDURES_ID'
            ])
            ->fetchAll();

            $result = [];
            foreach($docs as $el)
            {
                $result[$el['ID']] = $el;
            }

            return $result;
    }

    public static function getDataProcedures ()
    {
        $proc = \Models\Tables\ProceduresTable::query()
            ->setSelect([
                'ID' => 'ELEMENT.ID',
                'NAME' => 'ELEMENT.NAME'
            ])
        ->fetchAll();

        $result = [];
        foreach($proc as $el)
        {
            $result[$el['ID']] = $el['NAME'];
        }

        return $result;
    }

    public static function createElement ($arr) {

        if (!empty($arr['buttSend']))
        {
            if (!empty($arr['newProcedur'])) {
                $res = [];
                $res['NAME'] = $arr['newProcedur'];
                \Models\Tables\ProceduresTable::add($res);
            }
            if (!empty($arr['FAMILIYA'])) {
                print_r($arr['PROCEDURES_ID']);
                $res['NAME'] = 'Созано через Model';
                $res['FAMILIYA'] = $arr['FAMILIYA'];
                $res['IMYA'] = $arr['IMYA'];
                $res['OTCHESTVO'] = $arr['OTCHESTVO'];
                $res['PROCEDURES_ID'] = $arr['PROCEDURES_ID'];
                \Models\Tables\DoctorsTable::add($res);
            }
        }
    }

}