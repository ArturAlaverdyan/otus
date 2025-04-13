<?php
namespace Otus\Rest;

use Bitrix\Main\EventManager;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Event;
use Bitrix\Rest\RestException;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);



class Events
{
   /**
    * @return [type]
    */
   public static function OnRestServiceBuildDescriptionHandler()
   {   
      Loc::getMessage('REST_SCOPE_OTUS.ORIGINALCONTACTSDATA');

      return [
            Loc::getMessage('REST_SCOPE_OTUS.ORIGINALCONTACTSDATA').' (otus.originalcontactsdata)' => [
                'otus.originalcontactsdata.add' => [__CLASS__, 'add'],
                'otus.originalcontactsdata.list' => [__CLASS__, 'getList'],
                'otus.originalcontactsdata.update' => [__CLASS__, 'update'],
                'otus.originalcontactsdata.delete' => [__CLASS__, 'delete'],
            ]
      ];
   }


   /**
    * @param mixed $arParams
    * @param mixed $navStart
    * @param \CRestServer $server
    * 
    * @return [type]
    */
   public static function add ($arParams, $navStart, \CRestServer $server)
   {
        $originDataStoreResult = OriginalContactsDataTable::add($arParams);
        if ($originDataStoreResult->isSuccess())
        {
            Debug::writeToFile('добавили элемент '.$originDataStoreResult->getId(), "MY REST", '/logs/my_rest_logs.log');
            return $originDataStoreResult->getId();
        }
        else
        {
            Debug::writeToFile('ошибка добавления '.$originDataStoreResult->getErrorMessages(), "MY REST", '/logs/my_rest_logs.log');
            throw new RestException(json_encode($originDataStoreResult->getErrorMessages(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }
    }


    /**
     * @param mixed $arParams
     * @param mixed $navStart
     * @param \CRestServer $server
     * 
     * @return [type]
     */
    public static function getList ($arParams, $navStart, \CRestServer $server)
    {
        $arElements = OriginalContactsDataTable::getList([
            'filter' => $arParams['filter'] ?: [],
            'select' => $arParams['select'] ?: ['*'],
            'order' => $arParams['order'] ? [$arParams['order']['by'] => $arParams['order']['direction']] : ['ID' => 'ASC'],
            'group'  => $arParams['group'] ?: [],
            'limit' => $arParams['limit'] ?: 0,
            'offset' => $navStart ?: 0,
        ])->fetchAll();

        $stringRes = json_encode($arElements, JSON_UNESCAPED_UNICODE);

        Debug::writeToFile($stringRes, "MY REST", '/logs/my_rest_logs.log');


        return $arElements;


    }

   
    /**
     * @param mixed $arParams
     * @param mixed $navStart
     * @param \CRestServer $server
     * 
     * @return [type]
     */
    public static function update ($arParams, $navStart, \CRestServer $server)
    {
            $entityId = intval($arParams['ID']);
            unset($arParams['ID']);
    
            $originDataStoreResult = OriginalContactsDataTable::update($entityId, $arParams);
            if ($originDataStoreResult->isSuccess())
            {
                Debug::writeToFile('обновили элемент '.$entityId, "MY REST", '/logs/my_rest_logs.log');
                return $originDataStoreResult->getId();
            }
            else
            {
                Debug::writeToFile('ошибка обновления '.$originDataStoreResult->getErrorMessages(), "MY REST", '/logs/my_rest_logs.log');
                throw new RestException(json_encode($originDataStoreResult->getErrorMessages(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
            }
    }

    
    /**
     * @param mixed $arParams
     * @param mixed $navStart
     * @param \CRestServer $server
     * 
     * @return [type]
     */
    public static function delete ($arParams, $navStart, \CRestServer $server)
    {
        $entityId = intval($arParams['ID']);
        $originDataStoreResult = OriginalContactsDataTable::delete($entityId);

        if ($originDataStoreResult->isSuccess())
        {
            Debug::writeToFile('удалили элемент '.$entityId, "MY REST", '/logs/my_rest_logs.log');
            return true;
        }
        else
        {
            Debug::writeToFile('ошибка удаления '.$originDataStoreResult->getErrorMessages(), "MY REST", '/logs/my_rest_logs.log');
            throw new RestException(json_encode($originDataStoreResult->getErrorMessages(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }
    }
}