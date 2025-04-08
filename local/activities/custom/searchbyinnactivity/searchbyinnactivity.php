<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Bizproc\Activity\BaseActivity;
use Bitrix\Bizproc\FieldType;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Localization\Loc;
use Bitrix\Bizproc\Activity\PropertiesDialog;
class CBPSearchByInnActivity extends BaseActivity
{
    // protected static $requiredModules = ["crm"];
    public function __construct($name)
    {
        parent::__construct($name);

        $this->arProperties = [
            'Inn' => '',
            'Text' => null,
        ];

        $this->SetPropertiesTypes([
            'Text' => ['Type' => FieldType::STRING],
        ]);
    }


    protected static function getFileName(): string
    {
        return __FILE__;
    }


    protected function internalExecute(): ErrorCollection
    {
        $errors = parent::internalExecute();

        $token = "2e1453e2322d6e26d3ba6b65205d85a500e43ef3";
        $secret = "c9f05d009e44ee1beb26cc3fd79dff12e2546575";

        $dadata = new Dadata($token, $secret);
        $dadata->init();

        $fields = array("query" => $this->Inn, "count" => 5);
        $response = $dadata->suggest("party", $fields);

        $companyName = 'Компания не найдена!';
        if(!empty($response['suggestions'])){ // если копания найдена
            // по ИНН возвращается массив в котором может бытьнесколько элементов (компаний)
            $companyName = $response['suggestions'][0]['value']; // получаем имя компании из первого элемента
        }

        $this->preparedProperties['Text'] = $companyName;
        $this->log($this->preparedProperties['Text']);

        $rootActivity = $this->GetRootActivity();
        $rootActivity->SetVariable("inn", $this->preparedProperties['Text']);

        /*
        // получение значения полей документа в активити
        $documentType = $rootActivity->getDocumentType();
        $documentId = $rootActivity->getDocumentId();
        $documentService = CBPRuntime::GetRuntime(true)->getDocumentService();

        // поля документа
        $documentFields =  $documentService->GetDocumentFields($documentType);
        foreach ($documentFields as $key => $value) {
            if($key == 'UF_CRM_1718872462762'){ // поле номер ИНН
                $fieldValue = $documentService->getFieldValue($documentId, $key, $documentType);
                $this->log('значение поля Инн:'.' '.$fieldValue);
            }

            if($key == 'UF_CRM_TEST'){ // поле TEST
                $fieldValue = $documentService->getFieldValue($documentId, $key, $documentType);
                $this->log('значение поля TEST:'.' '.$fieldValue);
            }
        }*/

        return $errors;
    }


    public static function getPropertiesDialogMap(?PropertiesDialog $dialog = null): array
    {
        $map = [
            'Inn' => [
                'Name' => Loc::getMessage('SEARCHBYINN_ACTIVITY_FIELD_SUBJECT'),
                'FieldName' => 'inn',
                'Type' => FieldType::STRING,
                'Required' => true,
                'Options' => [],
            ],
        ];

        return $map;
    }
}