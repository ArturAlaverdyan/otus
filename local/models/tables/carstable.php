<?php
namespace Models\Tables;

use \Bitrix\Main\Entity\ReferenceField;
use \Bitrix\Main\ORM\Data\DataManager;
use \Models\AbstractIblockPropertyValuesTable;

class CarsTable extends AbstractIblockPropertyValuesTable
{
    const IBLOCK_ID = 16;

    public static function getEntity () {
     return '\Models\Tables\CarsTable';
    }

    public static function getMap(): array {
        $map = [
            'CLIENTS' => new ReferenceField(
                'CLIENTS',
                ClientsTable::class,
                ['=this.CLIENT_ID' => 'ref.IBLOCK_ELEMENT_ID']
            )
        ];
        return parent::getMap() + $map; // TODO: Change the autogenerated stub
    }

}