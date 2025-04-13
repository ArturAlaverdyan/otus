<?php
namespace Otus\Rest;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;

/**
 * Class OriginalContactsDataTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> ENTITY_ID int mandatory
 * <li> VALUE string(20) mandatory
 * </ul>
 *
 * @package Bitrix\Original
 **/

class OriginalContactsDataTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'otus_original_status_data';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			'ID' => (new IntegerField('ID',
					[]
				))->configureTitle(Loc::getMessage('STATUS_DATA_ENTITY_ID_FIELD'))
						->configurePrimary(true)
			,
			'ENTITY_ID' => (new IntegerField('ENTITY_ID',
					[]
				))->configureTitle(Loc::getMessage('STATUS_DATA_ENTITY_ENTITY_ID_FIELD'))
						->configureRequired(true)
			,
			'VALUE' => (new StringField('VALUE',
					[
						'validation' => function()
						{
							return[
								new LengthValidator(null, 20),
							];
						},
					]
				))->configureTitle(Loc::getMessage('STATUS_DATA_ENTITY_VALUE_FIELD'))
						->configureRequired(true)
			,
		];
	}
}